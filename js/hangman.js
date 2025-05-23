/* Hangman JS class. Ported over from PHP. */
class Hangman {
  #word;                  // The word players must guess
  #guessedLetters = [];   // Storage for bad guesses
  #maxAttempts;           // Maximum bad guesses
  #currentAttempts = 0;   // Counter for bad guesses the player has made

  constructor(word, maxAttempts = 7) {
    this.#maxAttempts = maxAttempts;
    this.#word = word;
  }

  // Method to guess a letter
  guess(letter) {
    letter = letter.toUpperCase();

    if (this.#guessedLetters.includes(letter)) {
      return false; // Already guessed
    }

    this.#guessedLetters.push(letter);

    if (!this.#word.includes(letter)) {
      this.#currentAttempts++;
      return false;
    }

    return true;
  }

  isWon() {
    return [...this.#word].every(letter => this.#guessedLetters.includes(letter));
  }

  isLost() {
    return this.#currentAttempts >= this.#maxAttempts;
  }

  getGuessedLetters() {
    return this.#guessedLetters;
  }

  getAttemptsLeft() {
    return this.#maxAttempts - this.#currentAttempts;
  }

  getWordProgress() {
    return [...this.#word].map(letter => (this.#guessedLetters.includes(letter) ? letter : '_')).join('');
  }

  getWord() {
    return this.#word;
  }
}

const url = "https://random-word-api.vercel.app/api?words=1";
fetch(url).then(response => {
  if ( response.ok ) {
    response.json().then( words => {
      startGame(new Hangman(words[0].toUpperCase()));
    });
  } else {
    console.log('sdf');
  }
}).catch( error => {
  console.log('API Error',error);
  startGame(new Hangman('APEX'.toUpperCase()));
});

function startGame(game) {
  console.log('Ssh, the word is', game.getWord());

  document.querySelectorAll('.currentWord').forEach(function(element) {
    element.innerHTML = game.getWord();
  });

  const inputField = document.getElementById("userInput");
  inputField.addEventListener("keyup", function (event) {

    if ( game.isWon() || game.isLost() ) {
      return;
    }

    const messageDisplay = document.getElementById('messageDisplay');
    const messageField   = document.getElementById('message');
    let   message        = '';

    // Reset the message display to none
    messageDisplay.style.display = 'none';

    // Is it a valid entry?
    if ( /^[a-zA-Z]$/.test(event.key) ) {
      if ( game.guess( event.key ) ) {
        message = "Correct!";
      } else {
        message = "Wrong!";
      }
    }

    // Update the progress display
    updateWordProgress();

    // Update guessed letters
    const guessedLetters = document.getElementById('guessedLetters');
    guessedLetters.innerHTML = game.getGuessedLetters();

    const attemptsLeft = document.getElementById('attemptsLeft');
    attemptsLeft.innerHTML = 'Attempts Left: ' + game.getAttemptsLeft();

    if ( game.isWon() ) {
      const hasWon  = document.getElementById('hasWon');
      hasWon.style.display = 'block';

      // Display some confetti :)
      // https://github.com/catdad/canvas-confetti?tab=readme-ov-file
      confetti({
        particleCount: 100,
        spread: 70,
        origin: { y: 0.6 }
      });
    }
    if ( game.isLost() ) {
      const hasLost = document.getElementById('hasLost');
      hasLost.style.display = 'block';
    }

    if ( message ) {
      messageField.innerHTML = message;
      messageDisplay.style.display = 'block';
    }

    // Clear out the text field
    this.value = '';
  });

  function updateWordProgress() {
    const wordProgress = document.getElementById('wordProgress');
    wordProgress.innerHTML = game.getWordProgress();
  }

  // Allow the button to reset the game (by reloading)
  const resetGame = document.getElementById("resetGame");
  resetGame.addEventListener("click", function (event) {
    window.location.reload();
  });

  // Default state
  updateWordProgress();

}

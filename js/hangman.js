/* Hangman JS class. Ported over from PHP. */
class Hangman {
  #word;                  // The word players must guess
  #guessedLetters = [];   // Storage for bad guesses
  #maxAttempts;           // Maximum bad guesses
  #currentAttempts = 0;   // Counter for bad guesses the player has made

  constructor(maxAttempts = 7) {
    this.#maxAttempts = maxAttempts;
    this.#word = this.#getRandomWord();
  }

  // Private method to get a random word
  #getRandomWord() {
    const words = ['DUCK', 'HANDLE', 'MOUSE', 'SPRING', 'FIDDLE', 'THERMALDYNAMICS', 'SONIC', 'MOUNTAIN', 'PUPPET', 'APEX'];
    return words[Math.floor(Math.random() * words.length)];
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
    let hasWon = true;
    [...this.word].forEach(letter => {
      if (!this.#guessedLetters.includes(letter)) {
        hasWon = false;
      }
    });
    return hasWon;
  }

  isLost() {
    return this.#currentAttempts >= this.maxAttempts;
  }

  getGuessedLetters() {
    return this.#guessedLetters;
  }

  getAttemptsLeft() {
    return this.#maxAttempts - this.#currentAttempts;
  }

  getWordProgress() {
    let progressStr = '';
    [...this.#word].forEach(letter => {
      if (this.#guessedLetters.includes(letter)) {
        progressStr += letter;
      } else {
        progressStr += '_';
      }
      progressStr += ' ';
    });
    return progressStr.trimEnd();
  }

  getWord() {
    return this.#word;
  }
}

const game = new Hangman();

document.querySelectorAll('.currentWord').forEach(function(element) {
  element.innerHTML = game.getWord();
});

const inputField = document.getElementById("userInput");
inputField.addEventListener("keyup", function (event) {

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

  if ( game.hasWon ) {

  }
  if ( game.hasLost ) {

  }

  if ( message ) {
    messageField.innerHTML = message;
    messageDisplay.style.display = 'block';
  }
});

function updateWordProgress() {
  const wordProgress = document.getElementById('wordProgress');
  wordProgress.innerHTML = game.getWordProgress();
}

// Default state
updateWordProgress();




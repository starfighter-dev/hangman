import { useState } from 'react'
import Button from 'react-bootstrap/Button';
import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Row';
import 'bootstrap/dist/css/bootstrap.min.css';

const words = ['react', 'apex', 'deep', 'understanding', 'twat', 'bacon', 'stack', 'helicopter', 'tuesday'];

const getRandomWord = () => {
  return words[Math.floor(Math.random() * words.length)].toLowerCase();
};

const MAX_ATTEMPTS = 6;

const Hangman = () => {
  const [word, setWord] = useState(getRandomWord);
  const [guessedLetters, setGuessedLetters] = useState([]);
  const [attempts, setAttempts] = useState(0);
  const [gameOver, setGameOver] = useState(false);

  const maskedWord = word
    .split('')
    .map(letter => (guessedLetters.includes(letter) ? letter : '_'))
    .join(' ');

  const handleGuess = letter => {
    if (gameOver || guessedLetters.includes(letter)) return;
    const updatedGuesses = [...guessedLetters, letter];
    setGuessedLetters(updatedGuesses);

    if (!word.includes(letter)) {
      const newAttempts = attempts + 1;
      setAttempts(newAttempts);
      if (newAttempts >= MAX_ATTEMPTS) {
        setGameOver(true);
      }
    } else if (word.split('').every(l => updatedGuesses.includes(l))) {
      setGameOver(true);
    }
  };

  const restartGame = () => {
    setWord(getRandomWord());
    setGuessedLetters([]);
    setAttempts(0);
    setGameOver(false);
  };

  return (
    <Container>
      <Row>
        <Col className="text-center">
          <h1 className="fw-light p-4">Hangman React</h1>
          <h2 className="p-4">{maskedWord}</h2>
          <div className="pt-4 pb-4">
            {'abcdefghijklmnopqrstuvwxyz'.split('').map(letter => (
              <Button
                className="m-1"
                variant="secondary"
                key={letter}
                onClick={() => handleGuess(letter)}
                disabled={guessedLetters.includes(letter) || gameOver}
              >
                {letter}
              </Button>
            ))}
          </div>
          <p className="p-4">Attempts: {attempts} / {MAX_ATTEMPTS}</p>
          {gameOver && (
            <div>
              <h2 className="text-lg font-semibold">
                {word.split('').every(l => guessedLetters.includes(l))
                  ? 'You Win!'
                  : `Game Over! The word was "${word}".`}
              </h2>
              <Button onClick={restartGame} className="mt-4">Restart</Button>
            </div>
          )}
        </Col>
      </Row>
    </Container>
  );
};

export default Hangman;

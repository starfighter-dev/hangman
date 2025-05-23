<?php

class Hangman {

        private string $word;                   // The word players must guess
        private array $guessedLetters = [];     // Storage for guessed letters
        private int $maxAttempts;               // Maximum bad guesses (7), but allow it to be changed
        private int $currentAttempts = 0;       // Counter for bad guesses the player has made so far

        public function __construct(int $maxAttempts = 7) {
            $this->maxAttempts = $maxAttempts;
            $this->word        = $this->getRandomWord();
        }

        // A user has given us a character to try, return success or failure
        public function guess(string $letter): bool {
            $letter = strtoupper($letter);

            // They already guessed this one, give them a free pass
            if ( in_array($letter, $this->guessedLetters) ) {
                return false;
            }
            $this->guessedLetters[] = $letter;
            if ( strpos($this->word, $letter) === false ) {
                $this->currentAttempts++;
                return false;
            }
            return true; // woot.
        }

        // Has the game been won?
        public function isWon(): bool {
            return false;
        }

        // Has the game been lost?
        public function isLost(): bool {
            return $this->currentAttempts >= $this->maxAttempts;
        }

        // Return the number of attempts remaining for the client
        public function getAttemptsLeft(): int {
            return $this->maxAttempts - $this->currentAttempts;
        }

        // Return array of guessed letters for the client
        public function getGuessedLetters(): array {
            return $this->guessedLetters;
        }

        // Return a string countaining a representation of the current
        // progress. This will contain underscores for missing letters
        public function getWordProgress(): string {
            $progress = '';
            foreach (str_split($this->word) as $char) {
                $progress .= "_ ";
            }
            return trim($progress);
        }

        // Return a random word. TODO: Get a list from a dictionary file or API
        private function getRandomWord(): string {
            $words = [
                'DUCK',
                'HANDLE',
                'MOUSE',
                'SPRING',
                'FIDDLE',
                'THERMALDYNAMICS',
                'SONIC',
                'MOUNTAIN',
                'PUPPET'
            ];

            return $words[array_rand($words, 1)];
        }

}
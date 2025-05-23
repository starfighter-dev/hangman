<?php

class Hangman {

        private string $word;                   // The word players must guess
        private array $guessedLetters = [];     // Storage for guessed letters
        private int $maxAttempts;               // Maximum bad guesses (7), but allow it to be changed
        private int $currentAttempts = 0;       // Counter for bad guesses the player has made so far

        public function __construct(int $maxAttempts = 7) {
            $this->maxAttempts = $maxAttempts;
            $this->word        = $this->getRandomWord();
            var_dump($this->word);
        }

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
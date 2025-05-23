<?php

require_once 'Hangman.php';

$game = new Hangman();

print "Welcome to Hangman!\n";

// Konami Code Mode:
//print "\nThe word is: " . $game->getWord() . "\n";

// A game loop
while (!$game->isWon() && !$game->isLost()) {
    print "\nWord: " . $game->getWordProgress() . "\n";
    print "Guessed: " . implode(', ', $game->getGuessedLetters()) . "\n";
    print "Attempts left: " . $game->getAttemptsLeft() . "\n";

    // User input
    print "Guess a letter: ";
    $input = trim(fgets(STDIN));
    if ( strlen($input) !== 1 || !ctype_alpha($input) ) {
        // Oops, bad input.
        print "Please enter a single letter.\n";
        continue;
    }

    if ( $game->guess($input) ) {
        echo "\nCorrect!\n";
    } else {
        echo "\nWrong!\n";
    }
}

if ( $game->isWon() ) {
    print "\nCongratulations! You guessed the word: " . $game->getWord() . "\n";
} else {
    print "\nGame over! The word was: " . $game->getWord() . "\n";
}


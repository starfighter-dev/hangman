<?php

require_once 'Hangman.php';

$game = new Hangman();

print "Welcome to Hangman!\n";

// A game loop
while (!$game->isWon() && !$game->isLost()) {
    print "\nWord: " . $game->getWordProgress() . "\n";
    print "Guessed: " . implode(', ', $game->getGuessedLetters()) . "\n";
    print "Attempts left: " . $game->getAttemptsLeft() . "\n";


    exit;





}

if ( $game->isWon() ) {
    print "Congratulations!\n";
} else {
    print "Sorry, you lost.\n";
}


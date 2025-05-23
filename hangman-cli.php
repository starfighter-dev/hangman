<?php

require_once 'Hangman.php';

$game = new Hangman();

print $game->getWordProgress();
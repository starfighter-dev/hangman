# hangman

A simple Hangman game

## Basic Rules

- Number of Guesses (7)
- Random word
- Correct guess population
- Incorrect guess storage

## Implementation

### PHP CLI Mode

A simple cli runner for the game.

    php hangman-cli.php

A game loop is started, and a player can play a game of Hangman.

### PHP Web Based Mode

This uses the same Hangman code from the cli version, but now presented in the form of a website. The file can be hosted somewhere, or accessed through this link (which I will remember to deploy!):

- [Hangman PHP Web Version](https://www.starfighter.dev/hangman/hangman-web.php)

The will use simple form posts and probably utlise Session for state.


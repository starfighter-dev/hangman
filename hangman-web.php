<?php
session_start();
require_once 'Hangman.php';

if ( !isset($_SESSION['game']) || isset($_POST['reset']) ) {
   $_SESSION['game'] = serialize(new Hangman());
}

$game = unserialize($_SESSION['game']);

$message = '';
if ( isset($_POST['letter']) ) {
   $input = strtoupper(trim($_POST['letter']));
   if ( strlen($input) !== 1 || !ctype_alpha($input) ) {
      $message = "Please enter a single letter.";
   } elseif ( in_array($input, $game->getGuessedLetters()) ) {
      $message = "You already guessed '$input'.";
   } else {
      if ( $game->guess($input) ) {
         $message = "Correct!";
      } else {
         $message = "Wrong!";
      }
   }
   $_SESSION['game'] = serialize($game);
}

?><!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Hangman</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <style type="text/css">
         .wordProgress {
            font-size: 2em;
            letter-spacing: 0.2em;
         }
      </style>
   </head>
   <body>
      <h1>Hangman</h1>
      <h2>Word is: <?= $game->getWord() ?></h2>
      <div class="wordProgress"><?= $game->getWordProgress() ?></div>
      <div class="guessedLetters"><?= implode(', ', $game->getGuessedLetters()) ?></div>
      <div class="attemptsLeft">Attempts Left: <?= $game->getAttemptsLeft() ?></div>
      <?php if ($message): ?>
         <div class="alert alert-info"><?= $message ?></div>
      <?php endif; ?>
      <?php if ( !$game->isWon() && !$game->isLost() ): ?>
         <form method="post">
            <label for="letter">Guessed a letter:</label>
            <input type="text" name="letter" maxlength="1" required autofocus />
            <button type="submit" class="btn btn-primary">Guess</button>
         </form>
      <?php endif; ?>
      <?php if ($game->isWon()): ?>
         <div class="message">Congratulations! You guessed the word: <strong><?= $game->getWord() ?></strong></div>
       <?php elseif ($game->isLost()): ?>
         <div class="message wrong">Game over! The word was: <strong><?= $game->getWord() ?></strong></div>
      <?php endif; ?>

      <form method="post">
         <button type="submit" name="reset" value="martin" class="btn btn-secondary">
            Restart Game
         </button>
      </form>


   </body>
</html>

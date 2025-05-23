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
         .gameoverText {
            color: red;
            font-size: 3em;
         }
         .rainbowText {
            font-size: 3em;
            background: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
         }
         .guessedLetters {
            font-size: 2em;
            letter-spacing: 0.2em;
            color: red;
         }
      </style>
   </head>
   <body>
      <div class="container">
         <div class="row mt-4">
            <div class="col text-center">
               <h1 class="rainbowText">Hangman</h1>
               <?= isset($_GET['konamicode']) ? "<h2>Current word is: " . $game->getWord() . "</h2>" : "" ?>
            </div>
         </div>
         <div class="row">
            <div class="col text-center">
               <div class="wordProgress"><?= $game->getWordProgress() ?></div>
            </div>
         </div>

         <div class="row mt-4">
            <div class="col text-center">
               <div class="guessedLetters"><?= implode(', ', $game->getGuessedLetters()) ?></div>
               <div class="attemptsLeft">Attempts Left: <?= $game->getAttemptsLeft() ?></div>
            </div>
         </div>

         <?php if ($message && !$game->isWon() ): ?>
            <div class="row mt-4">
               <div class="col text-center">
                  <div class="alert alert-info"><?= $message ?></div>
               </div>
            </div>
         <?php endif; ?>
         <?php if ( !$game->isWon() && !$game->isLost() ): ?>
            <div class="row mt-4">
               <div class="col text-center">
                  <form method="post">
                     <label for="letter">Guessed a letter:</label>
                     <input type="text" name="letter" maxlength="1" required autofocus />
                     <button type="submit" class="btn btn-primary">Guess</button>
                  </form>
               </div>
            </div>
         <?php endif; ?>

         <div class="row mt-4">
            <div class="col text-center">
               <form method="post">
                  <button type="submit" name="reset" value="martin" class="btn btn-secondary">
                     Restart Game
                  </button>
               </form>
            </div>
         </div>

         <?php if ($game->isWon()): ?>
            <div class="row mt-4">
               <div class="col text-center rainbowText">
                  Congratulations! You guessed the word: <strong><?= $game->getWord() ?></strong>
               </div>
            </div>
         <?php elseif ($game->isLost()): ?>
            <div class="row mt-4">
               <div class="col text-center gameoverText">
                  Game over! The word was: <strong><?= $game->getWord() ?></strong>
               </div>
            </div>
         <?php endif; ?>


      </div>


   </body>
</html>

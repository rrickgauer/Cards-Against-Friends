<?php

// connects to DB
// returns the PDO connection
function dbConnect() {
  include('db-info.php');

  try {
    // connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;

  } catch(PDOexception $e) {
      return 0;
  }
}

// inserts a new game into db
function insertNewGame($name) {
   $pdo = dbConnect();
   $sql = $pdo->prepare('INSERT INTO Games (name, creation_date) VALUES (:name, NOW())');

   // filter variables
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   // bind the parameters
   $sql->bindParam(':name', $name, PDO::PARAM_STR);

   // execute sql statement
   $sql->execute();

   // close the pdo connections
   $pdo = null;
   $sql = null;
}

// get the id of most recently created game
function getMostRecentCreatedGameData() {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT * FROM Games ORDER BY creation_date DESC LIMIT 1');
  $sql->execute();

  return $sql->fetch(PDO::FETCH_ASSOC);
}

// sets a todo list item as complete
function getConnectedPlayersData($gameID) {
   $pdo = dbConnect();
   $sql = $pdo->prepare('SELECT * FROM Players where Players.game_id=:gameID');

   // filter variables
   $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);

   // bind the parameters
   $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);

   // execute sql statement
   $sql->execute();
   return $sql;
}

function insertPlayer($gameID, $username) {
   $pdo = dbConnect();
   $sql = $pdo->prepare('INSERT INTO Players (game_id, username) values (:gameID, :username)');

   // filter variables
   $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);
   $username = filter_var($username, FILTER_SANITIZE_STRING);

   // bind the parameters
   $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);
   $sql->bindParam(':username', $username, PDO::PARAM_STR);


   // execute sql statement
   $sql->execute();



}


function isGameIDValid($gameID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT id FROM Games WHERE id=:gameID');

  // filter variables
  $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);

  // bind the parameters
  $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);

  // execute sql statement
  $sql->execute();

  if ($sql->rowCount() > 0) {
    return true;
  } else {
    return false;
  }

}

function isUsernameValid($gameID, $username) {
   $pdo = dbConnect();
   $sql = $pdo->prepare('SELECT id FROM Players WHERE id=:gameID AND username=:username');

   // filter variables
   $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);
   $username = filter_var($username, FILTER_SANITIZE_STRING);

   // bind the parameters
   $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);
   $sql->bindParam(':username', $username, PDO::PARAM_STR);

   // execute sql statement
   $sql->execute();

   if ($sql->rowCount() == 0) {
     return true;
   } else {
     return false;
   }
}

function getPlayerDataFromUsername($gameID, $username) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT * FROM Players WHERE game_id=:gameID AND username=:username LIMIT 1');

  // filter variables
  $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);
  $username = filter_var($username, FILTER_SANITIZE_STRING);

  // bind the parameters
  $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);

  // execute sql statement
  $sql->execute();

  return $sql->fetch(PDO::FETCH_ASSOC);
}

function getGameData($gameID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT * FROM Games WHERE id=:gameID LIMIT 1');

  // filter variables
  $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);

  // bind the parameters
  $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);

  // execute sql statement
  $sql->execute();

  return $sql->fetch(PDO::FETCH_ASSOC);
}



?>

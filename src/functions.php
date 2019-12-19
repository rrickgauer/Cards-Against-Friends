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
  // $row = $sql->fetch(PDO::FETCH_ASSOC);


}
?>

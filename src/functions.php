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

function getCategoriesData() {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT * FROM Categories');
  $sql->execute();

  return $sql;
}

function insertSelectedGameCategories($gameID, $categoryID) {

  $pdo = dbConnect();
  // $sql = $pdo->prepare('SELECT * FROM Players WHERE game_id=:gameID AND username=:username LIMIT 1');


  $sql = $pdo->prepare('INSERT INTO Selected_Categories (game_id, category_id) VALUES (:gameID, :categoryID)');

  // filter variables
  $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);
  $categoryID = filter_var($categoryID, FILTER_SANITIZE_NUMBER_INT);


  // bind the parameters
  $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);
  $sql->bindParam(':categoryID', $categoryID, PDO::PARAM_INT);


  // execute sql statement
  $sql->execute();


}

function getSelectedGameCategories($gameID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT Selected_Categories.game_id, Selected_Categories.category_id, Categories.name from Selected_Categories, Categories WHERE Selected_Categories.category_id=Categories.id and Selected_Categories.game_id=:gameID');

  // filter variables
  $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);

  // bind the parameters
  $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);


  // execute sql statement
  $sql->execute();

  return $sql;
}

function getGameCardLimit($gameID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT ((SELECT Games.rounds from Games where id=:gameID) * (SELECT count(*) from Players where game_id=:gameID)) as "product"');

  // filter variables
  $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);

  // bind the parameters
  $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);

  // execute sql statement
  $sql->execute();

  $result = $sql->fetch(PDO::FETCH_ASSOC);
  return $result['product'];
}

function getRandomBlackDeck($gameID, $limit) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT BlackCards.id from BlackCards, Selected_Categories where BlackCards.category_id=Selected_Categories.category_id and Selected_Categories.game_id=:gameID order by rand() limit :setLimit');

  // filter variables
  $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);
  $limit = filter_var($limit, FILTER_SANITIZE_NUMBER_INT);

  // bind the parameters
  $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);
  $sql->bindParam(':setLimit', $limit, PDO::PARAM_INT);

  // execute sql statement
  $sql->execute();

  return $sql;
}

function updateAllSubmittedQuestions($gameID, $open) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('UPDATE Submitted_Questions SET open=:open WHERE game_id=:gameID');

  // filter variables
  $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);
  $open = filter_var($open, FILTER_SANITIZE_STRING);

  // bind the parameters
  $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);
  $sql->bindParam(':open', $open, PDO::PARAM_STR);

  // execute sql statement
  $sql->execute();
}


function insertSubmittedQuestion($gameID, $blackCardID) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('INSERT INTO Submitted_Questions (game_id, blackcard_id, open) VALUES (:gameID, :blackCardID, :open)');

  // filter variables
  $gameID = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);
  $blackCardID = filter_var($blackCardID, FILTER_SANITIZE_NUMBER_INT);

  $open = 'y';

  // bind the parameters
  $sql->bindParam(':gameID', $gameID, PDO::PARAM_INT);
  $sql->bindParam(':blackCardID', $blackCardID, PDO::PARAM_INT);
  $sql->bindParam(':open', $open, PDO::PARAM_STR);

  // execute sql statement
  $sql->execute();
}

function getBlackCardData($id) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT * FROM BlackCards WHERE id=:id');

  // filter variables
  $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

  // bind the parameters
  $sql->bindParam(':id', $id, PDO::PARAM_INT);

  // execute sql statement
  $sql->execute();
  $blackCard = $sql->fetch(PDO::FETCH_ASSOC);
  return $blackCard;
}
?>

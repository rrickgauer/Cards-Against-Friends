<?php

include_once('functions.php');

// set all submitted questions for this game to open: no
updateAllSubmittedQuestions($_GET['gameID'], 'n');

// add card to submitted questions table
insertSubmittedQuestion($_GET['gameID'], $_GET['blackCardID']);

// print the new black card data
$card = getBlackCardData($_GET['blackCardID']);
echo '<p class="black-card-display-text">' . $card['text'] . '</p>';

?>

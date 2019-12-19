<?php

include_once('functions.php');

$card = getBlackCardData($_GET['id']);

echo '<p>' . $card['text'] . '</p>';

?>

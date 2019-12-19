<?php
include_once('functions.php');
$players = getConnectedPlayersData($_GET['gameID']);

echo '<ul>';

while ($player = $players->fetch(PDO::FETCH_ASSOC)) {
	echo '<li>' . $player['username'] . '</li>';
}

echo '</ul>';

?>

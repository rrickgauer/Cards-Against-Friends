<?php include_once('functions.php'); ?>

<?php

// name input was not set when user got to page; return to home.php
if (!isset($_POST['name'])){
	header('Location: home.php');
}

insertNewGame($_POST['name']);						// insert new game into db
$game = getMostRecentCreatedGameData();		// get the data of the most recent game created

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<?php include('header.php'); ?>
		<title>Start New Game</title>
	</head>
	<body>
		<div class="container">
			<h1>Start game</h1>

			<h2><?php echo $game['name']; ?></h2>
			<h2>Unique game code: <?php echo $game['id']; ?></h2>


			<div id="current-players-section">
				<ul>

					<?php

					$players = getConnectedPlayersData($game['id']);

					while ($player = $players->fetch(PDO::FETCH_ASSOC)) {
						echo '<li>' . $player['username'] . '</li>';
					}


					?>

				</ul>


			</div>




		</div>

	</body>
</html>

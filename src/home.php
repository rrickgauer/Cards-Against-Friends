<?php include('functions.php'); ?>

<?php

// name input was not set when user got to page; return to home.php
if (isset($_POST['name'])){
	insertNewGame($_POST['name']);						// insert new game into db
	session_start();
	$_SESSION['game'] = getMostRecentCreatedGameData();		// get the data of the most recent game created
	header('Location: start-game-page.php');
	exit;
}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<?php include('header.php'); ?>
	<title>Cards Against Friends</title>
</head>

<body>
	<div class="container">

		<h1>Cards Against Friends</h1>

		<div class="row">

			<div class="col-sm-12 col-md-6">
				<h2>Start a new game</h2>
				<form class="form" method="post">
					<input type="text" name="name" class="form-control" placeholder="Enter name of new game" required><br>
					<input type="submit" value="Start new game" class="btn btn-primary">
				</form>
			</div>

			<div class="col-sm-12 col-md-6">
				<h2>Join a game</h2>
				<a href="join-game.php"><button type="button" name="button" class="btn btn-primary">Join a game</button></a>
			</div>

		</div>

	</div>

</body>

</html>

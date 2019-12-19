<?php include('functions.php'); ?>

<?php

if (isset($_POST['game-id']) && isset($_POST['username']))
{
	// check if user entered valid game id
	if (isGameIDValid($_POST['game-id']) && isUsernameValid($_POST['game-id'], $_POST['username']))
	{
		insertPlayer($_POST['game-id'], $_POST['username']);

		session_start();
		$_SESSION['player'] = getPlayerDataFromUsername($_POST['game-id'], $_POST['username']);
		$_SESSION['game'] = getGameData($_POST['game-id']);

		header('Location: game.php');
	}
}


?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<?php include('header.php'); ?>
		<title>Join a game</title>
	</head>
	<body>
		<div class="container">
			<h1>Join a game</h1>

			<form class="form" method="post">
				<input type="text" name="game-id" class="form-control" placeholder="Game ID" required autofocus><br>
				<input type="text" name="username" class="form-control" placeholder="Username" maxlength="30" required> <br>
				<input type="submit" name="submit" value="Join game" class="btn btn-primary">
			</form>

		</div>

	</body>
</html>

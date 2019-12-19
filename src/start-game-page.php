<?php session_start(); ?>
<?php include_once('functions.php'); ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<?php include('header.php'); ?>
	<title>Start New Game</title>
</head>

<body>
	<div class="container">
		<h1 class="text-center">Start Game Control Center</h1>

		<h2><?php echo $_SESSION['game']['name']; ?></h2>
		<h2>Unique game code: <?php echo $_SESSION['game']['id']; ?></h2>

		<div id="current-players">

		</div>







	</div>


	<script>

		function getGameID() {
			return <?php echo $_SESSION['game']['id']; ?>;
		}

		$(document).ready(function() {
			getCurrentPlayers();
			setInterval(executeQuery, 5000);
		});

		function executeQuery() {
			getCurrentPlayers(getGameID());
			setInterval(executeQuery, 5000);
		}


		// updates the info in the update-item-info form modal
		function getCurrentPlayers(gameID) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var e = this.responseText;
					$("#current-players").html(e);
				}
			};
			var id = $();
			xhttp.open("GET", "get-current-players.php?gameID=" + gameID, true);
			xhttp.send();
		}
	</script>



</body>

</html>

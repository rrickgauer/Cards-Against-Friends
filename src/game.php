<?php session_start(); ?>
<?php include('functions.php'); ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<?php include('header.php'); ?>
	<title><?php echo $_SESSION['game']['name']; ?></title>
</head>

<body>
	<div class="container">
		<h1 class="text-center"><?php echo $_SESSION['game']['name']; ?></h1>

		<h2>Game ID: <?php echo $_SESSION['game']['id']; ?></h2>

		<h2>Current Players:</h2>

		<button type="button" id="refresh-players-btn" class="btn btn-primary" data-gameid="<?php echo $_SESSION['game']['id']; ?>">Refresh</button>

		<div id="current-players">


		</div>


	</div>

</body>

<script>
	$("#refresh-players-btn").on('click', function() {
		getCurrentPlayers(getGameID());
	});

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






</html>

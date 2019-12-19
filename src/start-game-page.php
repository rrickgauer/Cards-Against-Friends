<?php session_start(); ?>
<?php include_once('functions.php'); ?>

<?php

function getOptionString($value, $display) {
	return "<option value=\"$value\">$display</option>";
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<?php include('header.php'); ?>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
	<title>Start New Game</title>
</head>

<body>
	<div class="container">
		<h1 class="text-center">Game Control Center</h1>

		<h2><?php echo $_SESSION['game']['name']; ?></h2>
		<h2>Unique game code: <?php echo $_SESSION['game']['id']; ?></h2>

		<div class="row">

			<div class="col-sm-12 col-md-6">
				<div class="card">
					<div class="card-header">
						<h3>Game Options</h3>
					</div>

					<div class="card-body">
						<form class="form">
							<!-- open or close player connections -->
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="open" id="inlineRadio1" value="option1" checked>
								<label class="form-check-label" for="inlineRadio1">Open</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="open" id="inlineRadio2" value="option2">
								<label class="form-check-label" for="inlineRadio2">Closed</label>
							</div>

						<!-- number of rounds -->
						<div class="form-group">
							<label for="number-of-rounds">Number of rounds</label>
							<select class="form-control" name="number-of-rounds" id="number-of-rounds">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5" selected>5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>

						<div class="form-group">
							<label for="categories">Categories</label>

								<select class="form-control" name="categories" id="categories" multiple="multiple">
									<?php
									$categories = getCategoriesData();
									while ($category = $categories->fetch(PDO::FETCH_ASSOC)) {
										echo getOptionString($category['id'], $category['name']);
									}
									?>
								</select>


						</div>

					</form>
					</div>

					<div class="card-footer">
						<button type="button" name="button" class="btn btn-primary">Start game</button>
					</div>

				</div>

			</div>

			<div class="col-sm-12 col-md-6">
				<div class="card">
					<div class="card-header">
						<h3>Current Players</h3>
					</div>

					<div id="current-players-list" class="card-body">
					</div>

					<div class="card-footer">
						<button type="button" id="refresh-current-players-btn" class="btn btn-primary">Refresh</button>
					</div>

				</div>
			</div>


		</div>







	</div>


	<script>
		function getGameID() {
			return <?php echo $_SESSION['game']['id']; ?> ;
		}

		// $(document).ready(function() {
		// 	getCurrentPlayers();
		// 	setInterval(executeQuery, 5000);
		// });
		//
		// function executeQuery() {
		// 	getCurrentPlayers(getGameID());
		// 	setInterval(executeQuery, 5000);
		// }

		$(document).ready(function() {
			$("#refresh-current-players-btn").on('click', function() {
				getCurrentPlayers(getGameID());
			});

			$('#categories').select2();
		});

		// updates the info in the update-item-info form modal
		function getCurrentPlayers(gameID) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var e = this.responseText;
					$("#current-players-list").html(e);
				}
			};
			var id = $();
			xhttp.open("GET", "get-current-players.php?gameID=" + gameID, true);
			xhttp.send();
		}
	</script>



</body>

</html>

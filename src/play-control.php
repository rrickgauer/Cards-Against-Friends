<?php
session_start();
include('functions.php');
$limit = getGameCardLimit($_SESSION['game']['id']);
$blackDeck = getRandomBlackDeck($_SESSION['game']['id'], $limit);
$blackDeckCounter = 0;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<?php include('header.php'); ?>
	<title></title>
</head>

<body>
	<div class="container">

		<h1>Play game</h1>
		<h1>ID: <?php echo $_SESSION['game']['id']; ?></h1>
		<h1>Name: <?php echo $_SESSION['game']['name']; ?></h1>

		<div class="row">

			<div class="col-sm-3">
				<!-- batting order -->
				<div class="card">
					<div class="card-header">
						<h4>Batting Order</h4>
					</div>
					<div class="card-body">
						<?php printBattingOrder(); ?>
					</div>
				</div>
			</div>

			<div class="col-sm-9">

				<div class="card">
					<div class="card-header">
						<h4>Black Card Area</h4>
						<p>Card <span id="card-count">0</span> of <span id="card-total"><?php echo $limit; ?></span></p>
					</div>

					<div class="card-body" id="black-card-area">
					</div>

					<div class="card-footer">
							<button type="button" class="btn btn-primary" id="next-button">Start</button>
					</div>
				</div>

			</div>
		</div>

	</div>
</body>

<script>
<?php
echo 'var blackDeckIndex = [];';
while ($blackCard = $blackDeck->fetch(PDO::FETCH_ASSOC)) {
	echo 'blackDeckIndex.push(' . $blackCard['id'] . ');';
}
?>

var gameID = <?php echo $_SESSION['game']['id']; ?>;


$(document).ready(function() {
	$("#next-button").on('click', function() {
		var blackID = blackDeckIndex.pop();
		loadBlackCard(blackID);
		$(this).html('Next');

		if (blackDeckIndex.length < 1) {
			$(this).attr("disabled", "disabled");
		}

		incrementCardCount();
	})
});

// updates the info in the update-item-info form modal
function loadBlackCard(blackCardID) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var e = this.responseText;
			$("#black-card-area").html(e);
		}
	};

	xhttp.open("GET", "get-black-card.php?blackCardID=" + blackCardID + '&gameID=' + gameID, true);
	xhttp.send();
}

// add 1 to card-count
function incrementCardCount() {
	var currentCount = $("#card-count").html();
	$("#card-count").html(parseInt(currentCount) + 1);
}


</script>




</html>

<?php
function printBattingOrder() {
	$players = getConnectedPlayersData($_SESSION['game']['id']);
	echo '<ul>';
	while ($player = $players->fetch(PDO::FETCH_ASSOC)) {
		echo '<li>';
		echo $player['username'];
		echo '</li>';
	}

	echo '</ul>';
}
?>

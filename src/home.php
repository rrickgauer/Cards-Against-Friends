<?php include('functions.php'); ?>
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
				<form class="form" method="post" action="start-game-page.php">
					<input type="text" name="name" class="form-control" placeholder="Enter name of new game" required><br>
					<input type="submit" value="Start new game" class="btn btn-primary">
				</form>
			</div>

			<div class="col-sm-12 col-md-6">
				<h2>Join a game</h2>
				<form class="form" method="post">
					<input type="text" name="title" class="form-control" placeholder="Enter custom game ID"><br>
					<input type="submit" value="Join game" class="btn btn-primary">
				</form>
			</div>
		</div>

	</div>

</body>

</html>

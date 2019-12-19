<?php session_start(); ?>
<?php include('functions.php'); ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<?php include('header.php'); ?>
		<title></title>
	</head>
	<body>
		<div class="container">

			<?php

			if(isset($_SESSION['player'])) {
				echo $_SESSION['player']['username'];
			}


			?>

		</div>

	</body>
</html>

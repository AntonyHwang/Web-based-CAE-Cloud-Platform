<!DOCTYPE html>
<html>
	<?php
		require "includes/config.php"; 
		include_once "includes/header.php";
		if ($_SESSION["logged_in"] != "YES") {
			header("Location: login.php");
		}
	?>

	<head></head>


	<body>
		<h1>Instruction Video</h1><br><br><br>
		<div align="center">
			<video width="60%" height="40%" autoplay loop controls>
			  <source src="css/video/instructions.mp4" type="video/mp4">
			</video>
		</div>

	</body>
</html>
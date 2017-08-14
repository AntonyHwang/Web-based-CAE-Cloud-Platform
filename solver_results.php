<?php
    require ("includes/config.php");
	include_once "includes/header.php";
	if ($_SESSION["logged_in"] != "YES") {
		header("Location: login.php");
	}
?>

<html>
	<h1>Solver Results</h1>
	<div align="center">
		<?php
			$name = $_GET['job_id'];
			$myfilename = "jobs\\".$name."\\".$name.".txt";
			echo nl2br( file_get_contents($myfilename) );
		?>
	<div>

</html>
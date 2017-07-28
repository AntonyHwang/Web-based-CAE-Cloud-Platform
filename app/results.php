<!DOCTYPE html>

<?php
	require ("includes/config.php");
    include_once "includes/header.php";
?>

<html>
	<head>
		<h1>Results</h1><br><br>
	</head>

	<body>
		<div align="middle">
		    <img src="jobs/<?php echo $_GET['job_id'];?>/disp.png" alt="disp" style="width:700px; height:600px;">
		    <img src="jobs/<?php echo $_GET['job_id'];?>/se.png" alt="se" style="width:700px; height:600px;">
		    <img src="jobs/<?php echo $_GET['job_id'];?>/sets.png" alt="sets" style="width:700px; height:600px;">
		</div>

	</body>
</html>
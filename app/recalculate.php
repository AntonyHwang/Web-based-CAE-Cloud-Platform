<?php
    require ("includes/config.php");
	if ($_SESSION["logged_in"] != "YES") {
		header("Location: login.php");
	}
		
?>
<?php
	$id = $_POST["job_id"];
	$displacement = $_POST["val"];
	//echo $displacement;

	//echo $id;
	
	$val = "echo. | C:\\www\\ttt\\scripts\\create_x3d.bat $id $displacement";
	//echo ini_get("disable_functions");
	$output = exec($val);
	
	$sql_update = "UPDATE job SET displacement = '$displacement' WHERE job_id = '".$id."'";
	$result = $dbh->query($sql_update);
	
	header("Location: results.php?job_id=".$id);
?>
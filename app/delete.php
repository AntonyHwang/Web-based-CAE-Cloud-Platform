<!DOCTYPE html>

<?php
    require ("includes/config.php");
    if ($_SESSION["logged_in"] != "YES") {
        header("Location: login.php");
    }
?>

<html>
	<head>
	</head>
	
</html>

<?php
	$id = $_POST['job_id'];
	$sql_delete = "DELETE FROM job WHERE job_id = $id";
	$result = $dbh->query($sql_delete);
	$sql_delete = "DELETE FROM faces WHERE job_id = $id";
	$result = $dbh->query($sql_delete);

	
?>
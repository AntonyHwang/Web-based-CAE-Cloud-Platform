<!DOCTYPE html>

<?php
    require ("includes/config.php");
    if ($_SESSION["logged_in"] != "YES") {
        header("Location: login.php");
    }
?>

<?php
	$id = $_POST['job_id'];
	$sql_hide = "UPDATE job SET hidden='1' WHERE job.job_id = $id";
	$result = $dbh->query($sql_hide);
?>
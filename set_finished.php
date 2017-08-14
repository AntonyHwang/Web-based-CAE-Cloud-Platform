<?php
    require ("includes/config.php");
    if ($_SESSION["logged_in"] != "YES") {
        header("Location: login.php");
    }
?>

<?php	
	
	$id = $argv[1];

	// $call_python = $py_path." py/make_result_mesh.py 2>&1".$id;
 //    $result = shell_exec($call_python);

    //$call_batch = "echo. | scripts\create_x3d.bat $id";
    //$result = exec($call_batch." 2>&1");
	
	//$test = "scripts\test.bat";
	//$result1 = exec($test);

    $sql_update = "UPDATE job SET finished = '1' WHERE job_id = '".$id."'";
	$result = $dbh->query($sql_update);
?>
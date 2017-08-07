<?php
    require("includes/config2.php");
    if ($_SESSION["logged_in"] != "YES") {
        header("Location: login.php");
    }
?>

<?php
	$id = $_POST["job_id"];
    $element_size = $_POST["element_size"];

    set_time_limit(240);
	$val = "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\check_msh\checkmesh.bat $id $element_size";
	$output = exec($val);

	$val1 = $py_path." py/allTomsh.py ".$id;
    $output1 = exec($val1);
    //print($output1);

    echo json_encode(array('conversion'=>$output1));
?>
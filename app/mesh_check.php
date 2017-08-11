<?php
    // can't require the config file because AJAX on success returns the entire
    // html page and requiring the config file would result in unnecessary html
    // being passed back
    ob_start();
    if (!isset($_SESSION)) { session_start(); }
    $py_path = "C:/Miniconda3/python.exe";

    if ($_SESSION["logged_in"] != "YES") {
        header("Location: login.php");
    }
?>

<?php
	$id = $_POST["job_id"];
    $element_size = $_POST["element_size"];
    $max_element_size = $_POST["max_element_size"];
    $min_element_size = $_POST["min_element_size"];

    set_time_limit(240);
	$val = "scripts\check_msh\checkmesh.bat $id $element_size $max_element_size $min_element_size";
	$output = exec($val);

	$val1 = $py_path." py/allTomsh.py ".$id;
    $output1 = exec($val1);
    //print($output1);

    echo json_encode(array('conversion'=>$output1));
?> 
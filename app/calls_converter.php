<!DOCTYPE html>

<?php
    require ("includes/config.php");
?>

<html>
	<head>
		<h1>This is Sample Text to Display!</h1>


	</head>
</html>

<?php
    // $required = array('density', "youngs_mod", "poissons", "element_size", "material")
    // foreach($required as $element) {

    //     if (empty($_POST[$element])) {

    //     }
    // }
    //$sql_update = "UPDATE job SET (density, youngs_mod, poissons_ratio, element_size, material_name) VALUE ('".$_POST["density"]."', '".$_POST["youngs_mod"]."','".$_POST["poissons"]."','".$_POST["element_size"]."','".$_POST["material"]."') WHERE job_id = $_POST["id"]";

	$anchorX = $_POST["a_x"];
	$anchorY = $_POST["a_y"];
	$anchorZ = $_POST["a_z"];
	$pressureX = $_POST["p_x"];
	$pressureY = $_POST["p_y"];
	$pressureZ = $_POST["p_z"];
	$id = $_POST["id"];

	$density =  $_POST["density"];
    $youngs_mod = $_POST["youngs_mod"];
    $poissons = $_POST["poissons"];
    $element_size = $_POST["element_size"];
    $material =  $_POST["material"];


	$call_python = "C:/Users/MD580/Miniconda2/python.exe py/read_gmsh.py 2>&1".$anchorX." ".$anchorY." ".$anchorZ." ".$id;
	$a_face = exec($call_python, $output, $code);
	//echo $a_face;
	// echo $output;
	// echo $code;

	$call_python = "C:/Users/MD580/Miniconda2/python.exe py/read_gmsh.py ".$pressureX." ".$pressureY." ".$pressureZ." ".$id;
	$p_face = exec($call_python);
	//echo $p_face;



	


    $sql_update = "UPDATE job SET density = '$density', element_size = '$element_size', youngs_mod = '$youngs_mod', poissons_ratio = '$poissons', material_name = '$material', pressure_face = '$p_face', anchor_face = '$a_face' WHERE job_id = '$id'";
    $sth = $dbh->query($sql_update);
    $sth = null; 

    
?>
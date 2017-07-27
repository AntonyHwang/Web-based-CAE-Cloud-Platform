<!DOCTYPE html>

<?php
    require ("includes/config.php");
    //include("computing_server.php");
?>

<html>
	<head>
		<h1 style="color: white">Mesh Display!</h1>
	</head>

	<body>
	<?php
		$id = $_POST["id"];
		$density =  $_POST["density"];
	    $youngs_mod = $_POST["youngs_mod"];
	    $poissons = $_POST["poissons"];
	    $element_size = $_POST["element_size"];
	    $material =  $_POST["material"];

	    $totalAnchor = $_POST["anchorTotal"];
	    $removedAnchor = $_POST["removedAnchor"];

	    $totalPressure = $_POST["pressureTotal"];
	    $removedPressure = $_POST["removedPressure"];

	    if (count($removedAnchor) != 0) {
	    	$removedAnchor = substr($removedAnchor, 0, -1);
	    }
	    if (count($removedPressure) != 0) {
	    	$removedPresure = substr($removedPressure, 0, -1);
	    }

	    $listOfRemovedAnchors = explode(",", $removedAnchor);
	    $listOfRemovedPressures = explode(",", $removedPressure);

	    $counter = 0;

	    for ($x = 0; $x <= intval($totalAnchor); $x++) {
	    	if (!in_array(strval($x), $listOfRemovedAnchors)) {
	    		$sql_insert = "INSERT INTO faces (job_id, face_number, face_type) VALUE ('".$id."','".$_POST["aface".$x]."', 'anchor')";
	    		$result = $dbh->query($sql_insert);
	    		$result = null;
	    	}
	    }

	    for ($x = 0; $x <= intval($totalPressure); $x++) {
	    	if (!in_array(strval($x), $listOfRemovedPressures)) {
	    		$sql_insert = "INSERT INTO faces (job_id, face_number, face_type, pressure) VALUE ('".$id."','".$_POST["pface".$x]."', 'pressure','".$_POST["pvalue".$x]."')";
	    		$result = $dbh->query($sql_insert);
	    		$result = null;
	    	}
	    }




		// $call_python = $py_path." py/read_gmsh.py ".$anchorX." ".$anchorY." ".$anchorZ." ".$id;
		// $a_face = exec($call_python, $output, $code);

		// $call_python = $py_path." py/read_gmsh.py ".$pressureX." ".$pressureY." ".$pressureZ." ".$id;
		// $p_face = exec($call_python);

	    $sql_update = "UPDATE job SET density = '$density', element_size = '$element_size', youngs_mod = '$youngs_mod', poissons_ratio = '$poissons', material_name = '$material' WHERE job_id = '".$id."'";
	    $result = $dbh->query($sql_update);


	    echo "TEST TEXT!!!";

	    $sql_select = "SELECT * FROM faces WHERE job_id = '".$id."'";
	    $result = $dbh->query($sql_select);
	    //echo $sql_select;
	     	while ($row = $result->fetch()) {
	     		echo "id: ". $row["job_id"]. "face number: ". $row["face_number"]. "face_type: ". $row["face_type"]."pressure: ".$row["pressure"]. "<br>";
	     	}
		?>
	</body>
</html>

<?php
    

    // $ouptut = shell_exec("/scripts/create.bat $id ");

?>
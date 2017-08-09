<!DOCTYPE html>

<?php
    require ("includes/config.php");
    if ($_SESSION["logged_in"] != "YES") {
        header("Location: login.php");
    }
    //include("computing_server.php");
?>

<html>
	<head>
		<h1 style="color: white">Loading...</h1>
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

	    $max_element_size = $_POST["maxElementSize"];
	    $min_element_size = $_POST["minElementSize"];

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

	    $sql_update = "UPDATE job SET density = '$density', element_size = '$element_size', youngs_mod = '$youngs_mod', poissons_ratio = '$poissons', material_name = '$material', hidden='0', max_element_size='$max_element_size' WHERE job_id = '".$id."'";
	    $result = $dbh->query($sql_update);

	    $sql_select = "SELECT * FROM faces WHERE job_id = '".$id."'";
	    $result = $dbh->query($sql_select);
	    $allAnchors = "";
	    $allPressures = "";
	    //echo $sql_select;
	    $counter = 0;
	     	while ($row = $result->fetch()) {

	     		if ($row["face_type"] == "pressure") {
	     			$allPressures = $allPressures.$row["face_number"].",";
	     		} else if ($row["face_type"] == "anchor") {
	     			$allAnchors = $allAnchors.$row["face_number"].",";
	     		}

	     		
	     		
	     	}
	     	$allPressures = substr($allPressures, 0, -1);
	     	$allAnchors = substr($allAnchors, 0, -1);

	     	// sometimes the computation takes too long with smaller cs-scale sizes, so you have to make sure that
	     	// you adjust the timeout limit for PHP
	     	set_time_limit(60);

		    //echo $id." ".$allAnchors." ".$allPressures." ".$youngs_mod." ".$poissons." ".$material;
		    $val = "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\create.bat $id "."\"$allAnchors\" " ."\"$allPressures\" "."$youngs_mod $poissons $material $element_size >nul 2&1";
		    // $output = exec($val);
		    $output = popen('start /B '.$val, 'r');
	     	//$output = exec("C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\create.bat $id $allAnchors $allPressures $youngs_mod $poissons $material");
	     	// $output = exec("C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\create.bat 160 12 5 120000 0.3 Steel");
	     	// exec("C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\jobs\clean.bat $id");

	     	echo $output;
	     	// header("Location: results.php?job_id=".$id);
	     	header("Location: job_management.php");


			

	    	// $call_python = $py_path." py/make_result_mesh.py 2>&1".$id;
      //       $result = shell_exec($call_python);

             $call_batch = "echo. | C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\create_x3d.bat $id";
             $result = exec($call_batch);

      //       $sql_update = "UPDATE job SET finished = '1' WHERE job_id = '".$id."'";
	    	// $result = $dbh->query($sql_update);

		?>
	</body>
</html>

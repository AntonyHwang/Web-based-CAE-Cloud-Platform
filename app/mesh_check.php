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
	$id = $_POST["id"];
    $youngs_mod = $_POST["youngs_mod"];
    $poissons = $_POST["poissons"];
    $element_size = $_POST["element_size"];
    $material =  $_POST["material"];

    $anchorTotal = $_POST["anchorTotal"];
    $removedAnchor = $_POST["removedAnchor"];

    $pressureTotal = $_POST["pressureTotal"];
    $removedPressure = $_POST["removedPressure"];

    if (count($removedAnchor) != 0) {
    	$removedAnchor = substr($removedAnchor, 0, -1);
    }
    if (count($removedPressure) != 0) {
    	$removedPresure = substr($removedPressure, 0, -1);
    }

    $listOfRemovedAnchors = explode(",", $removedAnchor);
    $listOfRemovedPressures = explode(",", $removedPressure);

	$val = "C:\Users\MD580\Desktop\Web-based-CAE-Cloud-Platform\app\scripts\create.bat $id "."\"$allAnchors\" " ."\"$allPressures\" "."$youngs_mod $poissons $material $element_size";
	$output = exec($val);

	
?>
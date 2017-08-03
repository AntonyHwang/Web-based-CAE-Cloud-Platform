<!DOCTYPE html>

<?php
	require ("includes/config.php");
    include_once "includes/header.php";
    if ($_SESSION["logged_in"] != "YES") {
        header("Location: login.php");
    }
?>

<html>
	<head>
		<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script> 
		<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
		<div class="results">
			<h1>Results</h1><br><br>
		</div>

	</head>

	<body>
		<div align="middle">
		    <img src="jobs/<?php echo $_GET['job_id'];?>/disp.png" alt="disp" style="width:auto; height:auto; max-width: 80%;"><br><br>
		    <img src="jobs/<?php echo $_GET['job_id'];?>/se.png" alt="se" style="width:auto; height:auto; max-width: 80%;"><br><br>
		    <img src="jobs/<?php echo $_GET['job_id'];?>/sets.png" alt="sets" style="width:auto; height:auto; max-width: 80%;"><br><br>
		</div>

		<x3d id='x3d_element' width='850px' height='500px' align='center' > 
			<scene>
			<viewpoint id = "angle1" position='45 0 200' orientation="0 0 1 0" description = "Cam Angle 1"></viewpoint>
			<viewpoint id = "angle3" position='300 0 0' orientation="0 1 0 1.57079632679" description = "Cam Angle 3"></viewpoint>
			<viewpoint id = "angle2" position='45 0 -200' orientation="0 1 0 3.1415" description = "Cam Angle 2"></viewpoint>
			<viewpoint id = "angle4" position='-300 0 0' orientation="0 1 0 -1.57079632679" description = "Cam Angle 4"></viewpoint>
			<viewpoint id = "angle5" position='0 300 0' orientation="1 0 0 -1.57079632679" description = "Cam Angle 5"></viewpoint>
			<viewpoint id = "angle6" position='0 -300 0' orientation="1 0 0 1.57079632679" description = "Cam Angle 6"></viewpoint>
			<viewpoint id = "angle7" position='-200 0 200' orientation="0 -1 0 0.7" description = "Cam Angle 6"></viewpoint>

			<!-- <inline onload="center()" nameSpaceName="Object" mapDEFToID="true" url="final_x3d/<?php echo $_GET['job_id'];?>.x3d" ></inline>  -->
			<inline onload="center()" nameSpaceName="Object" url="final_x3d/248" ></inline> 

			</scene> 
		</x3d>   

	</body>
</html>
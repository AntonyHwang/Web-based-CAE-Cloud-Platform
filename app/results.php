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

		<script>
		function center(event)
		  	{
		  		document.getElementById('x3d_element').runtime.fitAll();
		  	}
		</script>

	</head>

	<body>
		<div align="middle">
		    <img src="jobs/<?php echo $_GET['job_id'];?>/disp.png" alt="disp" style="width:auto; height:auto; max-width: 80%;"><br><br>
		    <img src="jobs/<?php echo $_GET['job_id'];?>/se.png" alt="se" style="width:auto; height:auto; max-width: 80%;"><br><br>
		    <img src="jobs/<?php echo $_GET['job_id'];?>/sets.png" alt="sets" style="width:auto; height:auto; max-width: 80%;"><br><br>
		</div>

		<div align="middle">
		<div>
			<h3>Displacement</h3>
		<x3d id='x3d_element' width='850px' height='500px' > 
			<scene>
			<inline onload="center()" nameSpaceName="Object" mapDEFToID="true" url="final_x3d/<?php echo $_GET['job_id'];?>_disp.x3d" ></inline>
			
			</scene> 
		</x3d>
		</div>

		<div>
			<h3>Stress</h3>
		<x3d id='x3d_element' width='850px' height='500px'> 
			<scene>
			<inline onload="center()" nameSpaceName="Object" mapDEFToID="true" url="final_x3d/<?php echo $_GET['job_id'];?>_stress.x3d" ></inline>  
			
			</scene> 
		</x3d>
		</div>
		</div>

	</body>
</html>

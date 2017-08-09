<!DOCTYPE html>
<html>
	<?php
		require ("includes/config.php");
		if ($_SESSION["logged_in"] != "YES") {
			header("Location: login.php");
		}
	?>

	<head>
		<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script> 
		<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
	  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>

	  	<script>	
		  	function center(event)
		  	{
		  		document.getElementById('x3d_element').runtime.fitAll();
		  	}
	  	</script>
	</head>


	<body>
		<div id="display">
			<h1>3D Display of Mesh</h1>
			<x3d id='x3d_element' align='center' style="left:30%;">
				<div id="instructions">
					<button type="button" onclick="center(event)" class="btn btn-secondary">Center</button>
				</div>


				<scene>
					<viewpoint id = "angle1" position='45 0 200' orientation="0 0 1 0" description = "Cam Angle 1"></viewpoint>

					<inline id="x3d_object" url="gmsh_output/<?php echo $_POST['id'];?>/mesh.x3d" onload="center();"></inline> 

				</scene> 
			</x3d>   
		</div>

	</body>
</html>
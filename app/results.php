<!DOCTYPE html>

<?php
    require ("includes/config.php");
    include_once "includes/header.php";
	if ($_SESSION["logged_in"] != "YES") {
		header("Location: login.php");
	}
	
	$id = $_GET['job_id'];
	$sql_select = "SELECT * FROM job WHERE job_id = '".$id."'";
	$result = $dbh->query($sql_select);
	if ($result->fetch()["id_user"] != $_SESSION["id"] ) {
		//header("Status: 404 Not Found");
		header("Location: job_management.php");
	}
			
?>

<html>
	<head>
		<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>		
		<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
		<div class="results">
			<h1>Results</h1><br><br>
		</div>

		<script>
		function center(event)
		{
			document.getElementByClass('x3d_element').runtime.fitAll();
		}
		
		function recalculate() {			
			$.ajax({
				type: 'POST',
				url:'recalculate.php',
				data: {
					id: $('#job_id').val(),
					displacement: $('#displacement').val()
				},
				success: function (data){
					//alert(data);
					location.reload();
				}
			});
		}
			
		</script>
	</head>

	<body>	
		<div class="row">
		<div class="col-md-6" align="center">
		    <img class="pic"src="jobs/<?php echo $_GET['job_id'];?>/disp_ss.png" alt="Displacement">
		</div><div class="col-md-6" align="center">
			<img class="pic" src="jobs/<?php echo $_GET['job_id'];?>/stress_ss.png" alt="Stress"><br><br><br>
		</div></div>
		
		<div align="right">
			<h5 align="center">Change Displacement Factor:</h5>
			<form id="displacement" action="recalculate.php" method="post" align="center">
				<input id="val" name="val" type="number" value="<?php
					$sql_select = "SELECT displacement FROM job WHERE job_id = '".$_GET['job_id']."'";
					$result = $dbh->query($sql_select);
					echo floatval($result->fetch()[0]);
				?>" style="width:auto;">
				<input id="job_id" name="job_id" type="input" value="<?php echo $_GET['job_id'];?>" hidden>
				<input type="submit" value="submit" style="width:auto;">
			</form>
		</div>
		
		<div class="row">
			<div class="col-md-6" align="center">
				<h3>Displacement</h3>
				<div class="parent">
					<x3d class='x3d_element' align="center"> 
						<scene>
						<inline onload="center()" nameSpaceName="Object" mapDEFToID="true" url="final_x3d/<?php echo $_GET['job_id'];?>_disp.x3d" ></inline>
						</scene> 
						<!--<img src="jobs/<?php echo $_GET['job_id'];?>/disp_scale.png" class="scale" style="width:auto; height:auto; max-width: 80%;">-->
					</x3d>
				</div>
			</div>

			<div class="col-md-6" align="center">
				<h3>von Mises Stress</h3>
				<div class="parent">
					<x3d class='x3d_element'> 
						<scene>
						<inline onload="center()" nameSpaceName="Object" mapDEFToID="true" url="final_x3d/<?php echo $_GET['job_id'];?>_stress.x3d" ></inline>
						</scene> 
						<!--<img src="jobs/<?php echo $_GET['job_id'];?>/stress_scale.png" class="scale" style="width:auto; height:auto; max-width: 80%;">-->
					</x3d>
				</div>
			</div>
		</div>

		<br><br><br>

	</body>
</html>
<!DOCTYPE html>
<html>
	<head>
		<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script> 
		<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
	  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>
	

		<script>

		  	function displayCoordinates(event)
		  	{
		  		var coordinates = event.hitPnt;
		  		
		  		//alert("Clicked!");
		  		alert(Object.keys(event.target._x3domNode._cf));
		  		// alert(event.target.requestFieldRef);
		  		alert(event.target._x3domNode._cf);




		  		//alert(Object.keys(event.hitObject);
		  		// alert($(event).attr('id'));

		  		document.getElementById('Object__Shape_Mat').setAttribute('diffuseColor', '1 0 1');
		  		document.getElementById('Object__Shape_Mat').highlight("red");

		  		//document.getElementById("temp").setAtribute('diffuseColor', '0 0 1');
		  		
		  		if (event.button == 1) {
		  			$('#marker').attr('translation', event.hitPnt);
		  			// $('#a_coordX').html(coordinates[0]);
			   	// 	$('#a_coordY').html(coordinates[1]);
			   	// 	$('#a_coordZ').html(coordinates[2]);
			   		document.getElementById('a_x').value = coordinates[0];
			   		document.getElementById('a_y').value = coordinates[1];
			   		document.getElementById('a_z').value = coordinates[2];

		  		} else if (event.button == 2) {
		  			$('#marker2').attr('translation', event.hitPnt);
		  			// $('#p_coordX').html(coordinates[0]);
			   	// 	$('#p_coordY').html(coordinates[1]);
			   	// 	$('#p_coordZ').html(coordinates[2]);
			   		document.getElementById('p_x').value = coordinates[0];
			   		document.getElementById('p_y').value = coordinates[1];
			   		document.getElementById('p_z').value = coordinates[2];
		  		}

		  	}

		  	function calculateFace(event)
		  	{
		  		var element = document.getElementById('jobid').textContent;
		   		var extracted_id = element.replace("Job Id: ", "");

		  		$.ajax({
		   			type: "POST",
		   			url: 'calls_converter.php',
		   			data: { 
		   				anchorX: 21.4,
		   				anchorY: document.getElementById('a_y').value,
		   				anchorZ: document.getElementById('a_z').value,
		   				pressureX: document.getElementById('p_x').value,
		   				pressureY: document.getElementById('p_y').value,
		   				pressureZ: document.getElementById('p_z').value,
		   				job_id: extracted_id
		   			},
		   			success: function(data) {
		   				console.log(data);
		   			}
		   		});
		  	}

		  </script>
	  </head>


    <body>
    <h1>3D Display of Uploaded File (<?php echo $_GET["step_file"];?>)</h1>
    <h2 id=jobid>Job Id: <?php echo $_GET["job_id"];?> </h2>

        <x3d width='500px' height='400px'> 
            <scene>
            	<!-- <inline nameSpaceName="Object" mapDEFToID="true" url="x3d_output/<?php echo $_GET["job_id"];?>.x3d" onclick="displayCoordinates(event)"></inline>  -->
            	<inline nameSpaceName="Object" mapDEFToID="true" url="x3d_output/part.x3d" onclick="displayCoordinates(event)"></inline> 
            	<Transform id="marker" scale="2.5 2.5 2.5" translation="0 0 0">
			        <Shape>
			            <Appearance>
			                <Material diffuseColor="#FF6666"></Material>
			            </Appearance>
			            <Sphere></Sphere>
			        </Shape>
			    </Transform>

			    <Transform id="marker2" scale="2.5 2.5 2.5" translation="0 0 0">
			        <Shape>
			            <Appearance>
			                <Material diffuseColor="#66FFAA"></Material>
			            </Appearance>
			            <Sphere></Sphere>
			        </Shape>
			    </Transform>

            </scene> 
        </x3d> 

        <!-- <h3>Anchor Coordinates:</h3>
		<table style="font-size:1em;">
			<tr><td>X: </td><td id="a_coordX">-</td></tr>
			<tr><td>Y: </td><td id="a_coordY">-</td></tr>
			<tr><td>Z: </td><td id="a_coordZ">-</td></tr>
		</table> 

		<h3>Pressure Applied Coordinates:</h3>
		<table style="font-size:1em;">
			<tr><td>X: </td><td id="p_coordX">-</td></tr>
			<tr><td>Y: </td><td id="p_coordY">-</td></tr>
			<tr><td>Z: </td><td id="p_coordZ">-</td></tr>
		</table> 

		<br><br><br> -->

		<form method="post" action="calls_converter.php">
			Density:
			<input type="text" name="density"><br>
			Young's Modulus:
			<input type="text" name="youngs_mod"><br>
			Poisson's Ratio:
			<input type="text" name="poissons"><br>
			Element Size:
			<input type="text" name="element_size"><br>
			Material:
			<input type="text" name="material"><br><br>
			Anchor Coordinates:<br>
			X: <input type="text" id="a_x" name="a_x"><br>
			Y: <input type="text" id="a_y" name="a_y"><br>
			Z: <input type="text" id="a_z" name="a_z"><br><br>
			Pressure Applied Coordinates:<br>
			X: <input type="text" id="p_x" name="p_x"><br>
			Y: <input type="text" id="p_y" name="p_y"><br>
			Z: <input type="text" id="p_z" name="p_z"><br><br>
			Job Id:
			<input type="text" readonly="readonly" name="id" value=<?php echo $_GET["job_id"];?>><br>
			<input type="submit" value="Submit">
		</form>
		

    </body>
</html>
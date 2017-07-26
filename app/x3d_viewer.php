<!DOCTYPE html>
<?php
	require ("includes/config.php");
    include_once "includes/header.php";
?>
<html>
	<head>
		<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script> 
		<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
	  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>



		<script>
			// $(document).ready(function(){
			// 	for (i = 1; i <= <?php echo $_GET["max_faces"];?>; i++) {

  	// 				var shape = document.getElementById('Object__Shape_Mat_'.concat(String(i)))
  	// 				alert(shape);
  	// 				// shape.addEventListener('mouseover', function(event){
  	// 				// 	setFaceColor('1 1 1', i);
  	// 				// });

	  // 			// var shape = document.getElementById('Object__Shape_Mat_'.concat(String(value - 2)))
	  					
	  // 			}
			// });


	  		

		  	function displayCoordinates(event)
		  	{
		  		var coordinates = event.hitPnt;


		  		//alert(Object.keys(event.target._x3domNode));
		  		// alert(event.target._x3domNode._objectID);

		  		val = parseInt(event.target._x3domNode._objectID);
		  		var face = val - 2;
		  		anchorColor = '0 0.75 0.75';
		  		pressureColor = '0.5 1 0.5';
		  		defaultColor = '0.65 0.65 0.65';

		  		if (event.button == 1) { // for aface
		  			// $('#marker').attr('translation', event.hitPnt);

		  			var aface = document.getElementById('aface');
		  			
		  			if (isSelected(anchorColor, val)) { //unselect this face
		  				setFaceColor(defaultColor, val);
			   			aface.value = aface.defaultValue;
			   			document.getElementById('a_x').value = document.getElementById('a_x').defaultValue;
			   			document.getElementById('a_y').value = document.getElementById('a_y').defaultValue;
			   			document.getElementById('a_z').value = document.getElementById('a_z').defaultValue;
		  			} else {	//select this face
		  				setFaceColor(anchorColor, val);

				   		document.getElementById('a_x').value = coordinates[0];
				   		document.getElementById('a_y').value = coordinates[1];
				   		document.getElementById('a_z').value = coordinates[2];

				   		// if another face was previously selected, change its color back
				   		if(aface.value != aface.defaultValue){
				   			var myval = parseInt(aface.value) + 2;
				   			setFaceColor(defaultColor, myval);
				   		}
				   		aface.value = face;

				   		var pface = document.getElementById('pface');  //unset pface values if the same
				   		if(pface.value == face){
				   			pface.value = pface.defaultValue;
				   			document.getElementById('p_x').value = document.getElementById('p_x').defaultValue;
				   			document.getElementById('p_y').value = document.getElementById('p_y').defaultValue;
				   			document.getElementById('p_z').value = document.getElementById('p_z').defaultValue;
				   		}
			   	}

		  		} else if (event.button == 2) { //for pface
		  			// $('#marker2').attr('translation', event.hitPnt)z

		  			var pface = document.getElementById('pface');

				   	if (isSelected(pressureColor, val)) {	//unselect this face
		  				setFaceColor(defaultColor, val);
		  				
			   			pface.value = pface.defaultValue;
			   			document.getElementById('p_x').value = document.getElementById('p_x').defaultValue;
			   			document.getElementById('p_y').value = document.getElementById('p_y').defaultValue;
			   			document.getElementById('p_z').value = document.getElementById('p_z').defaultValue;
		  			} else {	//select this face
		  				setFaceColor(pressureColor, val);

				   		document.getElementById('p_x').value = coordinates[0];
				   		document.getElementById('p_y').value = coordinates[1];
				   		document.getElementById('p_z').value = coordinates[2];

				   		// if another face was previously selected, change its color back
				   		if(pface.value != pface.defaultValue){
				   			var myval = parseInt(pface.value) + 2;
				   			setFaceColor(defaultColor, myval);
				   		}
				   		pface.value = face;

				   		var aface = document.getElementById('aface');   //unset aface values if the same
				   		if(aface.value == face){
				   			aface.value = aface.defaultValue;
				   			document.getElementById('a_x').value = document.getElementById('a_x').defaultValue;
				   			document.getElementById('a_y').value = document.getElementById('a_y').defaultValue;
				   			document.getElementById('a_z').value = document.getElementById('a_z').defaultValue;
				   		}
			   		}	
		  		}

		  		// for (i = 1; i <= <?php echo $_GET["max_faces"];?>; i++) {

  				// 	var shape = document.getElementById('Object__Shape_Mat_'.concat(String(i)));
  				// 	shape.addEventListener('mouseout', function(event){
  				// 		setFaceColor('1 1 1', i);
  				// 	}, false);
  				// }

		  	}

		  	function setFaceColor(color, value)
		  	{
		  		document.getElementById('Object__Shape_Mat_'.concat(String(value - 2))).setAttribute('diffuseColor', color);
		  	}

		  	function isSelected(color, value)
		  	{
		  		if (document.getElementById('Object__Shape_Mat_'.concat(String(value - 2))).getAttribute('diffuseColor') == color) {
		  			return true;
		  		} else {
		  			return false;
		  		}
		  	}

		  	function calculateFace(event)	// should probably change this -- don't need to send coordinates anymore
		  	{
		  		var element = document.getElementById('jobid').textContent;
		   		var extracted_id = element.replace("Job Id: ", "");

		  		$.ajax({
		   			type: "POST",
		   			url: 'calls_converter.php',
		   			data: { 
		   				// anchorX: document.getElementById('a_x').value,
		   				// anchorY: document.getElementById('a_y').value,
		   				// anchorZ: document.getElementById('a_z').value,
		   				// pressureX: document.getElementById('p_x').value,
		   				// pressureY: document.getElementById('p_y').value,
		   				// pressureZ: document.getElementById('p_z').value,
		   				a_face: document.getElementById('aface').value, 
		   				p_face: document.getElementById('pface').value, 
		   				job_id: extracted_id
		   			},
		   			success: function(data) {
		   				console.log(data);
		   			}
		   		});
		  	}

		  	function changeCameraAngle(event)
		  	{
		  		document.getElementById('x3d_element').runtime.nextView();
		  	}

		  	function center(event)
		  	{
		  		document.getElementById('x3d_element').runtime.fitAll();
		  	}

		  	/* this doesn't work
		  	function addButton(event)
		  	{
		  		var mydiv = document.getElementById("stuff");
		  		var button = document.createElement("button");
		  		button.type = "button";
		  		button.onclick = addButton(event);
		  		button.value = "More";
		  		mydiv.appendChild(button);
		  	}*/

		  </script>
	  </head>


    <body> 
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<h1>3D Display of Uploaded File (<?php echo $_GET["step_file"];?>)</h1>
					<h5 id=jobid>Job ID: <?php echo $_GET["job_id"];?> </h5>
					<x3d id='x3d_element' width='850px' height='500px' align='center' > 
						<scene>
						<viewpoint id = "angle1" position='45 0 200' orientation="0 0 1 0" description = "Cam Angle 1"></viewpoint>
						<viewpoint id = "angle3" position='300 0 0' orientation="0 1 0 1.57079632679" description = "Cam Angle 3"></viewpoint>
						<viewpoint id = "angle2" position='45 0 -200' orientation="0 1 0 3.1415" description = "Cam Angle 2"></viewpoint>
						<viewpoint id = "angle4" position='-300 0 0' orientation="0 1 0 -1.57079632679" description = "Cam Angle 4"></viewpoint>
						<viewpoint id = "angle5" position='0 300 0' orientation="1 0 0 -1.57079632679" description = "Cam Angle 5"></viewpoint>
						<viewpoint id = "angle6" position='0 -300 0' orientation="1 0 0 1.57079632679" description = "Cam Angle 6"></viewpoint>
						<viewpoint id = "angle7" position='-200 0 200' orientation="0 -1 0 0.7" description = "Cam Angle 6"></viewpoint>

							<inline nameSpaceName="Object" mapDEFToID="true" url="x3d_output/<?php echo $_GET["job_id"];?>.x3d" onclick="displayCoordinates(event)"></inline> 
							<!-- <inline nameSpaceName="Object" mapDEFToID="true" url="x3d_output/37.x3d" onclick="displayCoordinates(event)"></inline>  -->
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
				</div>
				<div class="col-md-3">
					<button type="button" onclick="changeCameraAngle(event)">Change Camera Angle</button>
					<button type="button" onclick="center(event)">Center</button>
					<h5><?php echo $_GET["max_faces"];?></h5>
					<h5 style="color: #FF6666">Left Click for Anchor Selection</h5>
					<h5 style="color: #66FFAA">Right Click for Pressure Selection</h5>
				</div>
				<div class="col-md-3" id="stuff">
					<h1>Properties</h1>
					<form method="post" action="calls_converter.php">
				
					<input type="text" placeholder="Density" name="density"><br>
			
					<input type="text" placeholder="Young's Modulus" name="youngs_mod"><br>
				
					<input type="text" placeholder="Poisson's Ratio" name="poissons"><br>
				
					<input type="text" placeholder="Element Size" name="element_size"><br>
			
					<input type="text" placeholder="Material" name="material"><br>

					<h3>Anchor</h3>
					<h5>Face Number:</h5>
					<input type="text" placeholder="Anchor Face" id="aface" name="aface"><br>
					<h5>Anchor Coordinates:</h5>
					<input type="text" placeholder="X" id="a_x" name="a_x">
					<input type="text" placeholder="Y" id="a_y" name="a_y">
					<input type="text" placeholder="Z" id="a_z" name="a_z"><br>

					<h3>Pressure</h3>
					<h5>Face Number:</h5>
					<input type="text" placeholder="Pressure Face" id="pface" name="pface"><br>
					<h5>Pressure Applied Coordinates:</h5>
					<input type="text" placeholder="X" id="p_x" name="p_x">
					<input type="text" placeholder="Y" id="p_y" name="p_y">
					<input type="text" placeholder="Z" id="p_z" name="p_z"><br>
					<input type="submit" value="Submit">
				</form>
				<!-- <button type="button" onclick="addButton(event)">More</button> -->
				</div>
			</div>
		</div>
    </body>
</html>
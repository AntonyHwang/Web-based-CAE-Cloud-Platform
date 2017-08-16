<!DOCTYPE html>
<html>
	<head>
		<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script> 
		<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
	  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>
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
				header("Location: job_management.php");
			}
			
		?>



		<script>
			var unselectable = [];

			function mouse_unhighlight(event){
				anchorColor = '0 0.75 0.75';
		  		pressureColor = '0.5 1 0.5';
		  		defaultColor = '0.65 0.65 0.65';

				val = parseInt(event.target._x3domNode._objectID);
				var face = val - 2;

				if (unselectable.includes(face) || isSelected(pressureColor, val) || isSelected(anchorColor, val)) 
		  		{
		  			return;
		  		}

		  		setFaceColor(defaultColor, val);
			}

			function mouse_highlight(event){
				anchorColor = '0 0.75 0.75';
		  		pressureColor = '0.5 1 0.5';
		  		defaultColor = '0.65 0.65 0.65';
				
				val = parseInt(event.target._x3domNode._objectID);
				var face = val - 2;

				if (unselectable.includes(face) || isSelected(pressureColor, val) || isSelected(anchorColor, val)) 
		  		{
		  			return;
		  		}

		  		setFaceColor('0.529412 0.807843 0.980392', val); //light blue
			}



		  	function displayCoordinates(event)
		  	{
		  		var coordinates = event.hitPnt;

		  		//alert(Object.keys(event.target._x3domNode));
		  		// alert(event.target._x3domNode._objectID);

		  		val = parseInt(event.target._x3domNode._objectID);
		  		var face = val - 2;
		  		if (unselectable.includes(face)) 
		  		{
		  			return;
		  		}

		  		anchorColor = '0 0.75 0.75';
		  		pressureColor = '0.5 1 0.5';
		  		defaultColor = '0.65 0.65 0.65';

		  		if (event.button == 1) { // for aface
		  			// $('#marker').attr('translation', event.hitPnt);

		  			var aface = document.getElementById('aface');
		  			
		  			if (isSelected(anchorColor, val)) { //unselect this face
		  				setFaceColor(defaultColor, val);
			   			aface.value = aface.defaultValue;
		  			} else {	//select this face
		  				setFaceColor(anchorColor, val);
				   		// if another face was previously selected, change its color back
				   		if(aface.value != aface.defaultValue){
				   			var myval = parseInt(aface.value) + 2;
				   			setFaceColor(defaultColor, myval);
				   		}
				   		aface.value = face;

				   		var pface = document.getElementById('pface');  //unset pface values if the same
				   		if(pface.value == face){
				   			pface.value = pface.defaultValue;
				   		}
			   	}

		  		} else if (event.button == 2) { //for pface
		  			// $('#marker2').attr('translation', event.hitPnt)z

		  			var pface = document.getElementById('pface');

				   	if (isSelected(pressureColor, val)) {	//unselect this face
		  				setFaceColor(defaultColor, val);
		  				
			   			pface.value = pface.defaultValue;
		  			} else {	//select this face
		  				setFaceColor(pressureColor, val);

				   		// if another face was previously selected, change its color back
				   		if(pface.value != pface.defaultValue){
				   			var myval = parseInt(pface.value) + 2;
				   			setFaceColor(defaultColor, myval);
				   		}
				   		pface.value = face;

				   		var aface = document.getElementById('aface');   //unset aface values if the same
				   		if(aface.value == face){
				   			aface.value = aface.defaultValue;
				   		}
			   		}	
		  		}

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

		  	function changeCameraAngle(event)
		  	{
		  		document.getElementById('x3d_element').runtime.nextView();
		  	
			}
			
		  	function center(event)
		  	{
		  		document.getElementById('x3d_element').runtime.fitAll();
		  	}

		  	function getDimensions() {
		  		var x3dnode = document.getElementById("x3d_object");        
			    var totalVol = x3dnode._x3domNode.getVolume();
			    var min = new x3dom.fields.SFVec3f();
			    var max = new x3dom.fields.SFVec3f();
			    totalVol.getBounds(min, max);
			    var vol = max.subtract(min);
			    $('#x_size').append(Math.round(vol.x * 100)/100);
			    $('#y_size').append(Math.round(vol.y*100)/100);
			    $('#z_size').append(Math.round(vol.z*100)/100);

			    var minValue = Math.min.apply(Math, [vol.x, vol.y, vol.z]);
			    var maxElementSize = minValue / 5;
			    var minElementSize = maxElementSize / 4;
			    $('#maxElementSize').attr('value', Math.round(maxElementSize * 100) /100);
			    $('#minElementSize').attr('value', Math.round(minElementSize* 100) / 100);
		  	}

		  	function displayMesh() {
		  		$('#mesh_button').removeAttr("hidden");
		  	}

		  	function checkModel() {
		  		if ($('#sel1').val() === "") {
		  			alert("Granularity must be filled to submit!");
		  			return false;
		  		} else {

			  		//$('#check').attr("hidden", "hidden");
			  		$('#animation').removeAttr("hidden");
			  		$('.row').css("filter","blur(5px)");
			  		
			  		$.ajax({
	                    type: 'POST',
	                    url:'mesh_check.php',
	                    dataType: 'json',
	                    data: {
	                    	job_id: $('#id').val(), 
		                    element_size: $('#sel1').val(),
		                    max_element_size: $('#maxElementSize').val(),
		                    min_element_size: $('#minElementSize').val()
		                },
	                    success: function (data){
	                    	$('#animation').attr("hidden", "hidden");
	                    	$('.row').css("filter","blur(0px)");

	                    	if (data.conversion === "success") {
	                    		$('#submit').removeAttr("hidden");
	                    		alert("Succesfully meshed your model.");
	                    		displayMesh();
	                    	} else {
	                    		alert("Sorry, this file cannot be meshed due to unconnected nodes. Please upload another file.")
	                    	}
	                    }
	                });
			  	}
		  	}

		  	function validateForm() {
		  		if (parseInt($('#anchorTotal').val()) < $('#removedAnchor').val().split(",").length -1 && parseInt($('#pressureTotal').val()) < $('#removedPressure').val().split(",").length -1){
		  			alert("Please select an anchor and a pressure face.");
		  		} else if (parseInt($('#anchorTotal').val()) < $('#removedAnchor').val().split(",").length -1) {
		  			alert("Please select an anchor face.");
		  		} else if (parseInt($('#pressureTotal').val()) < $('#removedPressure').val().split(",").length -1) {
		  			alert("Please select a pressure face.");
		  		} else {
		  			$('.row').css("filter","blur(5px)");
		  			$('#animation').removeAttr("hidden");
		  			return true;
		  		}
		  		return false;
		  	}

		  	

		  	$(document).ready(function(){

		  		$('#bbox').on({
		  			"shown.bs.dropdown": function() { this.closable = false; },
				    "click":             function() { this.closable = true; },
				    "hide.bs.dropdown":  function() { return this.closable; }
		  		});



			    $("#material").on("keydown", function(event) {
			    	// based on ASCII values, allows space, backspace, and delete
			    	var arr = [8,9,16,17,20,32,35,36,37,38,39,40,45,46]; 
					// Allow letters
					for(var i = 65; i <= 90; i++){
						arr.push(i);
					}
					// Prevent default if not in array
					if(jQuery.inArray(event.which, arr) === -1){
						event.preventDefault();
					}
			    });

			    // prevents user from copying and pasting in invalid values
			    $("#material").on("input", function(){
			    	// allow spaces by adding a " " after the Z
					var allowedChars = /[^a-zA-Z]/g;
					if($(this).val().match(allowedChars)){
						$(this).val( $(this).val().replace(allowedChars,'') );
					}
				});


		  		$('.dropdown-item').click(function() {
		  			var input = $(this).closest('.input-group').find('input.element_size');
    				input.val($(this).text());
		  		});

				countP = 0;
				countA = 0;
				$('#pressureT').on('click', '.addBtn', function() {
					if ($.trim($('#pface').val()) === "" || $.trim($('#pvalue').val()) === "") {	return false; }
					$('#pressureT tbody').append('<tr><td><input type="hidden" name="pface'+ countP +'"value=' +$('#pface').val()+'><input type="hidden" name="pvalue'+ countP +'"value=' +$('#pvalue').val()+'><h5> Face:'+$('#pface').val()+', Pressure:'+$('#pvalue').val()+'</h5></td><td><input type="button" value="X" class="delBtn" onclick="attachListener()"></td></tr>');

					$('#pressureTotal').val(countP++);

					unselectable.push(parseInt($('#pface').val()));
					$('#pface').val('');
					$('#pvalue').val('');
					return false; 
				});

				$('#anchorT').on('click', '.addBtn', function() {
					if ($.trim($('#aface').val()) === "") { return false; }
					$('#anchorT tbody').append('<tr><td><input type="hidden" name="aface'+ countA +'"value=' +$('#aface').val()+'><h5> Face:'+$('#aface').val()+'</h5></input></td><td><input type="button" value="X" class="delBtn" onclick="attachListener()"></td></tr>');

					$('#anchorTotal').val(countA++);

					unselectable.push(parseInt($('#aface').val()));
					$('#aface').val('');
					return false; 
				});

				$("table").on('click', '.delBtn', function() {
					face = $(this).parent().parent().find('input[type=hidden]').val();
					var temp = $(this).parent().parent().find('input[type=hidden]').attr('name').substr(5);
					var type = $(this).parent().parent().find('input[type=hidden]').attr('name').substr(0, 1);

					$(this).parent().parent().remove();

					if (type == 'a') {
						$('#removedAnchor').val($('#removedAnchor').val() + temp + ",");

					} else {
						$('#removedPressure').val($('#removedPressure').val() + temp + ",");
					}
					

					setFaceColor('0.65 0.65 0.65', parseInt(face)+2);

					var index = unselectable.indexOf(parseInt(face));
			  		if (index > -1) {
			  			unselectable.splice(index, 1);
			  		}
				});
			})

		  </script>
	  </head>


    <body> 
		<div id="animation" hidden></div>
		<div class="container">
			<div class="row">
				<div class="col-md-9" id="x3d_elements">
					<h1>3D Display of Uploaded File (<?php echo $_GET["step_file"];?>)</h1>
					<!-- <h5 id=jobid>Job ID: <?php echo $_GET["job_id"];?> </h5> -->
					<x3d id='x3d_element' class="x3d_element" align='center' > 
						<div id="instructions">
							<button type="button" onclick="changeCameraAngle(event)" class="btn btn-secondary">Change Camera Angle</button>
							<button type="button" onclick="center(event)" class="btn btn-secondary">Center</button>
							<h5><?php echo $_GET["max_faces"];?></h5>
							<h5 style="color: #FF6666">Left Click for Anchor Selection</h5>
							<h5 style="color: #66FFAA">Right Click for Pressure Selection</h5>
						</div>

						<scene>

						<viewpoint id = "angle1" position='45 0 200' orientation="0 0 1 0" description = "Cam Angle 1"></viewpoint>
						<viewpoint id = "angle3" position='300 0 0' orientation="0 1 0 1.57079632679" description = "Cam Angle 3"></viewpoint>
						<viewpoint id = "angle2" position='45 0 -200' orientation="0 1 0 3.1415" description = "Cam Angle 2"></viewpoint>
						<viewpoint id = "angle4" position='-300 0 0' orientation="0 1 0 -1.57079632679" description = "Cam Angle 4"></viewpoint>
						<viewpoint id = "angle5" position='0 300 0' orientation="1 0 0 -1.57079632679" description = "Cam Angle 5"></viewpoint>
						<viewpoint id = "angle6" position='0 -300 0' orientation="1 0 0 1.57079632679" description = "Cam Angle 6"></viewpoint>
						<viewpoint id = "angle7" position='-200 0 200' orientation="0 -1 0 0.7" description = "Cam Angle 6"></viewpoint>

						<inline id="x3d_object" onload="center(); getDimensions();" nameSpaceName="Object" mapDEFToID="true" url="x3d_output/<?php echo $_GET["job_id"];?>.x3d" onmouseover="mouse_highlight(event)" onmouseout="mouse_unhighlight(event)" onclick="displayCoordinates(event)"></inline> 
						<!-- <inline id="x3d_object" onload="center(); getDimensions();" nameSpaceName="Object" mapDEFToID="true" url="gmsh_output/305/temp.x3d" onmouseover="mouse_highlight(event)" onmouseout="mouse_unhighlight(event)" onclick="displayCoordinates(event)"></inline> -->

						<Transform id="marker" scale="0 0 0" translation="0 0 0">
							<Shape>
								<Appearance>
									<Material diffuseColor="#FF6666"></Material>
								</Appearance>
								<Sphere></Sphere>
							</Shape>
						</Transform>

						<Transform id="marker2" scale="0 0 0" translation="0 0 0">
							<Shape>
								<Appearance>
									<Material diffuseColor="#66FFAA"></Material>
								</Appearance>
								<Sphere></Sphere>
							</Shape>
						</Transform>

						</scene> 
					</x3d> 
					<form target='_blank' action='view_mesh.php' method='post'>
						<input id='id' name='id' type='hidden' value='<?php echo $_GET['job_id'];?>'>
						<button id='mesh_button' style='width=auto; height=auto;color:black;' type='submit' hidden>View Mesh</button>
					</form>
				</div>

				<div class="col-md-3" id="properties">
					<h1>Properties</h1>
						<form id="selection_data" onsubmit="return validateForm();" method="post" action="calls_converter.php" >

						<h5>Job Id:</h5>
						<input type="text" value="<?php echo $_GET["job_id"];?>" name="id" id="id" readonly><br>
					
						<input type="text" placeholder="Density" id="density" name="density" required><br>
				
						<input type="text" placeholder="Young's Modulus" id="youngs_mod" name="youngs_mod" required><br>
					
						<input type="text" placeholder="Poisson's Ratio" id="poissons" name="poissons" required><br>
					
						<!-- <input type="text" placeholder="Element Size" name="element_size"><br> -->
				
						<input type="text" placeholder="Material Name" id="material" name="material" required><br>

						<div id="bbox" class="dropdown">
							<input type="text" class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" value="Size of Object" readonly></input>
							<div id="temp" style="text-align:left; color:black; padding-left: 5px;" class="dropdown-menu" aria-labelledby="dropdownMenu2">
								<b id="x_size" class="dropdown-item bbox">x: </b><br>
								<b id="y_size" class="dropdown-item bbox">y: </b><br>
								<b id="z_size" class="dropdown-item bbox">z: </b><br>
							</div>
						</div>
						
						<h3>Anchor</h3>
						<h5>Face Number:</h5>
						<table class="table" id="anchorT">
							<thead>
								<tr>
									<th style="width:83%">
										<input type="text" placeholder="Anchor Face" id="aface" name="aface">
										<input type="hidden" id="anchorTotal" name="anchorTotal" value="-1">
										<input type="hidden" id="removedAnchor" name="removedAnchor"><br>
									</th>
									<th style="width: 17%"><input type="button" value="+" class="addBtn"></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

						<h3>Pressure</h3>
						<h5>Face Number:</h5>
						<table class="table" id="pressureT">
							<thead>
								<tr>
									<th style="width:83%">
										<input type="text" placeholder="Pressure Face" id="pface" name="pface">
										<input type="text" placeholder="Pressure value" id="pvalue" name="pvalue">
										<input type="hidden" id ="pressureTotal" name="pressureTotal" value="-1">
										<input type="hidden" id="removedPressure" name="removedPressure"><br>
									</th>
									<th style="width:17%"><input type="button" value="+" class="addBtn"></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<h3>Mesh Control</h3>
						<h7>Mesh Scaling Factor:</h7>
						<select name="element_size" class="form-control" id="sel1" required>
							<option value="" hidden>Mesh Scaling Factor</option>
							<option value="1.0" selected>1.0</option>
							<option value="0.9">0.9</option>
							<option value="0.8">0.8</option>
							<option value="0.7">0.7</option>
							<option value="0.6">0.6</option>
							<option value="0.5">0.5</option>
							<option value="0.4">0.4</option>
							<option value="0.3">0.3</option>
							<option value="0.2">0.2</option>
						</select>
						<h7>Maximum Element Size:</h7>
						<input type="text" placeholder="Max Element Size" name="maxElementSize" id="maxElementSize"><br>
						<h7>Minimum Element Size:</h7>
						<input type="text" placeholder="Min Element Size" name="minElementSize" id="minElementSize"><br>
						

						<input id="check" title="Granularity field must be filled to submit." type="button" value="Check Model" onclick="checkModel();">
						<input id="submit" type="submit" value="Submit" hidden>

						<!-- <input id="submit" type="submit" value="Submit" disabled> -->
						</form>


				</div>
			</div>
		</div>
    </body>
</html>
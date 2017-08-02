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
	  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>



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

		  	

		  	$(document).ready(function(){

			  	$('form > input').keyup(function() {
			        var empty = false;
			        $('form > input').each(function() {
			            if ($(this).val() == '') {
			                empty = true;
			            }
			        });

			        if (empty) {
			            $('#submit').attr('disabled', 'disabled');
			        } else {
			            $('#submit').removeAttr('disabled');
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
					$('#pressureT tbody').append('<tr><td><input type="hidden" name="pface'+ countP +'"value=' +$('#pface').val()+'><input type="hidden" name="pvalue'+ countP +'"value=' +$('#pvalue').val()+'><h5> Face:'+$('#pface').val()+', Pressure:'+$('#pvalue').val()+'</h5></td><td><button type="button" class="btn delBtn"> X </button></td></tr>');

					$('#pressureTotal').val(countP++);

					unselectable.push(parseInt($('#pface').val()));
					$('#pface').val('');
					$('#pvalue').val('');
					return false; 
				});

				$('#anchorT').on('click', '.addBtn', function() {
					if ($.trim($('#aface').val()) === "") { return false; }
					$('#anchorT tbody').append('<tr><td><input type="hidden" name="aface'+ countA +'"value=' +$('#aface').val()+'><h5> Face:'+$('#aface').val()+'</h5></input></td><td><button type="button" class="btn delBtn"> X </button></td></tr>');

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
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<h1>3D Display of Uploaded File (<?php echo $_GET["step_file"];?>)</h1>
					<!-- <h5 id=jobid>Job ID: <?php echo $_GET["job_id"];?> </h5> -->
					<x3d id='x3d_element' width='850px' height='500px' align='center' > 
						<scene>
						<viewpoint id = "angle1" position='45 0 200' orientation="0 0 1 0" description = "Cam Angle 1"></viewpoint>
						<viewpoint id = "angle3" position='300 0 0' orientation="0 1 0 1.57079632679" description = "Cam Angle 3"></viewpoint>
						<viewpoint id = "angle2" position='45 0 -200' orientation="0 1 0 3.1415" description = "Cam Angle 2"></viewpoint>
						<viewpoint id = "angle4" position='-300 0 0' orientation="0 1 0 -1.57079632679" description = "Cam Angle 4"></viewpoint>
						<viewpoint id = "angle5" position='0 300 0' orientation="1 0 0 -1.57079632679" description = "Cam Angle 5"></viewpoint>
						<viewpoint id = "angle6" position='0 -300 0' orientation="1 0 0 1.57079632679" description = "Cam Angle 6"></viewpoint>
						<viewpoint id = "angle7" position='-200 0 200' orientation="0 -1 0 0.7" description = "Cam Angle 6"></viewpoint>

						<inline onload="center()" nameSpaceName="Object" mapDEFToID="true" url="x3d_output/<?php echo $_GET["job_id"];?>.x3d" onmouseover="mouse_highlight(event)" onmouseout="mouse_unhighlight(event)" onclick="displayCoordinates(event)"></inline> 
						
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
					
						<button type="button" onclick="changeCameraAngle(event)" class="btn btn-secondary">Change Camera Angle</button>
						<button type="button" onclick="center(event)" class="btn btn-secondary">Center</button>
						<h5><?php echo $_GET["max_faces"];?></h5>
						<h5 style="color: #FF6666">Left Click for Anchor Selection</h5>
						<h5 style="color: #66FFAA">Right Click for Pressure Selection</h5>
					
				</div>
				<div class="col-md-3" id="stuff">
					<h1>Properties</h1>
						<form id="selection_data" method="post" action="calls_converter.php">

						<h5>Job Id:</h5>
						<input type="text" value="<?php echo $_GET["job_id"];?>" name="id"><br>
					
						<input type="text" placeholder="Density" id="density" name="density"><br>
				
						<input type="text" placeholder="Young's Modulus" id="youngs_mod" name="youngs_mod"><br>
					
						<input type="text" placeholder="Poisson's Ratio" id="poissons" name="poissons"><br>
					
						<!-- <input type="text" placeholder="Element Size" name="element_size"><br> -->

						<b class="input-group">
					      	<b class="input-group-btn">
						        <button type="button" class="btn btn-secondary dropdown-toggle test" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top: 8.5; padding-bottom: 8.5; margin-bottom: 7px; padding-bottom: 9px; padding-top: 9px;">
									<span class="caret"></span>
						        </button>
						        <b class="dropdown-menu">
							        <ul>
							          	<a class="dropdown-item" href="#">0.2</a>
	          							<div role="separator" class="dropdown-divider"></div>
								        <a class="dropdown-item" href="#">0.3</a>
	          							<div role="separator" class="dropdown-divider"></div>
								        <a class="dropdown-item" href="#">0.4</a>
	          							<div role="separator" class="dropdown-divider"></div>
								        <a class="dropdown-item" href="#">0.5</a>
	          							<div role="separator" class="dropdown-divider"></div>
								        <a class="dropdown-item" href="#">0.6</a>
	          							<div role="separator" class="dropdown-divider"></div>
								        <a class="dropdown-item" href="#">0.7</a>
	          							<div role="separator" class="dropdown-divider"></div>
								       	<a class="dropdown-item" href="#">0.8</a>
	          							<div role="separator" class="dropdown-divider"></div>
								        <a class="dropdown-item" href="#">0.9</a>
	          							<div role="separator" class="dropdown-divider"></div>
								        <a class="dropdown-item" href="#">1.0</a>
							        </ul>
						        </b>
						    </b>
						    <input type="text" class="element_size" placeholder="Clscale" id="element_size" name="element_size">
						</b>
						
				
						<input type="text" placeholder="Material" name="material"><br>
						
						<font color = "white"><h3>Anchor</h3></font>
						<h5>Face Number:</h5>
						<table class="table" id="anchorT">
							<thead>
								<tr>
									<th><input type="text" placeholder="Anchor Face" id="aface" name="aface"><br></th>
									<th><button type="button" class="btn addBtn">add</button></th>
									<th><input type="hidden" id="anchorTotal" name="anchorTotal" value="0"></input></th>
									<th><input type="hidden" id="removedAnchor" name="removedAnchor"></input></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

						<font color = "white"><h3>Pressure</h3></font>
						<h5>Face Number:</h5>
						<table class="table" id="pressureT">
							<thead>
								<tr>
									<th>
										<input type="text" placeholder="Pressure Face" id="pface" name="pface">
										<input type="text" placeholder="Pressure value" id="pvalue" name="pvalue"><br>
									</th>
									<th><button type="button" class="btn addBtn">add</button></th>
									<th><input type="hidden" id ="pressureTotal" name="pressureTotal" value="0"></input></th>
									<th><input type="hidden" id="removedPressure" name="removedPressure"></input></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>

						<input id="submit" type="submit" value="Submit" disabled>
					</form>


				</div>
			</div>
		</div>
    </body>
</html>
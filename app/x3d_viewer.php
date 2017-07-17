<!DOCTYPE html>
<html>
	<head>
		<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script> 
		<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
	  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>
	

		<script>
		  	function displayCoordinates(event)
		  	{
		  		//alert('Clicked on object!')
		  		$('#marker').attr('translation', event.hitPnt);

		  		var coordinates = event.hitPnt;
		   		$('#coordX').html(coordinates[0]);
		   		$('#coordY').html(coordinates[1]);
		   		$('#coordZ').html(coordinates[2]);

		   		$.ajax({
		   			type: "POST",
		   			url: 'calls_converter.php',
		   			data: { 
		   				pointX: coordinates[0],
		   				pointY: coordinates[1],
		   				pointZ: coordinates[2],

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

        <x3d width='500px' height='400px'> 
            <scene>
            	<inline url="x3d_output/<?php echo $_GET["job_id"];?>.x3d" onclick="displayCoordinates(event)"></inline> 
            	<Transform id="marker" scale="2.5 2.5 2.5" translation="100 0 0">
			        <Shape>
			            <Appearance>
			                <Material diffuseColor="#FFD966"></Material>
			            </Appearance>
			            <Sphere></Sphere>
			        </Shape>
			    </Transform>
            </scene> 
        </x3d> 

        <h3>Click coordinates:</h3>
		<table style="font-size:1em;">
			<tr><td>X: </td><td id="coordX">-</td></tr>
			<tr><td>Y: </td><td id="coordY">-</td></tr>
			<tr><td>Z: </td><td id="coordZ">-</td></tr>
		</table> 

    </body>
</html>
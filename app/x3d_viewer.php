<!DOCTYPE html>
<html>
<head>
	<script type='text/javascript' src='http://www.x3dom.org/download/x3dom.js'> </script> 
	<link rel='stylesheet' type='text/css' href='http://www.x3dom.org/download/x3dom.css'></link>
  	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.0.min.js" ></script>
</head>
    <body>
        <x3d width='500px' height='400px'> 
            <scene>
            <inline url="x3d_output/<?php echo $_GET["job_id"];?>.x3d"> </inline> 
            </scene> 
        </x3d>  

    </body>
</html>
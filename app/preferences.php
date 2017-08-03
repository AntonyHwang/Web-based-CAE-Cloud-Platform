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
		?>
	</head>

	<body>
		<h1>Watch Funny Videos Here!</h1>
		<div align="center">
			<h3><font color="white">Charlie Videos</font>></h3>
			<table class="table">
				<tr>
					<td>
						<h5>Charlie Bit Me!</h5>
						<iframe width="560" height="315" src="https://www.youtube.com/embed/fPDYj3IMkRI?ecver=1" frameborder="0" allowfullscreen></iframe>
					</td>
					<td>
						<h5>Charlie the Unicorn!</h5>
						<iframe width="560" height="315" src="https://www.youtube.com/embed/CsGYh8AacgY?ecver=1" frameborder="0" allowfullscreen></iframe>
					</td>
					<td>
						<h5>Charlie Puth - Attention [Official Video]!</h5>
						<iframe width="560" height="315" src="https://www.youtube.com/embed/nfs8NYg7yQM?ecver=1" frameborder="0" allowfullscreen></iframe>
					</td>
				</tr>
				<tr>
					<td>
						<h5>Charlie Chaplin - Boxing Comedy - City Lights</h5>
						<iframe width="560" height="315" src="https://www.youtube.com/embed/v8RkNHmSgns?ecver=1" frameborder="0" allowfullscreen></iframe>
					</td>
					<td>
						<h5>Charlie Puth - One Call Away [Official Video]!</h5>
						<iframe width="560" height="315" src="https://www.youtube.com/embed/BxuY9FET9Y4?ecver=1" frameborder="0" allowfullscreen></iframe>
					</td>
					<td>
						<h5>Charlie | Puthumazhayai Song Video|</h5>
						<iframe width="560" height="315" src="https://www.youtube.com/embed/GN50IHHUc4U?ecver=1" frameborder="0" allowfullscreen></iframe>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
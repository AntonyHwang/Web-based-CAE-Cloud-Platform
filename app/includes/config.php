<?php
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = 'root';
    $dbname = 'test_db';
    $conn = mysql_connect($dbhost, $dbuser, $dbpass);

    if(! $conn ) {
    die('Could not connect: ' . mysql_error());
    }

    echo 'Connected successfully';
    mysql_select_db($dbname);
?>
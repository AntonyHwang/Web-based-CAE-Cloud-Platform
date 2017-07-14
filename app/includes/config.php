<?php
    $host = '127.0.0.1';
    $user = 'root';
    $pass = 'root';
    $db_name = 'test_db';

    $dbh = new PDO('mysql:host='.$host.';dbname='.$db_name, $user, $pass);
?>
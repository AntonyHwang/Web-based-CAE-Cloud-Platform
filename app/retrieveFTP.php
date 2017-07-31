<?php
    //basic connection
    $connId = ftp_connect($ftp_server);

    //login with user id and password
    $login = ftp_login($connId,$usrId,$password);

    if (!($connId && $login)) {
        echo "connection failed";
        echo "Attempted to connnect to $ftp_server for user $usrId";
        exit;
    } else {
        echo "Connected to $ftp_server, for user $usrId";
    }

    $ftp_retrieve = ftp_get($connId, $destination_file, $source_file, FTP_BINARY_BINARY);

    if (!$ftp_retrieve) {
        echo "FTP retrieval has failed!";
    } else {
        echo "Retrieved $source_file from $ftp_server as $destination_file";
    }

    ftp_close($connId);

?>
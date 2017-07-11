<!DOCTYPE html>
<html>
<body>

<form action="index.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload STP" name="submit">
</form>

</body>
</html>

<?php
    $HOST = "127.0.0.1";
    $USERNAME = "root";
    $PASSWORD = "root";
    $DB ="test_db";
    $link = mysql_connect($HOST, $USERNAME, $PASSWORD);
    //if connection is not successful you will see text error
    if (!$link) {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($DB);

    $target_dir = "stp_uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "stp" ) {
        echo "Sorry, only STP files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $filename = basename( $_FILES["fileToUpload"]["name"]);
            $insert_q = mysql_query("INSERT INTO job (stp_filename, finished) VALUE ('"$filename"', 0)");
            $get_id_q = mysql_query("SELECT LAST_INSERT_ID();");
            $job_id = mysql_result($get_id_q, 0);
            $result = exec("python py/app.py $filename");
            echo "The file ".$filename. " has been uploaded.";
            echo $result;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    mysql_close($link);
?>
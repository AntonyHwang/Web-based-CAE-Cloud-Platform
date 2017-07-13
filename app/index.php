<!DOCTYPE html>

<?php
	require ("includes/config.php");
?>

<html>
<body>

<form action="index.php" method="post" enctype="multipart/form-data">
    Select STP File:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload STP" name="submit">
</form>

</body>
</html>

<?php
    if (!empty($_POST)) {
        $target_dir = "stp_uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($fileType != "stp" && $fileType != "step" && $fileType != "STEP" ) {
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $filename = basename( $_FILES["fileToUpload"]["name"]);
                $sql_insert = "INSERT INTO job (stp_filename, finished) VALUE ('".$filename."', 0)";
                $sth = $dbh->query($sql_insert);
                $sth = null;
                $job_id = $dbh->lastInsertId();
                rename("stp_uploads/$filename", "stp_uploads/$job_id.stp");
                $result = shell_exec('python py/app.py '.$job_id);
                echo "The file ".$filename. " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
?>
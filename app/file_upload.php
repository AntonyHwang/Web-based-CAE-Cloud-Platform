<!DOCTYPE html>

<?php
	require("includes/config.php");
    include_once "includes/header.php";
    if ($_SESSION["logged_in"] != "YES") {
        header("Location: login.php");
    }
?>

<html>
<body>
      <div class ="login">  
        <form action="file_upload.php" method="post" enctype="multipart/form-data"> 
            <h1>File Upload</h1>
            <input type="file" name="fileToUpload" id="fileToUpload"> 
            <input type="submit" class="btn btn-block btn-large" value="Upload STP" name="submit">

        </form>
      </div>  

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
            set_time_limit(120);

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $filename = basename( $_FILES["fileToUpload"]["name"]);
                $sql_insert = "INSERT INTO job (id_user, stp_filename, finished) VALUE ('".$_SESSION["id"]."','".$filename."', 0)";
                $sth = $dbh->query($sql_insert);
                $sth = null;
                $job_id = $dbh->lastInsertId();
                rename("stp_uploads/$filename", "stp_uploads/$job_id.step");
                // $result = exec('python py/app.py 2>&1'.$job_id);

                $call_python = $py_path." py/app.py 2>&1".$job_id;
                $result = shell_exec($call_python);
                header("Location: x3d_viewer.php?job_id=".$job_id."&step_file=".$filename);
                //echo "The file ".$filename. " has been uploaded.";
                //echo $result;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
?>
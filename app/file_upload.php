<!DOCTYPE html>

<?php
	require ("includes/config.php");
    include_once "includes/header.php";
?>

<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
      <div class ="login">  
            <h1>File Upload</h1>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#STP">STP</a></li>
                <li><a data-toggle="tab" href="#MSH">Lattice Generator</a></li>
            </ul>

            <div class="tab-content">
                <div id="STP" class="tab-pane fade in active">
                    <form action="file_upload.php" method="post" enctype="multipart/form-data"> 
                        <br>
                        <input type="file" name="fileToUpload" id="fileToUpload"> 
                        <br>
                        <input type="submit" class="btn btn-block btn-large" value="Upload STP" name="stp">
                    </form>
                </div>
                <div id="MSH" class="tab-pane fade"> 
                    <form action="file_upload.php" method="post" enctype="multipart/form-data"> 
                        <h5>Node File:</h5>
                        <input type="file" name="node_fileToUpload" id="node_fileToUpload"> 
                        <h5>Element File:</h5>
                        <input type="file" name="element_fileToUpload" id="element_fileToUpload"> 
                        <h5>Dimension:</h5>
                        <input type="number" name="x" placeholder="x" required="required" />
                        <br><br>
                        <input type="number" name="y" placeholder="y" required="required" />
                        <br><br>
                        <input type="number" name="z" placeholder="z" required="required" />
                        <br><br>
                        <input type="submit" class="btn btn-block btn-large" value="Upload Shape" name="msh">
                    </form>
                </div>
            </div>
      </div>  
</body>
</html>

<?php
    if ($_POST['stp']) {
        $target_dir = "stp_uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($fileType != "stp" && $fileType != "step" && $fileType != "STEP") {
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
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
                echo "The file ".$filename. " has been uploaded.";
                echo $result;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    if ($_POST['msh']) {
        $x = $_POST['x'];
        $y = $_POST['y'];
        $z = $_POST['z'];
        $node_target_dir = "lg_uploads/node_uploads/";
        $element_target_dir = "lg_uploads/element_uploads/";
        $node_target_file = $node_target_dir . basename($_FILES["node_fileToUpload"]["name"]);
        $element_target_file = $element_target_dir . basename($_FILES["element_fileToUpload"]["name"]);
        $uploadOk = 1;
        $node_fileType = pathinfo($node_target_file,PATHINFO_EXTENSION);
        $element_fileType = pathinfo($element_target_file,PATHINFO_EXTENSION);
        // Allow certain file formats
        if($node_fileType != "txt" && $node_fileType != "TXT" && $element_fileType != "txt" && $element_fileType != "TXT") {
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["node_fileToUpload"]["tmp_name"], $node_target_file) && move_uploaded_file($_FILES["element_fileToUpload"]["tmp_name"], $element_target_file)) {
                $node_filename = basename( $_FILES["node_fileToUpload"]["name"]);
                $element_filename = basename( $_FILES["element_fileToUpload"]["name"]);
                $sql_insert = "INSERT INTO lg_job (id_user) VALUE ('".$_SESSION["id"]."')";
                $sth = $dbh->query($sql_insert);
                $sth = null;
                $job_id = $dbh->lastInsertId();
                rename("lg_uploads/node_uploads/$node_filename", "lg_uploads/node_uploads/$job_id.txt");
                rename("lg_uploads/element_uploads/$element_filename", "lg_uploads/element_uploads/$job_id.txt");                
                // $result = exec('python py/app.py 2>&1'.$job_id);

                $call_python = $py_path." py/lg_app.py 2>&1".$job_id." ".$x." ".$y." ".$z;
                echo $call_python;
                sleep(2);
                $result = shell_exec($call_python);
                //header("Location: x3d_viewer.php?job_id=".$job_id."&step_file=".$filename);
                echo "The file ".$filename. " has been uploaded.";
                echo $result;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
?>
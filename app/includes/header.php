<!DOCTYPE html>
<html lang="en">

<head>
    <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
            <!-- logo -->
            <div class="navbar-header">
                <a href="#" class="navbar-brand">CAE Cloud Platform</a>
            </div>
            <!-- menu items -->
            <div>
                <ul class="nav navbar-nav">
                    <?php
                        if ($_SESSION["logged_in"] == "NO" || $_SESSION["id"] == ""){
                    ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php
                        }
                        else{
                    ?>
                        <li><a href="file_upload.php">File Upload</a></li>
                        <li><a href="job_management.php">Job Managmanet</a></li>
                        <li><a href="login.php">Log out</a></li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
    </nav>
</head>

<body>
</body>
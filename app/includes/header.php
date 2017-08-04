<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        $('.collapse').collapse("toggle")
    </script>
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
            <!-- logo -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-controls="header-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand">CAE Cloud Platform</a>
            </div>
            <!-- menu items -->
            <div class="collapse navbar-collapse" id="#header-collapse">
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
                        <li><a href="job_management.php">Job Management</a></li>
                        <li><a href="preferences.php">Preferences</a></li>
                        <li><a href="login.php">Log out</a></li>
                    <?php
                        }
                    ?>
                </ul>
            </div>
    </nav>

</body>
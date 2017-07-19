<?php 
    require "includes/config.php"; 
?>
<html>
    <head></head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- logo -->
                <div class="navbar-header">
                    <a href="#" class="navbar-brand">CAE Cloud Platform</a>
                </div>
                <!-- menu items -->
                <div>
                    <ul class="nav navbar-nav">
                        <li><a href="login.php">Login</a></li>
                        <li class="active"><a href="register.php">Register</a></li>
                    </ul>
                </div>
        </nav>
    </body>
    <form action="register.php" method="post" align="center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                </div>
                <div class="col-md-2">
                    <fieldset>
                        <div class="form-group">
                            <input autofocus class="form-control" name="first_name" id="first_name" placeholder="First Name" type="text" size="30"/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="surname" id="surname" placeholder="Surname" type="text" size="30"/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="email" id="email" placeholder="Email" type="text" size="30"/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="password" id="password" placeholder="Password" type="password" size="30"/>
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="confirmation" id="confirmation" placeholder="Confirm Password" type="password" size="30"/>
                        </div><br>
                        <div class="form-group">
                            <button class="btn btn-default" type="submit" style="vertical-align:left; float: center">
                                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                                Register
                            </button>
                            <br>
                            <br>
                            <button class="btn btn-default" type="reset" style="vertical-align:left; float: center">
                                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                                Clear
                            </button>
                        </div><br>
                    </fieldset>
                </div>
                <div class="col-md-5">
                </div>
            </div>
        </div>
    </form>
<?php
    
    if(!empty($_POST)) {
        // Retrieve data
        $first_name = strtolower($_POST['first_name']);
        $surname = strtolower($_POST['surname']);
        $email = strtolower($_POST['email']);
       
        $password = $_POST['password'];
        $password_confirm = $_POST['confirmation'];
        $sql_select = "SELECT * FROM user WHERE email = '".$email."'";
        $registrants = $dbh->query($sql_select);

        //  Data Validation
        if(!test_input($first_name)) {
            echo "<script>alert('You must enter your first name');</script>";
        }
        else if (!preg_match("/^[a-zA-Z ]*$/",$first_name)) {
            echo "<script>alert('First name incorrect format');</script>";
        }
        else if(!test_input($surname)) {
            echo "<script>alert('You must enter your surname');</script>";
        }
        else if (!preg_match("/^[a-zA-Z ]*$/",$surname)) {
            echo "<script>alert('Surname incorrect format');</script>";
        }
        else if(!test_input($email)) {
            echo "<script>alert('You must enter your email');</script>";
        }
        else if(!test_input($password)) {
            echo "<script>alert('You must enter a valid password');</script>";
        }
        else if($password != $password_confirm) {
            echo "<script>alert('Password does not match');</script>";
        }
        else if(count($registrants) != 0) {
            echo "<script>alert('Email already registered');</script>";
        } 
         else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format');</script>";
        }
     
     //Insert registration info
        else {
            $sql_insert = "INSERT INTO user (first_name, surname, email, password) VALUES ('".$first_name."','".$surname."','".$email."','".shal($password)."');";
            echo "<script>alert('".$sql_insert."');</script>";
            $sql_get_id = "SELECT accountID FROM user WHERE email = '".$email."';";
            // $stmt = $dbh->query($sql_insert);
            // $sth = null;
            // $stmt = $dbh->query($sql_get_id);
            // $rows = $stmt->fetch();
            // $_SESSION["id"] = $rows["id_user"];
            // $_SESSION["logged_in"] = "YES";
            // echo $sql_insert;
            //header('Location:file_upload.php');
        }
    }

    function test_input($data) {
        if(!isset($data) || trim($data) == '') {
            return false;
        }
        else {
            return true;
        }
    }
?>
</html>

<?php 
    require "includes/config.php"; 
    include_once "includes/header.php";
    if ($_SESSION["logged_in"] == "YES") {
        header('Location:file_upload.php');
    }
?>
<html>
    <head></head>
    <body>
    </body>
    <form action="register.php" method="post" align="center">
        <div class="login">
            <h1>Register</h1>
            <form method="post">
                <input type="text" name="first_name" id="first_name" placeholder="First Name" required="required" />
                <input type="text"  name="surname" id="surname" placeholder="Surname" required="required" />
                <input type="text" name="email" id="email" placeholder="Email" required="required" />
                <input type="password" name="password" id="password" placeholder="Password" required="required" />
                <input type="password" name="confirmation" id="confirmation" placeholder="Confirm Password" required="required" />
                <div class="row">
                    <div class="col-xs-7" style="padding-right: 5px;">
                    <button type="submit" class="btn btn-block btn-large">Register</button>
                    </div>
                    <div class="col-xs-5" style="padding-left: 5px;">
                    <button type="reset" class="btn btn-block btn-large">Clear</button>
                    </div>
                </div>
            </form>
            <br>
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
        $get_record = $dbh->query($sql_select);
        $registrants = $get_record->fetchAll();

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
            $sql_insert = "INSERT INTO user (first_name, surname, email, password) VALUES ('".$first_name."','".$surname."','".$email."','".sha1($password)."');";
            $sql_get_id = "SELECT id_user FROM user WHERE email = '".$email."';";
            $insert_new_account = $dbh->query($sql_insert);
            $get_id = $dbh->query($sql_get_id);
            $rows = $get_id->fetch();
            $_SESSION["id"] = $rows["id_user"];
            $_SESSION["logged_in"] = "YES";
            header('Location:file_upload.php');
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

<?php
    ob_start();
    $host = '127.0.0.1';
    $user = 'root';
    $pass = 'root';
    $db_name = 'test_db';

    $dbh = new PDO('mysql:host='.$host.';dbname='.$db_name, $user, $pass);
    $py_path = "C:/ProgramData/Miniconda2/python.exe";

    if ($_SESSION["logged_in"] == "YES") {
        header('Location:file_upload.php');
    }
?>

<html>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/mystyle.css">
</html>

 <html>
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
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    </ul>
                </div>
        </nav>
    </head>
    <body>
        <form action="login.php" method="post" align="center">
            <div class="login">
                <h1>Login</h1>
                <form method="post">
                    <input type="text" name="email" placeholder="Email" required="required" />
                    <input type="password" name="password" placeholder="Password" required="required" />
                    <button type="submit" class="btn btn-block btn-large">Log In</button>
                </form>
                <br>
            </div>
        </form>
    </body>

    <?php
        //Insert registration info
        if(!empty($_POST)) {
            try {
                // Retrieve data
                $email =$_POST['email'];
                $password = $_POST['password'];
                $sql_select = "SELECT * FROM user WHERE email = '".$email."' AND password = '".sha1($password)."'";
                $stmt = $dbh->query($sql_select);
                if(!test_input($email)) {
                    echo "<script>alert('You must enter your email');</script>";
                }
                else if(!test_input($password)) {
                    echo "<script>alert('You must enter your password');</script>";
                }
                else if($row = $stmt->fetch()) {
                    session_start();
                    $_SESSION["id"] = $row["id_user"];;
                    $_SESSION["logged_in"] = "YES";
                    header('Location:file_upload.php');
                }
                //Otherwise, render index/homepage. Set seesion to be logged in
                else {
                    echo "<script>alert('The email address or password is incorrect');</script>";
                }
            }
            catch(Exception $e) {
                die(var_dump($e));
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

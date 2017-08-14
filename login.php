<?php      
    require 'includes/config.php'; 
    $_SESSION["logged_in"]="NO";
    $_SESSION["id"] = "";
    include_once "includes/header.php";
?>
 <html>
    <head></head>
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

<?php 
    $_SESSION['logged_in'] = "NO";
    $_SESSION['id'] = "";  
    session_unset();
    sleep(1);
    header('Location:login.php');
?>
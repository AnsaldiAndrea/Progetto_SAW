<?php
    session_start();
    include("helper/functions.php");
    upload_profile_pic('profile_pic', $_SESSION['username']);
    header("Location: profilo.php");
    exit();
?>
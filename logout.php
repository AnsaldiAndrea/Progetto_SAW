<?php
session_start();

unset($_SESSION['logged_in']);
unset($_SESSION['name']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['address']);
unset($_SESSION['age']);
unset($_SESSION['lat']);
unset($_SESSION['lng']);
unset($_SESSION['error']);

$_SESSION['error'] = ['success', 'Logout avvenuto con successo!'];

header("Location:index.php");
exit();
?>
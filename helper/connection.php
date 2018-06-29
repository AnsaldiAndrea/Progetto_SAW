<?php
//completare con le credenziali
$conn = new mysqli("localhost","root","Nuvoletta2","progetto");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

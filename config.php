<?php
//data credentials
$server = 'localhost';
$user = 'root';
$password = '';
$database = 'pizza_delivery';
//connect to MySQL database
$connect = new mysqli($server, $user, $password, $database) or die("Unable to connect");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
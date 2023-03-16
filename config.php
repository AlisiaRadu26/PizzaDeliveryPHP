<?php
//data credentials
$server = 'eu-cdbr-west-03.cleardb.net';
$user = 'b6ed5024df6013';
$password = '8654d565';
$database = 'heroku_6580760ffd21ba2';
//connect to MySQL database
$connect = new mysqli($server, $user, $password, $database) or die("Unable to connect");
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

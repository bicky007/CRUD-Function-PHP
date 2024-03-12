<?php

$servername = "localhost";
$username = "YOUR_USERNAME";
$password = "YOUR_PASSWOR";
$dbname = "DATABASE_NAME";

$link = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

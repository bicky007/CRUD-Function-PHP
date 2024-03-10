<?php

$servername = "localhost";
$username = "bicky.k";
$password = "booNue3U";
$dbname = "bicky";

$link = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
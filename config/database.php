<?php

session_start();

$server   = "localhost";
$username = "root";
$password = "";
$database = "bincom_test";

$con = mysqli_connect($server, $username, $password, $database);

if (mysqli_connect_errno()) {
    die("couldn't connect to database" . mysqli_connect_error());
}else{
    // echo "success";
}

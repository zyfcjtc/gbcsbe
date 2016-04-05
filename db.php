<?php

$host = "localhost";
$username = "j3pteam6_admin";
$password = "fZ5V_uZ(2Hu(";
$database = "j3pteam6_gbsbe";
$link = mysqli_connect($host, $username, $password, $database);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "atlanta_soft";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

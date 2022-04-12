<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'italk';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    $errorAlert = "Connection failed due to " . mysqli_connect_error();
}

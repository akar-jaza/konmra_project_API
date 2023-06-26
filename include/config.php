<?php
$hostname = "localhost";
$username = "root";
$password = null;
$database = "konmra_project";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    $errorMessage = "Connection failed: " . mysqli_connect_error();
    error_log($errorMessage);
    exit("Oops, something went wrong");
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

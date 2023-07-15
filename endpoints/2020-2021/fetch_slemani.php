<?php
include("/Applications/XAMPP/xamppfiles/htdocs/Konmra_project/include/config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = getDBConnection();

// Set the character set and collation
mysqli_set_charset($conn, 'utf8mb4');
mysqli_query($conn, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");

// Define pagination parameters
$page = $_GET['page'] ?? 1; // Current page number
$pageSize = $_GET['pageSize'] ?? 300; // Number of items per page

// Calculate the offset
$offset = ($page - 1) * $pageSize;

// Query to fetch department names with pagination
$queryDepartment = "SELECT `ناوی بەش` FROM `slemani` LIMIT $offset, $pageSize";
$resultDepartment = mysqli_query($conn, $queryDepartment);

if (!$resultDepartment) {
    die("Query failed: " . mysqli_error($conn));
}

$dataDepartment = array();
while ($row = mysqli_fetch_array($resultDepartment)) {
    $dataDepartment[] = $row['ناوی بەش'];
}

mysqli_free_result($resultDepartment);

// Query to fetch Parezga with pagination
$queryParezga = "SELECT `پارێزگا` FROM `slemani` LIMIT $offset, $pageSize";
$resultParezga = mysqli_query($conn, $queryParezga);

if (!$resultParezga) {
    die("Query failed: " . mysqli_error($conn));
}

$dataParezga = array();
while ($row = mysqli_fetch_array($resultParezga)) {
    $dataParezga[] = $row['پارێزگا'];
}

mysqli_free_result($resultParezga);

// Query to fetch Gshty with pagination
$queryGshty = "SELECT `گشتی` FROM `slemani` LIMIT $offset, $pageSize";
$resultGshty = mysqli_query($conn, $queryGshty);

if (!$resultGshty) {
    die("Query failed: " . mysqli_error($conn));
}

$dataGshty = array();
while ($row = mysqli_fetch_array($resultGshty)) {
    $dataGshty[] = $row['گشتی'];
}

mysqli_free_result($resultGshty);

mysqli_close($conn);

// Combine the fetched data into a single array
$data = array(
    'departmentName' => $dataDepartment,
    'parezga' => $dataParezga,
    'gshty' => $dataGshty
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);




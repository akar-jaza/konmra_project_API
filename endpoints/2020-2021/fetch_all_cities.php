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
$pageSize = $_GET['pageSize'] ?? 20; // Number of items per page

// Calculate the offset
$offset = ($page - 1) * $pageSize;

$searchQuery = $_GET['searchQuery'] ?? '';

// Query to fetch data for all cities
$query = "SELECT `ناوی بەش`, `پارێزگا`, `گشتی` FROM `slemani` 
          UNION ALL
          SELECT `ناوی بەش`, `پارێزگا`, `گشتی` FROM `hawler`
          UNION ALL
          SELECT `ناوی بەش`, `پارێزگا`, `گشتی` FROM `duhok`
          LIMIT $offset, $pageSize";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$data = array(
    'departmentName' => array(),
    'parezga' => array(),
    'gshty' => array(),
);

while ($row = mysqli_fetch_array($result)) {
    $data['departmentName'][] = $row['ناوی بەش'];
    $data['parezga'][] = $row['پارێزگا'];
    $data['gshty'][] = $row['گشتی'];
}

mysqli_free_result($result);
mysqli_close($conn);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
<?php
include("/Applications/XAMPP/xamppfiles/htdocs/Konmra_project/include/config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = getDBConnection();

// Set the character set and collation
mysqli_set_charset($conn, 'utf8mb4');
mysqli_query($conn, "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");

// Custom normalization function to replace non-standard characters
function normalizeKurdishText($text) {
    $replacements = array(
        // Add more mappings as needed
        'ﭘ' => 'پ',
        'ﺰ' => 'ز',
        'ﯾ' => 'ی',
        'ﮑ' => 'ک',
        'ﺸ' => 'ش',
        'ﻪ' => 'ە',
        'ی' => 'ی',
        'ﯽ' => 'ی',
        'ﻜ' => 'ک',
        'ﻰ' => 'ی',
        'ﺎ' => 'ا',
        'ﺮ' => 'ر',
        'ﻣ' => 'م',
        'ﯿ' => 'ی',
        'ﺪ' => 'د',
        'ﮏ' => 'ک',
        'ﺗ' => 'ت',
        'ﻧ' => 'ن',
        'ﻚ' => 'ک',
        'ﻛ' => 'ک',
        'ﻤ' => 'م',
        'ﻓ' => 'ف',
        'ﮐ' => 'ک',
        'ﺳ' => 'س',



        // Include other non-standard characters and their standard counterparts
    );

    return strtr($text, $replacements);
}

// Query to fetch data for all cities
$query = "SELECT `ناوی بەش`, `پارێزگا`, `گشتی` FROM `slemani` 
          UNION ALL
          SELECT `ناوی بەش`, `پارێزگا`, `گشتی` FROM `hawler`
          UNION ALL
          SELECT `ناوی بەش`, `پارێزگا`, `گشتی` FROM `duhok`
          ORDER BY `گشتی` DESC";

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
    // Skip the row if it contains "ناوی بەش"
    if ($row['ناوی بەش'] !== "ناوی بەش") {
        // Normalize the Kurdish text before adding it to the data array
        $departmentName = normalizeKurdishText($row['ناوی بەش']);
        $data['departmentName'][] = $departmentName;
        $data['parezga'][] = $row['پارێزگا'];
        $data['gshty'][] = $row['گشتی'];
    }
}

mysqli_free_result($result);
mysqli_close($conn);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);


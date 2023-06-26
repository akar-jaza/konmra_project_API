<?php
include("/Applications/XAMPP/xamppfiles/htdocs/Konmra_project/include/config.php");

$conn = getDBConnection();

$query = "SELECT `گشتی` FROM `hawler`
          UNION ALL
          SELECT `گشتی` FROM `slemani`
          UNION ALL
          SELECT `گشتی` FROM `duhok`";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$data = array();

while ($row = mysqli_fetch_array($result)) {
    $data[] = $row['گشتی'];
}

mysqli_free_result($result);
mysqli_close($conn);

// Sort the grades in ascending order
rsort($data);

// Remove the first element (title) from the array
array_shift($data);

header("Content-type: application/json");
echo json_encode(array_values($data));

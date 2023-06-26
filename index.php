<?php
include('include/config.php');

$conn = getDBConnection();

$descQuery = "SELECT `پارێزگا` FROM `hawler` ORDER BY `پارێزگا` DESC ";
$result = mysqli_query($conn, $descQuery);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$data = array();
$firstRow = true;
while ($row = mysqli_fetch_array($result)) {
    if ($firstRow) {
        $firstRow = false;
        continue;
    }
    $data[] = $row['پارێزگا'];
}

mysqli_free_result($result);
mysqli_close($conn);

header("Content-type: application/json");
echo json_encode($data);

<?php
include("/Applications/XAMPP/xamppfiles/htdocs/Konmra_project/include/config.php");

$conn = getDBConnection();

$query = "SELECT `پارێزگا` FROM `hawler` 
          UNION ALL
          SELECT `پارێزگا` FROM `slemani`
          UNION ALL
          SELECT `پارێزگا` FROM `duhok`";

$result = mysqli_query($conn, $query);

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

rsort($data);

// Remove the first element (title) from the array
array_shift($data);

header("Content-type: application/json");
echo json_encode($data);

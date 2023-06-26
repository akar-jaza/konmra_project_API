<?php
include("/Applications/XAMPP/xamppfiles/htdocs/Konmra_project/include/config.php");

$conn = getDBConnection();

$query = "(SELECT `ناوی بەش` FROM `hawler` ORDER BY `ناوی بەش`)
          UNION ALL
          (SELECT `ناوی بەش` FROM `slemani` ORDER BY `ناوی بەش`)
          UNION ALL
          (SELECT `ناوی بەش` FROM `duhok` ORDER BY `ناوی بەش`)";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$data = array();
while ($row = mysqli_fetch_array($result)) {
    $data[] = $row['ناوی بەش'];
}

mysqli_free_result($result);
mysqli_close($conn);

header("Content-type: application/json");
echo json_encode($data);

<?php
include("/Applications/XAMPP/xamppfiles/htdocs/Konmra_project/include/config.php");

$conn = getDBConnection();

$query = "(SELECT `پارێزگا` FROM `hawler` ORDER BY `پارێزگا`)
          UNION ALL
          (SELECT `پارێزگا` FROM `slemani` ORDER BY `پارێزگا`)
          UNION ALL
          (SELECT `پارێزگا` FROM `duhok` ORDER BY `پارێزگا`)";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$data = array();
while ($row = mysqli_fetch_array($result)) {
    $data[] = $row['پارێزگا'];
}

mysqli_free_result($result);
mysqli_close($conn);

header("Content-type: application/json");
echo json_encode($data);

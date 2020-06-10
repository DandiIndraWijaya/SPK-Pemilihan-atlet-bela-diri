<?php

$db = new SQLite3('database.db');
$sql = "SELECT * FROM top_kriteria";
$result = $db->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
    <script src="assets/bootsrap/bootsrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <?php
                while($row = $result->fetchArray(SQLITE3_ASSOC)){
                    echo $row['kriteria1'] . '<br>';
                }
            ?>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            kolom 2
        </div>
        </div>
    </div>
</body>
</html>
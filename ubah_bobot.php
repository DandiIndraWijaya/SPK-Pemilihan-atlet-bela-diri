<?php
include 'koneksi_database.php';

$db = new MyDB();
$sql = "SELECT * FROM tab_kriteria";
$tampil = $db->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK TOPSIS</title>
    <!--bootstrap-->
    <link href="tampilan/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-default navbar-custom">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">SPK Metode Topsis</a>
        </div>

        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="index.php">Data</a>
            </li>
            <li>
              <a href="hasil.php">Hasil Topsis</a>
            </li>
            <li>
              <a href="hasil_detail.php">Hasil Topsis Detail</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container">
        <div>
            <div class="cardcss" style="width: 60%;">
            <center>
                <h2>Ubah Bobot Kriteria</h2>
                <hr>
            <form action="ubah.php" method="post">
                <?php
                    while($row = $tampil->fetchArray(SQLITE3_ASSOC)){
                ?>
                    <?= $row['nama_kriteria'] . " : "; ?>
                    <input class="input-fields" style="width: 35px;" type="text" value="<?= $row['bobot'] ?>" name="<?= 'kriteria' . $row['id_kriteria']; ?>">%<br>
                <?php
                    }
                ?>
                <input class="input" type="submit" value="Simpan">
            </form>
            </center>
            </div>
        </div>
    </div>
</body>
</html>
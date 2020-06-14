<?php
//koneksi
include 'koneksi_database.php';

$db = new MyDB();
$sql = "SELECT b.nama_alternatif,c.nama_kriteria,a.nilai,c.bobot
FROM
  tab_topsis a
  JOIN
    tab_alternatif b USING(id_alternatif)
  JOIN
    tab_kriteria c USING(id_kriteria)";
$tampil = $db->query($sql);
if ($tampil) {
    while($row=$tampil->fetchArray(SQLITE3_ASSOC)){
      if(!isset($data[$row['nama_alternatif']])){
        $data[$row['nama_alternatif']]=array();
      }
      if(!isset($data[$row['nama_alternatif']][$row['nama_kriteria']])){
        $data[$row['nama_alternatif']][$row['nama_kriteria']]=array();
      }
      if(!isset($nilai_kuadrat[$row['nama_kriteria']])){
        $nilai_kuadrat[$row['nama_kriteria']]=0;
      }
      $bobot[$row['nama_kriteria']]=$row['bobot']/100;
      $data[$row['nama_alternatif']][$row['nama_kriteria']]=$row['nilai'];
      $nilai_kuadrat[$row['nama_kriteria']]+=pow($row['nilai'],2);
      $kriterias[]=$row['nama_kriteria'];
    }
if(!empty($kriterias)){
    $kriteria     =array_unique($kriterias);
    $jml_kriteria =count($kriteria);
}

  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SPK TOPSIS</title>
    <!--bootstrap-->
    <link href="tampilan/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

  </head>
  <body>

    <!--menu-->
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

    <!--tabel-tabel-->
    <center><h2>Metode Topsis Pemilihan Kontingen Olahraga Bela Diri</h2></center>
        <hr>
        <div class="row">
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <div class="cardcss">
                    <br>
                    <center><h4>Input Data</h4></center>
                    <form action="input_data.php" method="post">
                        <div class="input-fields">
                            <label for="" class="label">Tulis Nama Atlet</label>
                            <input type="text" name="nama" class="input" required>
                        </div>
                        <div class="input-fields">
                            <label for="" class="label">Kecepatan Pukulan (input angka)</label>
                            <input type="text" name="kecpukul" class="input" required>
                        </div>
                        <div class="input-fields">
                            <label for="" class="label">Kakuatan Pukulan (input angka)</label>
                            <input type="text" name="kekpukul" class="input" required>
                        </div>
                        <div class="input-fields">
                            <label for="" class="label">Kecepatan Tendangan (input angka)</label>
                            <input type="text" name="kectendang" class="input" required>
                        </div>
                        <div class="input-fields">
                            <label for="" class="label">Kekuatan Tendangan (input angka)</label>
                            <input type="text" name="kektendang" class="input" required>
                        </div>
                        <div class="input-fields">
                            <label for="" class="label">Tes Psikologi (input angka)</label>
                            <input type="text" name="psikolog" class="input" required>
                        </div>
                        <div class="input-fields">
                            <label for="" class="label">Tes Daya Tahan (input angka)</label>
                            <input type="text" name="daya" class="input" placeholder="contoh : 15.30 (brarti lima belas menit tiga puluh detik)" required>
                        </div> 
                        <div class="input-fields">
                            <label for="" class="label">Tes Kelincahan (input angka)</label>
                            <input type="text" name="kelincahan" class="input"  required>
                        </div> 
                        <input class="input" type="submit" value="Simpan">
                    </form>
                </div>
            </div>
            <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                <div class="cardcss">
                <br>
                    <center><h4>Keterangan</h4></center>
                    <div class="row">
                        <div class="col-6  col-sm-6 col-md-6 col-lg-6">
                            <div class="cardcss">
                            <center><h3>Daya Tahan</h3></center>
                            <hr>
                            <p style="margin: 10px; text-align: justify;">
                                 Daya Tahan, adalah kemampuan seseorang untuk melakukan tugasnya tanpa kelelahan yang berlebihan. 
                                 <br>
                                 <strong>Biasanya tes ini dilakukan dengan cara berlari dengan jarak 2,4 km. Jadi, Semakin singkat waktu yang diraih maka semakin baik. </strong> 
                            </p>
                            </div>
                           
                        </div>
                        <div class="col-6  col-sm-6 col-md-6 col-lg-6">
                            <div class="cardcss">
                            <center><h3>Bobot</h3></center>
                            <hr>
                            <p>
                             <strong>Jika di jumlahkan nilai bobot harus 100%.</strong> 
                            </p>
                            <?php
                                $db = new MyDB();
                                $sql = "SELECT * FROM tab_kriteria";
                                $tampil = $db->query($sql);
                                $sql2 = "SELECT sum(bobot) as jumlah FROM tab_kriteria";
                                $rows = $db->query($sql2);
                                $row = $rows->fetchArray();
                                $jumlah = $row['jumlah'];
                            ?>
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <td>Kriteria</td>
                                      <td>Bobot</td>
                                    </tr>
                                    
                                  </thead>
                                  <tbody>
                                    
                              <?php
                               while($row=$tampil->fetchArray(SQLITE3_ASSOC)){
                              ?>
                                    <tr>
                                      <td><?=  $row['nama_kriteria'] ?></td>
                                      <td><?=  $row['bobot'] . "%" ?></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                            <tr>
                                <td><strong>Jumlah</strong></td>
                                <td><strong><?=  $jumlah . "%" ?></strong></td>
                            </tr>
                                  </tbody>
                                </table>
                                <a href="ubah_bobot.php" ><button class="input">Ubah</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">

        <?php
        if(!empty($kriterias)){
        ?>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th rowspan='3'>No</th>
                    <th rowspan='3'>Alternatif</th>
                    <th rowspan='3'>Nama</th>
                    <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                    <th rowspan='3'>Aksi</th>
                  </tr>
                  <tr>
                    <?php
                    foreach($kriteria as $k)
                      echo "<th>$k</th>\n";
                    ?>
                  </tr>
                  <tr>
                    <?php
                    for($n=1;$n<=$jml_kriteria;$n++)
                      echo "<th>K$n</th>";
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i=0;
                  foreach($data as $nama=>$krit){
                    echo "<tr>
                      <td>".(++$i)."</td>
                      <th>A$i</th>
                      <td>$nama</td>";
                    foreach($kriteria as $k){
                      echo "<td align='center'>$krit[$k]</td>";
                    }
                ?>
                  <form action="delete_data.php" method="post">
                    <input type="text" name="nama" value="<?= $nama ?>" hidden>
                    <th><input type="submit" value="Hapus"></th>
                  </form>
                </tr>
                <?php
                  }
                  ?>
                </tbody>
              </table>
        <?php
        }
        ?>
        
        </div> <!--container-->


    <!--plugin-->
    <script src="tampilan/js/bootstrap.min.js"></script>

  </body>
</html>

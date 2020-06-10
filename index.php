<?php
//koneksi
include 'koneksi_database.php';
session_start();

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
    <center><h2>Metode Topsis Jurusan UNNES Terbaik</h2></center>
        <hr>
        <div class="row">
            <div class="col-4 col-sm-4 col-md-4 col-lg-4">
                <div class="cardcss">
                    <br>
                    <center><h4>Input Data</h4></center>
                    <form action="input_data.php" method="post">
                        <div class="input-fields">
                            <label for="" class="label">Tulis nama jurusan</label>
                            <input type="text" name="jurusan" class="input" required>
                        </div>
                        <div class="input-fields">
                            <label for="" class="label">Jumlah Wisudawan</label>
                            <select name="wisuda" class="input">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="input-fields">
                            <label for="" class="label">Prestasi</label>
                            <select name="prestasi" class="input">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div class="input-fields">
                            <label for="" class="label">Pelanggaran</label>
                            <select name="pelanggaran" class="input">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="input-fields">
                            <input type="submit" value="Simpan"> 
                        </div>   
                    </form>
                </div>
            </div>
            <div class="col-8 col-sm-8 col-md-8 col-lg-8">
                <div class="cardcss">
                <br>
                    <center><h4>Keterangan</h4></center>
                    <div class="row">
                        <div class="col-4  col-sm-4 col-md-4 col-lg-4">
                            <div class="cardcss">
                            <center><h5>Wisudawan</h5></center>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Jumlah
                                        </th>
                                        <th>
                                            Nilai
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10 < </td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>10 - 20</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>20 - 30</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>30 ></td>
                                        <td>4</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                           
                        </div>
                        <div class="col-4  col-sm-4 col-md-4 col-lg-4">
                            <div class="cardcss">
                            <center><h5>Prestasi</h5></center>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Jumlah
                                        </th>
                                        <th>
                                            Nilai
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10 < </td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>10 - 20</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>20 - 30</td>
                                        <td>3</td>
                                    </tr>
                                    <tr>
                                        <td>30 ></td>
                                        <td>4</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        
                        </div>
                        <div class="col-4  col-sm-4 col-md-4 col-lg-4">
                            <div class="cardcss">
                            <center><h5>Pelanggaran</h5></center>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            Jumlah
                                        </th>
                                        <th>
                                            Nilai
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>20 > </td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td>10 -20</td>
                                        <td>2</td>
                                    </tr>
                                    <tr>
                                        <td>10 <</td>
                                        <td>3</td>
                                    </tr>
                                </tbody>
                            </table>
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
                    <th><a href="http://localhost/topsis/delete_data.php?nama=<?= $nama ?>"><button>Hapus</button></a></th>
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

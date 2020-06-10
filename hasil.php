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


$data      =array();
$kriterias =array();
$bobot     =array();
$nilai_kuadrat =array();


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
}

$kriteria     =array_unique($kriterias);
$jml_kriteria =count($kriteria);
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
    <div class="container-fluid"> <!--container-->
                  <?php
                  $i=0;
                  foreach($data as $nama=>$krit){
                   
                    foreach($kriteria as $k){
                    }
                    
                  }
                  ?>


                  <?php
                  $i=0;
                  foreach($data as $nama=>$krit){
                    foreach($kriteria as $k){
                      round(($krit[$k]/sqrt($nilai_kuadrat[$k])),4);
                    }
               
                  }
                  ?>


  
                  <?php
                  $i=0;
                  $y=array();
                  foreach($data as $nama=>$krit){
                  ++$i;
                    foreach($kriteria as $k){
                      $y[$k][$i-1]=round(($krit[$k]/sqrt($nilai_kuadrat[$k])),4)*$bobot[$k];
                      $y[$k][$i-1];
                    }
                    
                  }
                  ?>



                    <?php
                    //Solusi ideal positif A
                    $yplus=array();
                    foreach($kriteria as $k){
                      $yplus[$k]=([$k]?max($y[$k]):min($y[$k]));
                      $yplus[$k];
                    }
                    ?>


                    <?php
                    //Solusi ideal negatif A
                    $ymin=array();
                    foreach($kriteria as $k){
                      $ymin[$k]=[$k]?min($y[$k]):max($y[$k]);
                      $ymin[$k];
                    }

                    ?>


                  <?php
                  //Jarak positif D
                  $i=0;
                  $dplus=array();
                  foreach($data as $nama=>$krit){
                      ++$i;
                    foreach($kriteria as $k){
                      if(!isset($dplus[$i-1])) $dplus[$i-1]=0;
                      $dplus[$i-1]+=pow($yplus[$k]-$y[$k][$i-1],2);
                    }
                    round(sqrt($dplus[$i-1]),6);
                  }
                  ?>



                  <?php
                  //Jarak negatif D
                  $i=0;
                  $dmin=array();
                  foreach($data as $nama=>$krit){
                    ++$i;
                    foreach($kriteria as $k){
                      if(!isset($dmin[$i-1]))$dmin[$i-1]=0;
                      $dmin[$i-1]+=pow($ymin[$k]-$y[$k][$i-1],2);
                    }
                    round(sqrt($dmin[$i-1]),6);
                  }
                  ?>

      
                  <?php
                    $i=0;
                    $V=array();
                    foreach($data as $nama=>$krit){
                        $nama_alter[$i] = $nama; 
                      ++$i;
                      foreach($kriteria as $k){
                        $V[$i-1]=$dmin[$i-1]/($dmin[$i-1]+$dplus[$i-1]);
                      }
                      $V[$i-1];
                    }

                    $max = $V[0];
                    for($i = 1 ; $i < count($V) ; $i++){
                        if($max < $V[$i]){
                            $max = $V[$i];
                            $nama_max = $nama_alter[$i];
                        }
                    }
                  ?>
                  <div>
                      <center>
                          <h3>Hasilnya adalah alternatif : <?=   $nama_max?></h3>
                          <h3>dengan nilai preferensi : <?= $max ?></h3>
                      </center>
                  </div>
      


      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              Nilai Preferensi(V<sub>i</sub>)
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Alternatif</th>
                    <th>Nama</th>
                    <th>V<sub>i</sub></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i=0;
                  $V=array();
                  foreach($data as $nama=>$krit){
                    echo "<tr>
                      <td>".(++$i)."</td>
                      <th>A{$i}</th>
                      <td>{$nama}</td>";
                    foreach($kriteria as $k){
                      $V[$i-1]=$dmin[$i-1]/($dmin[$i-1]+$dplus[$i-1]);
                    }
                    echo "<td>{$V[$i-1]}</td></tr>\n";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div> <!--container-->


    <!--plugin-->
    <script src="tampilan/js/bootstrap.min.js"></script>

  </body>
</html>

<?php
include 'koneksi_database.php';

$kecpukul = $_POST['kriteria1'];
$kekpukul = $_POST['kriteria2'];
$kectendangan = $_POST['kriteria3'];
$kektendangan = $_POST['kriteria4'];
$psikologi = $_POST['kriteria5'];
$ketahanan = $_POST['kriteria6'];
$kelincahan = $_POST['kriteria7'];

$db = new MyDB();
$db->query("UPDATE tab_kriteria SET bobot = $kecpukul WHERE id_kriteria = 1");
$db->query("UPDATE tab_kriteria SET bobot = $kekpukul WHERE id_kriteria = 2");
$db->query("UPDATE tab_kriteria SET bobot = $kectendangan WHERE id_kriteria = 3");
$db->query("UPDATE tab_kriteria SET bobot = $kektendangan WHERE id_kriteria = 4");
$db->query("UPDATE tab_kriteria SET bobot = $psikologi WHERE id_kriteria = 5");
$db->query("UPDATE tab_kriteria SET bobot = $ketahanan WHERE id_kriteria = 6");
$update = $db->query("UPDATE tab_kriteria SET bobot = $kelincahan WHERE id_kriteria = 7");

if($update){
    header('Location: index.php');
}else{
    echo "Eror";
}
?>
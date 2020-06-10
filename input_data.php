<?php
include 'koneksi_database.php';

$jurusan = $_POST['jurusan'];
$wisuda = $_POST['wisuda'];
$prestasi = $_POST['prestasi'];
$pelanggaran = $_POST['pelanggaran'];

$db = new MyDB();
$db->query("INSERT INTO tab_alternatif ('nama_alternatif') VALUES('$jurusan')");
$id_alternatif = $db->query("SELECT id_alternatif FROM tab_alternatif WHERE nama_alternatif = '$jurusan'");

while($row=$id_alternatif->fetchArray(SQLITE3_ASSOC)){
    $id = $row['id_alternatif'];
}

$sample = $db->query("INSERT INTO tab_topsis (id_alternatif, id_kriteria, nilai) VALUES ('$id', '1', '$wisuda'), ('$id', '2', '$prestasi'), ('$id', '3', '$pelanggaran')");

if($sample){
    header('Location: index.php');
}else{
    echo "Eror";
}



?>
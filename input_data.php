<?php
include 'koneksi_database.php';

$nama = $_POST['nama'];
$kecpukul = $_POST['kecpukul'];
$kekpukul = $_POST['kekpukul'];
$kectendangan = $_POST['kectendang'];
$kektendangan = $_POST['kektendang'];
$psikologi = $_POST['psikolog'];
$ketahanan = $_POST['daya'];
$kelincahan = $_POST['kelincahan'];

$db = new MyDB();
$db->query("INSERT INTO tab_alternatif ('nama_alternatif') VALUES('$nama')");
$id_alternatif = $db->query("SELECT id_alternatif FROM tab_alternatif WHERE nama_alternatif = '$nama'");

while($row=$id_alternatif->fetchArray(SQLITE3_ASSOC)){
    $id = $row['id_alternatif'];
}

$sample = $db->query("INSERT INTO tab_topsis (id_alternatif, id_kriteria, nilai) VALUES ('$id', '1', '$kecpukul'), ('$id', '2', '$kekpukul'), ('$id', '3', '$kectendangan'), ('$id', '4', '$kektendangan'), ('$id', '5', '$psikologi'), ('$id', '6', '$ketahanan'), ('$id', '7', '$kelincahan')");

if($sample){
    header('Location: index.php');
}else{
    echo "Eror";
}



?>
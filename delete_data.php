<?php
include 'koneksi_database.php';

$nama = $_POST['nama'];

$db = new MyDB();
$id_alternatif = $db->query("SELECT id_alternatif FROM tab_alternatif WHERE nama_alternatif = '$nama'");

while($row=$id_alternatif->fetchArray(SQLITE3_ASSOC)){
    $id = $row['id_alternatif'];
}

$delete_tab_topsis = $db->query("DELETE FROM tab_topsis WHERE id_alternatif = '$id'");
$delete_alternatif = $db->query("DELETE FROM tab_alternatif WHERE nama_alternatif = '$nama'");


header('Location: index.php');

?>
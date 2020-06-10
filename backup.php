<?php
$db = new SQLite3('database.db');


//PENGAMBILAN NILAI:

//Pengambilan nilai kriteria
$sql = "SELECT * FROM top_kriteria";
$result = $db->query($sql);
$kriteria=array();
$bobot=array();
//-- melakukan iterasi pengisian array untuk tiap record data yang didapat
foreach ($result as $row) {
    $kriteria[$row['id_kriteria']]=array($row['kriteria'],$row['type']);
    $bobot[$row['id_kriteria']]=$row['bobot']/100;
}



//Pengambilan nilai alternatif
$sql = 'SELECT * FROM top_alternatif';
$result = $db->query($sql);
//-- menyiapkan variable penampung berupa array
$alternatif=array();
//-- melakukan iterasi pengisian array untuk tiap record data yang didapat
foreach ($result as $row) {
    $alternatif[$row['id_alternatif']]=$row['alternatif'];
}


//Pengambilan nilai penilaian
$sql = 'SELECT * FROM top_sample ORDER BY id_alternatif,id_kriteria';
$result = $db->query($sql);
//-- menyiapkan variable penampung berupa array
$sample=array();
//-- melakukan iterasi pengisian array untuk tiap record data yang didapat
foreach ($result as $row) {
    //-- jika array $sample[$row['id_alternatif']] belum ada maka buat baru
    //-- $row['id_alternatif'] adalah id kandidat/alternatif
    if (!isset($sample[$row['id_alternatif']])) {
        $sample[$row['id_alternatif']] = array();
    }
    $sample[$row['id_alternatif']][$row['id_kriteria']] = $row['nilai'];
}



//PERHITUNGAN


//Membuat matrik keputusan (x)
//-- menjadikan data $sample sebagai matrik keputusan $X
$X=$sample;
//-- melakukan iterasi utk setiap alternatif
foreach ($X as $id_alternatif=>$a_kriteria) {
    echo "<tr>";
    //-- melakukan iterasi utk setiap kriteria
    foreach($a_kriteria as $id_kriteria=>$nilai){
        echo "<td>{$nilai}</td>";
    }
    echo "</tr>";
}




//Membuat matrik normalisasi (R)
//-- inisialisasi array pembagi
$pembagi=array();
//-- melakukan iterasi utk setiap kriteria
foreach($kriteria as $id_kriteria=>$value){
    $pembagi[$id_kriteria]=0;
    //-- melakukan iterasi utk setiap alternatif
    foreach($alternatif as $id_alternatif=>$a_value){
        $pembagi[$id_kriteria]=pow($X[$id_alternatif][$id_kriteria],2);
    }
}
//-- inisialisasi matrik Normalisasi R
$R=array();
//-- melakukan iterasi utk setiap alternatif
foreach($X as $id_alternatif=>$a_kriteria) {
    $R[$id_alternatif]=array();
    //-- melakukan iterasi utk setiap kriteria
    foreach($a_kriteria as $id_kriteria=>$nilai){
        $R[$id_alternatif][$id_kriteria]=$nilai/sqrt($pembagi[$id_kriteria]);
    }
} 


//Membuat matrik normalisasi terbobot (Y)
//-- inisialisasi matrik Normalisasi Terbobot Y
$Y=array();
//-- melakukan iterasi utk setiap alternatif
foreach($R as $id_alternatif=>$a_kriteria) {
    $Y[$id_alternatif]=array();
    //-- melakukan iterasi utk setiap kriteria
    foreach($a_kriteria as $id_kriteria=>$nilai){
        $Y[$id_alternatif][$id_kriteria] = $nilai * $bobot[$id_kriteria];
    }
}   




//Perhitungan solusi ideal (A)
//-- inisialisasi Solusi Ideal A Positif dan Negatif 
$A_max=$A_min=array();
//-- melakukan iterasi utk setiap kriteria
foreach($kriteria as $id_kriteria=>$a_kriteria) {
    $A_max[$id_kriteria]=0;
    $A_min[$id_kriteria]=100;
    //-- melakukan iterasi utk setiap alternatif
    foreach($alternatif as $id_alternatif=>$nilai){
        if($A_max[$id_kriteria]<$Y[$id_alternatif][$id_kriteria]){
            $A_max[$id_kriteria] = $Y[$id_alternatif][$id_kriteria];
        }
        if($A_min[$id_kriteria]>$Y[$id_alternatif][$id_kriteria]){
            $A_min[$id_kriteria] = $Y[$id_alternatif][$id_kriteria];
        }
    }
}   



//Perhitungan Jarak Solusi Ideal (D)
//-- inisialisasi Jarak Solusi Ideal Positif/Negatif
$D_plus=$D_min=array();
//-- melakukan iterasi utk setiap alternatif
foreach($Y as $id_alternatif=>$n_a){
    $D_plus[$id_alternatif]=0;
    $D_min[$id_alternatif]=0;
    //-- melakukan iterasi utk setiap kriteria
    foreach($n_a as $id_kriteria=>$y){
        $D_plus[$id_alternatif]+=pow($y-$A_max[$id_kriteria],2);
        $D_min[$id_alternatif]+=pow($y-$A_min[$id_kriteria],2);
    }
    $D_plus[$id_alternatif]=sqrt($D_plus[$id_alternatif]);
    $D_min[$id_alternatif]=sqrt($D_min[$id_alternatif]);
}


//Perhitungan Nilai Preferensi (V)
//-- inisialisasi variabel array V 
$V=array();
//-- melakukan iterasi utk setiap alternatif
foreach($D_min as $id_alternatif=>$d_min){
    //-- perhitungan nilai Preferensi V dari nilai jarak solusi ideal D
    $V[$id_alternatif] = $d_min/($d_min + $D_plus[$id_alternatif]);
}


//Perangkingan
//--mengurutkan data secara descending dengan tetap mempertahankan key/index array-nya
arsort($V);
//-- mendapatkan key/index item array yang pertama
$index=key($V);
//-- menampilkan hasil akhir:
echo "Hasilnya adalah alternatif <b>{$alternatif[$index][0]}</b> ";
echo "dengan nilai preferensi <b>{$V[$index]}</b> yang terpilih";
?>
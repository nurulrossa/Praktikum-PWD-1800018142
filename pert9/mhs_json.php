<?php
// menghubungkan ke database
include "koneksi.php";
// menampilkan data tabel mahasiswa berdasarkan urutan nim
$sql="select * from mahasiswa order by nim";
$tampil = mysqli_query($con,$sql);
// jika data mahasiswa ditemukan > 0
if (mysqli_num_rows($tampil) > 0) {
    $no=1;
    // membuat variabel array response untuk menampung data mahasiswa
    $response = array();
    $response["data"] = array();
    //  perulangan untuk menampilkan data
    while ($r = mysqli_fetch_array($tampil)) {
        $h['nim'] = $r['nim'];
        $h['nama'] = $r['nama'];
        $h['jkel'] = $r['jkel'];
        $h['alamat'] = $r['alamat'];
        $h['tgllhr'] = $r['tgllhr'];

        // array_Push() diperlakukanarraysebagai tumpukan, 
        // dan mendorong variabel yang diteruskan ke akhir array. 
        // Panjangnyaarray bertambah dengan jumlah variabel yang didorong.
        array_push($response["data"], $h);
    }
    // json_encode digunakan untuk mengubah tipe data yang didukung PHP
    // menjadi string berformat JSON untuk dikembalikan 
    // sebagai hasil dari operasi encode JSON .
    echo json_encode($response);
}else {
    $response["message"]="tidak ada data";
    echo json_encode($response);
}
?>
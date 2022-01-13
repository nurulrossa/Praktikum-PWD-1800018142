<?php
// menghubungkan database
require_once "koneksi.php";
// menampilkan data mahasiswa
$sql = "select * from mahasiswa";
$query = mysqli_query($con,$sql);
// menampung data mahasiswa ke dalam array data
while ($row = mysqli_fetch_assoc($query)) {
 $data[] = $row;
}
// menampilkan data dalam format json
header('content-type: application/json');
echo json_encode($data);
mysqli_close($con);
?>
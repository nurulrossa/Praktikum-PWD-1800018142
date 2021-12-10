<?php include 'koneksi.php'; ?>
<h3>Form Pencarian Dengan PHP MAHASISWA</h3>
<!-- membuat form pencarian dengan metode get -->
<form action="" method="get">
    <label>Cari :</label>
    <input type="text" name="cari">
    <input type="submit" value="Cari">
</form>

<?php 
// kondisi jika kolom text pencarian tidak kosong
if(isset($_GET['cari'])){ 
    $cari = $_GET['cari']; // menampung text yang diinputkan 
    echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
<table border="1">
    <tr>
        <th>No</th>
        <th>Nama</th>
    </tr>
    <?php 
    // kondisi jika kolom text pencarian tidak kosong
    if(isset($_GET['cari'])){
        $cari = $_GET['cari']; // menampung text yang diinputkan 
        $sql="select * from mahasiswa where nama like'%".$cari."%'"; // menampilkan data yang terdapat teks yang dimasukkan
        $tampil = mysqli_query($con,$sql); // menjalankan instruksi sql
    }else{
        $sql="select * from mahasiswa"; // menampilkan seluruh data jika kolom teks pencarian kosong
        $tampil = mysqli_query($con,$sql); // menjalankan instruksi sql
    }
    
    $no = 1;
    while($r = mysqli_fetch_array($tampil)){  // perulangan menampilkan data khs dalam array
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $r['nama']; ?></td>
    </tr>
    <?php } ?>
</table>
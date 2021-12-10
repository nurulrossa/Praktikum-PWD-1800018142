<?php include 'koneksi.php'; ?>

<h3>Form Pencarian DATA KHS Dengan PHP </h3>
<!-- Membuat form cari dengan method get -->
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
        <th>NIM</th>
        <th>Nama</th>
        <th>Kode MK</th>
        <th>Nama MK</th>
        <th>Nilai</th>
    </tr>
    <?php 
    // kondisi jika kolom text pencarian tidak kosong
    if(isset($_GET['cari'])){
        $cari = $_GET['cari'];  // menampung text yang diinputkan 
        $sql="select * from mahasiswa where nim = '".$cari."'"; // menampilkan data khs sesuai dengan nim yang dimasukkan
        $tampil = mysqli_query($con,$sql); // menjalankan instruksi sql
    }else{
        $sql="select * from mahasiswa"; // menampilkan seluruh data jika kolom teks pencarian kosong
        $tampil = mysqli_query($con,$sql); // menjalankan instruksi sql
    }
    $no = 1;
    while($r = mysqli_fetch_array($tampil)){ // perulangan menampilkan data khs dalam array
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $r['nim']; ?></td>
        <td><?php echo $r['nama']; ?></td>
        <?php 
            $mk = "select mk_kode from matakuliah inner join khs on khs.kodeMk = matakuliah.mk_kode where nim = '".$r['nim']."'";
            $tampilmk = mysqli_query($con,$mk); // menjalankan instruksi sql
        ?>
        <td>
        <?php while($m = mysqli_fetch_array($tampilmk)){
            echo $m['mk_kode']."<br>";
        } ?>
        </td>
        <?php 
            $namamk = "select mk_nama from matakuliah inner join khs on khs.kodeMk = matakuliah.mk_kode where nim = '".$r['nim']."'";
            $tampilnama = mysqli_query($con,$namamk); // menjalankan instruksi sql
        ?>
        <td>
        <?php while($nm = mysqli_fetch_array($tampilnama)){
            echo $nm['mk_nama']."<br>";
        } ?>
        </td>
        <?php 
            $nilai = "select nilai from khs where nim = '".$r['nim']."'";
            $tampiln = mysqli_query($con,$nilai); // menjalankan instruksi sql
        ?>
        <td>
        <?php while($n= mysqli_fetch_array($tampiln)){
            echo $n['nilai']."<br>";
        } ?>
        </td>
    </tr>
<?php } ?>
</table>
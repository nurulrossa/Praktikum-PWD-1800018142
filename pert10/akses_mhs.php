<html>
<?php
$url = "http://localhost/Praktikum-PWD-1800018142/pert10/getdatamhs.php";
$client = curl_init($url);
curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($client);
$result = json_decode($response);
?>
<!-- membuat form pencarian -->
<form method="POST" action="akses_mhs.php" style="text-align: left;">
	<label>Kata Pencarian : </label>
	<input type="text" name="cari_nim" value="<?php if(isset($_POST['submit'])) { echo $_POST['cari_nim']; } ?>"  required/>
	<button type="submit" name="submit" value="">Cari</button>
</form>
<?php

 if(isset($_POST['submit'])) {
    $cari_nim = $_POST['cari_nim'];
    foreach ($result as $r) {
        if($r->nim == $cari_nim){
            echo "<p>";
            echo "NIM : " . $r->nim . "<br />";
            echo "Nama : " . $r->nama . "<br />";
            echo "jenis kel : " . $r->jkel . "<br />";
            echo "Alamat : " . $r->alamat . "<br />";
            echo "Tgl Lahir : " . $r->tgllhr . "<br />";
            echo "</p>";
            $ketemu = 'ya';
        }
    }
    
    if(empty($ketemu)){
        echo "Data tidak ditemukan";
    }
}else{
    foreach ($result as $r) {
        echo "<p>";
        echo "NIM : " . $r->nim . "<br />";
        echo "Nama : " . $r->nama . "<br />";
        echo "jenis kel : " . $r->jkel . "<br />";
        echo "Alamat : " . $r->alamat . "<br />";
        echo "Tgl Lahir : " . $r->tgllhr . "<br />";
        echo "</p>";
    }
}
?>
</html>
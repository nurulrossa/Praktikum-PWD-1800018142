<?php
session_start(); //memulai session
include "koneksi.php"; //include database
$id_user = $_POST['id_user']; //menangkap username
$pass=md5($_POST['paswd']); //menangkap md5 password
$sql="SELECT * FROM users WHERE id_user='$id_user' AND password='$pass'"; //menampilkan data user berdasarkan username dan password yang diisi

if ($_POST["captcha_code"] == $_SESSION["captcha_code"]) { //mengecek apakah captcha_code yang diisi sesuai
    
    $login=mysqli_query($con,$sql); //menghubungkan database
    $ketemu=mysqli_num_rows($login);  //menampung data
    $r= mysqli_fetch_array($login); //menampung ke dalam array

    if ($ketemu > 0){ //jika data ditemukan lebih dari 0
        $_SESSION['iduser'] = $r['id_user']; //membuat session iduser (username)
        $_SESSION['passuser'] = $r['password']; //membuat session password
        echo"USER BERHASIL LOGIN<br>";
        echo "id user =",$_SESSION['iduser'],"<br>";
        echo "password=",$_SESSION['passuser'],"<br>";
        echo "<a href=form_user.php><b>Tambah User</b></a></center><br><br>";
        echo "<a href=logout.php><b>LOGOUT</b></a></center>";
    }else{
        echo "<center>Login gagal! username & password tidak benar<br>";
        echo "<a href=form_login.php><b>ULANGI LAGI</b></a></center>";
    }

    mysqli_close($con); //menutup proses database

}else {
    echo "<center>Login gagal! Captcha tidak sesuai<br>";
    echo "<a href=form_login.php><b>ULANGI LAGI</b></a></center>"; 
}
?>
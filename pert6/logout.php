<?php
session_start(); //memulai session
session_destroy(); //mengakhiri session sekaligus menghapus file ID session
echo "Anda telah sukses keluar sistem <b>LOGOUT</b>";
echo "<br><a href=form_login.php><b>MASUK LAGI</b></a></center>";
?>
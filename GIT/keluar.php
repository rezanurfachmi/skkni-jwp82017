<?php
session_start();
include 'db.php';
if($_SESSION['idpengguna']==$_GET['key']){
	unset($_SESSION['idpengguna']);
	unset($_SESSION['idbiodata']);
	session_destroy();
	eksyen('','index.php');
}else{
	eksyen('Oops..Gagal keluar sistem Toklat. Silahkan ulangi kembali','?hal=order');
}
?>
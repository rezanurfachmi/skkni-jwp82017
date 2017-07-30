<?php
// Pembatasan Pemesanan
// Harus login terlebih dahulu
if(!isset($_SESSION['idpengguna'])){
	eksyen('Maaf, Anda harus login terlebih dahulu','?hal=masuk');
}

// Memeriksa keadaan produk
if(!isset($_GET['id'])){
	eksyen('','?hal=order');
}else{
	// cek keberadaan produk
	$id = $db->escapeString(trim($_GET['id']));
	$db->select('pesan','*',null,"idpesan='$id'");
	$j = $db->numRows();
	if($j<=0){
		eksyen('Maaf, data tidak tersedia','index.php');
	}else{
		$db->update('pesan',array('hapus'=>'1'),"idpesan='$id'") or eksyen('Error MySQL Pesan','?hal=order');
	}
	eksyen('','?hal=order');
}
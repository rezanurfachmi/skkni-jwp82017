<h1>Bukti Pembayaran</h1>
<?php
// Memeriksa keadaan produk
if(isset($_GET['id'])){
	// cek keberadaan produk
	$id = $db->escapeString(trim($_GET['id']));
	$db->select('konfirmasi','*',null,"idkonfirmasi='$id'");
	$j = $db->numRows();
	if($j<=0){
		eksyen('Maaf, data tidak tersedia','?hal=konfirmasi');
	}

	$d = $db->getResult();

	$idpesan = $d[0]['idpesan'];
	$ps = new Database;
	$ps->connect();
	$ps->select('pesan','*',null,"idpesan='$idpesan'");
	$dps = $ps->getResult();

}else{
	eksyen('','?hal=konfirmasi');
}
?>
<h3>Untuk tagihan sebesar Rp.<?=number_format($dps[0]['total']);?></h3>
<img src="../<?=$dps[0]['gambar'];?>" height="400"> <a href="?hal=konfirmasi" class="btn btn-primary btn-lg"><i class="fa fa-arrow-left"></i> Kembali</a>
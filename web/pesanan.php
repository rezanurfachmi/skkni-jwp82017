<?php
// Pembatasan Pemesanan
// Harus login terlebih dahulu
if(!isset($_SESSION['idpengguna'])){
	eksyen('Maaf, Anda harus login terlebih dahulu','../?hal=masuk');
}
?>
<h1>Data Pesanan</h1>
<table class="table table-hover table-bordered" id="tbl">
	<thead>
		<tr>
			<th class="col-md-1 text-center">No</th>
			<th class="col-md-2 text-center">Tanggal</th>
			<th class="col-md-2">Pemesan</th>
			<th class="col-md-2">Produk</th>
			<th>Tujuan</th>
			<th class="col-md-1 text-center">Review</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	$db->select('pesan','*',null,null,"verifikasi asc");
	$d = $db->getResult();

	// inisiasi data alamat penerima
	$al = new Database;
	$al->connect();
	foreach($d as $d){
		// ambil data alamat penerima
		$idpesan = $d['idpesan'];
		$al->select('penerima','*',null,"idpesan='$idpesan'");
		$dal = $al->getResult();

		$idkab = $dal[0]['kab'];
		$idprov = $dal[0]['prov'];
	?>
		<tr>
			<td class="text-center"><?=$i++;?></td>
			<td><?=TanggalIndo($d['dtmcrt']);?> / <?=jam($d['dtmcrt']);?></td>
			<td><?=konvert('biodata','idbiodata',$d['idbiodata'],'nama');?></td>
			<td><?=konvert('produk','idproduk',$d['idproduk'],'nama');?></td>
			<td><?=konvert('kabupaten','id',$idkab,'name');?> - <?=konvert('provinsi','id',$idprov,'name');?></td>
			<td class="text-center"><?php if($d['verifikasi']=='1'){ echo tbl_lihat("?hal=verifikasi&id=".$d['idpesan']); }else{ echo tbl_ubah("?hal=verifikasi&id=".$d['idpesan']); } ?></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
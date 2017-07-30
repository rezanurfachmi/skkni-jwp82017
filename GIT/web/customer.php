<?php if(!isset($_GET['hapus'])){ ?>
<h1>Data Customer</h1>
<table class="table table-hover table-bordered" id="tbl">
	<thead>
		<tr>
			<th class="col-md-1 text-center">No</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th class="col-md-2 text-center">Username</th>
			<th class="col-md-2 text-center">#</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$db->select('biodata','*',null,"hapus='0'");
	$d = $db->getResult();
	$i = 1; // untuk nomor
	foreach($d as $d){ ?>
		<tr>
			<td class="text-center"><?=$i++;?></td>
			<td><?=$d['nama'];?></td>
			<td><?=konvert('kabupaten','id',$d['kab'],'name');?> - <?=konvert('provinsi','id',$d['prov'],'name');?></td>
			<td><?=konvert('pengguna','id',$d['idpengguna'],'username');?></td>
			<td class="text-center">
				<?=tbl_ubah("?hal=customer_ubah&id=".$d['idbiodata']);?>
				<?=tbl_hapus("?hal=customer&hapus=".$d['idbiodata']);?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php }else{
	echo "<h1>Hapus Data Customer</h1>Processing...";
	$hapus = $db->escapeString(trim($_GET['hapus']));

	// ambil idpengguna dahulu
	$idpengguna = konvert('biodata','idbiodata',$hapus,'idpengguna');

	// hapus tabel pengguna
	$db->update('pengguna',array('hapus'=>'1'),"id='$idpengguna'") or eksyen('Error MySQL Pengguna: Hubungi Administrator',"?hal=customer");

	// hapus tabel biodata
	$db->update('biodata',array('hapus'=>'1'),"idbiodata='$hapus'") or eksyen('Error MySQL Biodata: Hubungi Administrator',"?hal=customer");
	eksyen('','?hal=customer');	
}
?>
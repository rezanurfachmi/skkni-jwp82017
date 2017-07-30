<?php if(!isset($_GET['hapus'])){ ?>
<h1>Data Produk</h1>
<table class="table table-hover table-bordered" id="tbl">
	<thead>
		<tr>
			<th class="col-md-1 text-center">No</th>
			<th>Nama</th>
			<th>Kategori</th>
			<th class="col-md-1 text-center">Gambar</th>
			<th class="col-md-2 text-center">#</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$db->select('produk','*',null,"hapus='0'");
	$d = $db->getResult();
	$i = 1; // untuk nomor
	foreach($d as $d){ ?>
		<tr>
			<td class="text-center"><?=$i++;?></td>
			<td><?=$d['nama'];?></td>
			<td><?=konvert('kategori','idkategori',$d['idkategori'],'kategori');?></td>
			<td class="text-center"><a target="_blank" href="<?=$d['gambar'];?>" class="btn btn-success btn-xs"><i class="fa fa-search"></i> Lihat</a></td>
			<td class="text-center">
				<?=tbl_ubah("?hal=produk_ubah&id=".$d['idproduk']);?>
				<?=tbl_hapus("?hal=produk&hapus=".$d['idproduk']);?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php }else{
	echo "<h1>Hapus Data Produk</h1>Processing...";
	$hapus = $db->escapeString(trim($_GET['hapus']));

	// hapus tabel produk
	$db->update('produk',array('hapus'=>'1'),"idproduk='$hapus'") or eksyen('Error MySQL Produk: Hubungi Administrator',"?hal=produk");
	eksyen('','?hal=produk');
}
?>
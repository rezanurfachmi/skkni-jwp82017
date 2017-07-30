<?php
if(!isset($_GET['aksi'])){
	?>
<h1>Data Kategori</h1>
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th class="col-md-1 text-center">No</th>
			<th>Kategori</th>
			<th class="col-md-2 text-center">#</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$db->select('kategori');
	$d = $db->getResult();
 	$i = 1; // untuk penomoran
	foreach($d as $d){ ?>
		<tr>
			<td class="text-center"><?=$i++;?></td>
			<td><?=$d['kategori'];?></td>
			<td class="text-center">
				<?=tbl_ubah("?hal=kategori_ubah&id=".$d['idkategori']);?>
				<?=tbl_hapus("?hal=kategori_ubah&hapus=".$d['idkategori']);?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php	
}else{
?>
<h1>Tambah Data Kategori <small>- <a href="?hal=kategori">Kembali</a></small></h1>
<?php
if(isset($_POST['kategori'])){
	echo "Processing...";
	$kategori = $db->escapeString(trim($_POST['kategori']));
	$db->insert('kategori',array('idkategori'=>id(),'kategori'=>$kategori,'usrcrt'=>$_SESSION['idpengguna'],'dtmcrt'=>wkt())) or eksyen('Error mysql: hubungi administrator','?hal=kategori');
	eksyen('','?hal=kategori');
}
?>
<form action="" method="POST" class="form-horizontal" role="form">
	<div class="form-group">
		<label for="inputKategori" class="col-sm-2 control-label">Nama Kategori:</label>
		<div class="col-sm-4">
			<input type="text" name="kategori" id="inputKategori" class="form-control" value="" required="required" maxlength="20" placeholder="Nama Kategori" autofocus>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-10 col-sm-offset-2">
			<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
		</div>
	</div>
</form>
<?php
}
?>
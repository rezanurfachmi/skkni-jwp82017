<?php
if(!isset($_GET['aksi'])){
	?>
<h1>Data Level</h1>
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th class="col-md-1 text-center">No</th>
			<th>Level</th>
			<th class="col-md-2 text-center">#</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$db->select('level');
	$d = $db->getResult();
 	$i = 1; // untuk penomoran
	foreach($d as $d){ ?>
		<tr>
			<td class="text-center"><?=$i++;?></td>
			<td><?=$d['level'];?></td>
			<td class="text-center">
				<?=tbl_ubah("?hal=level_ubah&id=".$d['idlevel']);?>
				<?=tbl_hapus("?hal=level_ubah&hapus=".$d['idlevel']);?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php	
}else{
?>
<h1>Tambah Data Level <small>- <a href="?hal=level">Kembali</a></small></h1>
<?php
if(isset($_POST['level'])){
	echo "Processing...";
	$level = $db->escapeString(trim($_POST['level']));
	$db->insert('level',array('idlevel'=>id(),'level'=>$level,'usrcrt'=>$_SESSION['idpengguna'],'dtmcrt'=>wkt())) or eksyen('Error mysql: hubungi administrator','?hal=level');
	eksyen('','?hal=level');
}
?>
<form action="" method="POST" class="form-horizontal" role="form">
	<div class="form-group">
		<label for="inputLevel" class="col-sm-2 control-label">Nama Level:</label>
		<div class="col-sm-4">
			<input type="text" name="level" id="inputLevel" class="form-control" value="" required="required" maxlength="20" placeholder="Nama Level" autofocus>
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
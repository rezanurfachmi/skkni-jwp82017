<?php
if(isset($_GET['hapus'])){
	echo "<h1>Hapus Data Kategori</h1>";
	echo "Processing...";
	$hapus = $db->escapeString(trim($_GET['hapus']));
	$db->delete('kategori',"idkategori='$hapus'") or eksyen();
	eksyen('','?hal=kategori');
}elseif(isset($_GET['id'])){
	echo "<h1>Ubah Data Kategori <small>- <a href=\"?hal=kategori\">Kembali</a></small></h1>";
	$id = $db->escapeString(trim($_GET['id']));

	// simpan
	if(isset($_POST['kategori'])){
		echo "Processing...";
		$id = $db->escapeString(trim($_POST['id']));
		$kategori = $db->escapeString(trim($_POST['kategori']));
		$db->update('kategori',array('kategori'=>$kategori,'usrupd'=>$_SESSION['idpengguna'],'dtmupd'=>wkt()),"idkategori='$id'") or eksyen('Error mysql: hubungi administrator','?hal=kategori');
		eksyen('','?hal=kategori');
	}

	// lihat
	$l = new Database;
	$l->connect();
	$l->select('kategori','idkategori,kategori',null,"idkategori='$id'");
	$dl = $l->getResult();
	foreach($dl as $dl){ ?>
		<form action="" method="POST" class="form-horizontal" role="form">
			<input type="hidden" name="id" id="inputId" class="form-control" value="<?=$_GET['id'];?>">
			<div class="form-group">
				<label for="inputKategori" class="col-sm-2 control-label">Nama Kategori:</label>
				<div class="col-sm-4">
					<input type="text" name="kategori" id="inputKategori" class="form-control" autofocus value="<?=$dl['kategori'];?>" required="required" maxlength="20" placeholder="Nama Kategori">
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
}else{
	eksyen('','?hal=kategori');
}
?>
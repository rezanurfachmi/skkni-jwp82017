<?php
if(isset($_GET['hapus'])){
	echo "<h1>Hapus Data Level</h1>";
	echo "Processing...";
	$hapus = $db->escapeString(trim($_GET['hapus']));
	$db->delete('level',"idlevel='$hapus'") or eksyen();
	eksyen('','?hal=level');
}elseif(isset($_GET['id'])){
	echo "<h1>Ubah Data Level <small>- <a href=\"?hal=level\">Kembali</a></small></h1>";
	$id = $db->escapeString(trim($_GET['id']));

	// simpan
	if(isset($_POST['level'])){
		echo "Processing...";
		$id = $db->escapeString(trim($_POST['id']));
		$level = $db->escapeString(trim($_POST['level']));
		$db->update('level',array('level'=>$level,'usrupd'=>$_SESSION['idpengguna'],'dtmupd'=>wkt()),"idlevel='$id'") or eksyen('Error mysql: hubungi administrator','?hal=level');
		eksyen('','?hal=level');
	}

	// lihat
	$l = new Database;
	$l->connect();
	$l->select('level','idlevel,level',null,"idlevel='$id'");
	$dl = $l->getResult();
	foreach($dl as $dl){ ?>
		<form action="" method="POST" class="form-horizontal" role="form">
			<input type="hidden" name="id" id="inputId" class="form-control" value="<?=$_GET['id'];?>">
			<div class="form-group">
				<label for="inputLevel" class="col-sm-2 control-label">Nama Level:</label>
				<div class="col-sm-4">
					<input type="text" name="level" id="inputLevel" class="form-control" value="<?=$dl['level'];?>" required="required" maxlength="20" placeholder="Nama Level" autofocus>
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
	eksyen('','?hal=level');
}
?>
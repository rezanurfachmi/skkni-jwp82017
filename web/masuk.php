<h2 align="center">Masuk Toklat - Toko Cokelat</h2>

<?php
if(isset($_POST['username'])){
	$username = $db->escapeString(trim($_POST['username']));
	$password = $db->escapeString(trim($_POST['password']));
	$pass = md5($password);

	$db->select('pengguna','*',null,"username='$username' and password='$pass' and hapus='0'");
	$jd = $db->numRows();
	if($jd==1){
		$d = $db->getResult();
		foreach($d as $d){
			$_SESSION['idpengguna'] = $d['id'];
			$_SESSION['idadmin'] = $d['idlevel'];
			$idbiodata = konvert('biodata','idpengguna',$d['id'],'idbiodata');
			$_SESSION['idbiodata'] = konvert('biodata','idpengguna',$d['id'],'idbiodata');
			eksyen('','?hal=konfirmasi');
		}
	}else{
		eksyen('Maaf, username/password Anda keliru','?hal=masuk');
	}
	
}
?>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Tuliskan username/password dengan benar</h3>
			</div>
			<div class="panel-body">
				<form action="" method="POST" role="form">
				
					<div class="form-group">
						<input type="text" class="form-control" id="username" name="username" placeholder="Input Username" autofocus required>
					</div>

					<div class="form-group">
						<input type="password" class="form-control" id="password" name="password" placeholder="Input Password" required>
					</div>

					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Masuk</button>
					<a href="?hal=daftar" class="btn btn-warning pull-right"><i class="fa fa-plus"></i> Belum punya akun?</a>
				</form>
			</div>
		</div>
	</div>
</div>
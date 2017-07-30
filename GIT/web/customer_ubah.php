<h1>Tambah/Ubah Data Customer <small>- <a href="?hal=customer">Kembali</a></small></h1>
<?php
if(isset($_GET['id'])){
	$id = $db->escapeString(trim($_GET['id']));

	// ambil data biodata
	$bi = new Database;
	$bi->connect();
	$bi->select('biodata','*',null,"idbiodata='$id'");
	$dbi = $bi->getResult();

	// ambil data pengguna
	$pg = new Database;
	$pg->connect();
	$idpengguna = $dbi[0]['idpengguna']; // idpengguna
	$pg->select('pengguna','*',null,"id='$idpengguna'");
	$dpg = $pg->getResult();
}
	if(isset($_POST['input'])){
		echo "Processing...";
		$input = $db->escapeString(trim($_POST['input']));
		$level = $db->escapeString(trim($_POST['level']));
		$username = $db->escapeString(trim($_POST['username']));
		$password = $db->escapeString(trim($_POST['password']));
		$nama = $db->escapeString(trim($_POST['nama']));
		$nik = $db->escapeString(trim($_POST['nik']));
		$provinsi = $db->escapeString(trim($_POST['provinsi']));
		$kabupaten = $db->escapeString(trim($_POST['kabupaten']));
		$kecamatan = $db->escapeString(trim($_POST['kecamatan']));
		$kelurahan = $db->escapeString(trim($_POST['kelurahan']));
		$alamat = $db->escapeString(trim($_POST['alamat']));
		$pos = $db->escapeString(trim($_POST['pos']));
		$norumah = $db->escapeString(trim($_POST['norumah']));
		$nohp = $db->escapeString(trim($_POST['nohp']));

		if(!isset($_GET['id'])){

			$db->insert('pengguna',array(
											'id'=>$input,
											'idlevel'=>$level,
											'username'=>$username,
											'password'=>md5($password),
											'usrcrt'=>$_SESSION['idpengguna'],
											'dtmcrt'=>wkt()
										)) or eksyen('MySQL Error: Tbl Pengguna : Hubungi Administrator','?hal=customer');

			$db->insert('biodata',array(
											'idbiodata'=>id(),
											'idpengguna'=>$input,
											'nama'=>$nama,
											'nik'=>$nik,
											'alamat'=>$alamat,
											'kel'=>$kelurahan,
											'kec'=>$kecamatan,
											'kab'=>$kabupaten,
											'prov'=>$provinsi,
											'kodepos'=>$pos,
											'norumah'=>$norumah,
											'nohape'=>$nohp,
											'usrcrt'=>$_SESSION['idpengguna'],
											'dtmcrt'=>wkt()
										)) or eksyen('MySQL Error: Tbl Biodata : Hubungi Administrator','?hal=customer');
	}else{
		$db->update('pengguna',array(
											'idlevel'=>$level,
											'username'=>$username,
											'usrupd'=>$_SESSION['idpengguna'],
											'dtmupd'=>wkt()
										),
					"id='$idpengguna'") or eksyen('MySQL Error: Tbl Pengguna : Hubungi Administrator','?hal=customer');

		if($password!=""){
			$pass = md5($password);
			$db->update('pengguna',array(
											'password'=>$pass,
											'usrupd'=>$_SESSION['idpengguna'],
											'dtmupd'=>wkt()
										),
						"id='$idpengguna'") or eksyen('MySQL Error: Tbl Pengguna : Hubungi Administrator','?hal=customer');
		}

			$db->update('biodata',array(
											'nama'=>$nama,
											'nik'=>$nik,
											'alamat'=>$alamat,
											'kel'=>$kelurahan,
											'kec'=>$kecamatan,
											'kab'=>$kabupaten,
											'prov'=>$provinsi,
											'kodepos'=>$pos,
											'norumah'=>$norumah,
											'nohape'=>$nohp,
											'usrupd'=>$_SESSION['idpengguna'],
											'dtmupd'=>wkt()
										),
					"idbiodata='$id'") or eksyen('MySQL Error: Tbl Biodata : Hubungi Administrator','?hal=customer');
	}

		eksyen('','?hal=customer');
	}
?>
<form action="" method="POST" class="form-horizontal" role="form">
	<?php if(isset($_GET['id'])){ ?>
	<input type="hidden" name="input" id="inputUbah" class="form-control" value="<?=$_GET['id'];?>">
	<?php }else{ ?>
	<input type="hidden" name="input" id="inputInput" class="form-control" value="<?=id();?>">
	<?php } ?>
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Informasi Login</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="inputLevel" class="col-sm-2 control-label">Level:</label>
				<div class="col-sm-2">
					<select name="level" id="inputLevel" class="form-control" required="required" autofocus>
						<?php if(isset($_GET['id'])){ ?>
						<option value="<?=$dpg[0]['idlevel'];?>"><?=konvert('level','idlevel',$dpg[0]['idlevel'],'level');?></option>
						<?php } ?>
						<option value="">-- Pilih Level --</option>
						<?php
						$lv = new Database;
						$lv->connect();
						$lv->select('level');
						$dlv = $lv->getResult();
						foreach($dlv as $dlv){ ?>
						<option value="<?=$dlv['idlevel'];?>"><?=$dlv['level'];?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputUsername" class="col-sm-2 control-label">Username:</label>
				<div class="col-sm-4">
					<input type="text" name="username" id="inputUsername" class="form-control" value="<?php if(isset($_GET['id'])){ echo $dpg[0]['username']; } ?>" required="required" placeholder="Input Username" maxlength="20">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword" class="col-sm-2 control-label">Password:</label>
				<div class="col-sm-4">
					<input type="password" name="password" id="inputPassword" class="form-control" <?php if(!isset($_GET['id'])){ ?>required="required"<?php } ?> placeholder="Input Password">
					<?php if(isset($_GET['id'])){ ?><span id="helpBlock" class="help-block">Kosongkan password jika tidak ingin mengubahnya.</span><?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Biodata Pengguna</h3>
		</div>
		<div class="panel-body">
			<div class="form-group">
				<label for="inputNama" class="col-sm-2 control-label">Nama:</label>
				<div class="col-sm-4">
					<input type="text" name="nama" id="inputNama" class="form-control" value="<?php if(isset($_GET['id'])){ echo $dbi[0]['nama']; } ?>" required="required" placeholder="Nama Lengkap" maxlength="50">
				</div>
			</div>
			<div class="form-group">
				<label for="inputNik" class="col-sm-2 control-label">Nik:</label>
				<div class="col-sm-4">
					<input type="number" name="nik" id="inputNik" class="form-control" value="<?php if(isset($_GET['id'])){ echo $dbi[0]['nik']; } ?>" required="required" placeholder="Nomor KTP" maxlength="25">
				</div>
			</div>
			<div class="form-group">
				<label for="inputProvinsi" class="col-sm-2 control-label">Provinsi:</label>
				<div class="col-sm-4">
					<select name="provinsi" id="inputProvinsi" class="form-control" >
						<?php if(isset($_GET['id'])){ ?>
						<option value="<?=$dbi[0]['prov'];?>"><?=konvert('provinsi','id',$dbi[0]['prov'],'name');?></option>
						<?php } ?>
						<option value="">----- Pilih Provinsi -----</option>
					<?php $pro=new Database; $pro->connect(); $pro->select('provinsi'); $dpro=$pro->getResult(); foreach($dpro as $dpro){ ?>
						<option value="<?=$dpro['id'];?>"><?=$dpro['name'];?></option>
					<?php } ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="inputKabupaten" class="col-sm-2 control-label">Kabupaten:</label>
				<div class="col-sm-4">
					<select name="kabupaten" id="inputKabupaten" class="form-control" >
						<?php if(isset($_GET['id'])){ ?>
						<option value="<?=$dbi[0]['kab'];?>"><?=konvert('kabupaten','id',$dbi[0]['kab'],'name');?></option>
						<?php } ?>
						<option value="">----- Pilih Kabupaten -----</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="inputKecamatan" class="col-sm-2 control-label">Kecamatan:</label>
				<div class="col-sm-4">
					<select name="kecamatan" id="inputKecamatan" class="form-control" >
						<?php if(isset($_GET['id'])){ ?>
						<option value="<?=$dbi[0]['kec'];?>"><?=konvert('kecamatan','id',$dbi[0]['kec'],'name');?></option>
						<?php } ?>
						<option value="">----- Pilih Kecamatan -----</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="inputKelurahan" class="col-sm-2 control-label">Kelurahan:</label>
				<div class="col-sm-4">
					<select name="kelurahan" id="inputKelurahan" class="form-control" >
						<?php if(isset($_GET['id'])){ ?>
						<option value="<?=$dbi[0]['kel'];?>"><?=konvert('kelurahan','id',$dbi[0]['kel'],'name');?></option>
						<?php } ?>
						<option value="">----- Pilih Kelurahan -----</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="inputAlamat" class="col-sm-2 control-label">Alamat:</label>
				<div class="col-sm-6">
					<input type="text" name="alamat" id="inputAlamat" class="form-control" value="<?php if(isset($_GET['id'])){ echo $dbi[0]['alamat']; } ?>" required="required" placeholder="Alamat Detail" maxlength="50">
				</div>
			</div>

			<div class="form-group">
				<label for="inputKodepos" class="col-sm-2 control-label">Kode Pos:</label>
				<div class="col-sm-2">
					<input type="number" name="pos" id="inputKodepos" class="form-control" maxlength="5" value="<?php if(isset($_GET['id'])){ echo $dbi[0]['kodepos']; } ?>" placeholder="Kode Pos" maxlength="5">
				</div>
			</div>

			<div class="form-group">
				<label for="inputNorumah" class="col-sm-2 control-label">No Telp.Rumah:</label>
				<div class="col-sm-2">
					<input type="number" name="norumah" id="inputNorumah" class="form-control" value="<?php if(isset($_GET['id'])){ echo $dbi[0]['norumah']; } ?>" required="required" placeholder="Nomor Telpon Rumah" maxlength="12">
				</div>
			</div>

			<div class="form-group">
				<label for="inputNohp" class="col-sm-2 control-label">No Handphone:</label>
				<div class="col-sm-2">
					<input type="text" name="nohp" id="inputNohp" class="form-control" value="<?php if(isset($_GET['id'])){ echo $dbi[0]['nohape']; } ?>" required="required" placeholder="Nomor Handphone" maxlength="15">
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-10 col-sm-offset-2">
			<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$("#inputProvinsi").change(function(){
			var idprovinsi = $("#inputProvinsi").val();
			$.ajax({
			    url: "../bantuan/request_kabupaten.php",
			    data: "idprovinsi="+idprovinsi,
			    cache: false,
			    success: function(msg){
			        $("#inputKabupaten").html(msg);
			    }
			});
		});
		$("#inputKabupaten").change(function(){
			var idkabupaten = $("#inputKabupaten").val();
			$.ajax({
			    url: "../bantuan/request_kecamatan.php",
			    data: "idkabupaten="+idkabupaten,
			    cache: false,
			    success: function(msg){
			        $("#inputKecamatan").html(msg);
			    }
			});
		});
		$("#inputKecamatan").change(function(){
			var idkecamatan = $("#inputKecamatan").val();
			$.ajax({
			    url: "../bantuan/request_kelurahan.php",
			    data: "idkecamatan="+idkecamatan,
			    cache: false,
			    success: function(msg){
			        $("#inputKelurahan").html(msg);
			    }
			});
		});
	});
</script>
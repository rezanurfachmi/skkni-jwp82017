<h2 align="center">Daftar Toklat - Toko Cokelat</h2>
<?php
if(isset($_POST['username'])){
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

	// ambil level Customer
	$c = new Database;
	$c->connect();
	$c->sql("select * from level where level='Customer'");
	$dc = $c->getResult();
	$idlevel = $dc[0]['idlevel'];

	$idpengguna = id();

	$db->insert('pengguna',array(
									'id'=>$idpengguna,
									'idlevel'=>$idlevel,
									'username'=>$username,
									'password'=>md5($password),
									'usrcrt'=>$idpengguna,
									'dtmcrt'=>wkt()
								)) or eksyen('MySQL Error: Tbl Pengguna : Hubungi Administrator','?hal=customer');

	$db->insert('biodata',array(
									'idbiodata'=>id(),
									'idpengguna'=>$idpengguna,
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
									'usrcrt'=>$idpengguna,
									'dtmcrt'=>wkt()
								)) or eksyen('MySQL Error: Tbl Biodata : Hubungi Administrator','?hal=customer');
	eksyen('Berhasil Daftar.','?hal=masuk');
}
?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Tulis data dengan lengkap dan benar.</h3>
			</div>
			<div class="panel-body">
				<form action="" method="POST" role="form">
				
					<div class="form-group">
						<input type="text" class="form-control" id="username" name="username" placeholder="Input Username" required>
					</div>

					<div class="form-group">
						<input type="password" class="form-control" id="password" name="password" placeholder="Input Password" required>
					</div>

					<div class="form-group">
						<input type="text" name="nik" id="inputNama" class="form-control" value="" required="required" placeholder="Nomor KTP">
					</div>

					<div class="form-group">
						<input type="text" name="nama" id="inputNama" class="form-control" value="" required="required" placeholder="Nama Lengkap Anda">
					</div>

					<div class="form-group">
						<select name="provinsi" id="inputProvinsi" class="form-control" required>
							<option value="">----- Pilih Provinsi -----</option>
						<?php $pro=new Database; $pro->connect(); $pro->select('provinsi'); $dpro=$pro->getResult(); foreach($dpro as $dpro){ ?>
							<option value="<?=$dpro['id'];?>"><?=$dpro['name'];?></option>
						<?php } ?>
						</select>
					</div>

					<div class="form-group">
						<select name="kabupaten" id="inputKabupaten" class="form-control" required>
							<option value="">----- Pilih Kabupaten -----</option>
						</select>
					</div>

					<div class="form-group">
						<select name="kecamatan" id="inputKecamatan" class="form-control" required>
							<option value="">----- Pilih Kecamatan -----</option>
						</select>
					</div>

					<div class="form-group">
						<select name="kelurahan" id="inputKelurahan" class="form-control" required>
							<option value="">----- Pilih Kelurahan -----</option>
						</select>
					</div>

					<div class="form-group">
						<input type="text" name="alamat" id="inputAlamat" class="form-control" value="" required="required" placeholder="Alamat Detail" maxlength="50">
					</div>

					<div class="form-group">
						<input type="number" name="pos" id="inputKodepos" class="form-control" maxlength="5" value="" placeholder="Kode Pos" max="99999">
					</div>

					<div class="form-group">
						<input type="text" name="norumah" id="inputNohp" class="form-control" value="" placeholder="Nomor Telp.Rumah" maxlength="12">
					</div>

					<div class="form-group">
						<input type="text" name="nohp" id="inputNohp" class="form-control" value="" required="required" placeholder="Nomor Handphone" maxlength="15">
					</div>

					<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Daftar</button>
					<a href="?hal=masuk" class="btn btn-warning pull-right"><i class="fa fa-sign-in"></i> Sudah punya akun?</a>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$("#inputProvinsi").change(function(){
			var idprovinsi = $("#inputProvinsi").val();
			$.ajax({
			    url: "bantuan/request_kabupaten.php",
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
			    url: "bantuan/request_kecamatan.php",
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
			    url: "bantuan/request_kelurahan.php",
			    data: "idkecamatan="+idkecamatan,
			    cache: false,
			    success: function(msg){
			        $("#inputKelurahan").html(msg);
			    }
			});
		});
	});
</script>
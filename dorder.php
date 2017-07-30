<?php
// Pembatasan Pemesanan
// Harus login terlebih dahulu
if(!isset($_SESSION['idpengguna'])){
	eksyen('Maaf, Anda harus login terlebih dahulu','?hal=masuk');
}

// Memeriksa keadaan produk
if(!isset($_GET['id'])){
	eksyen('','index.php');
}else{
	// cek keberadaan produk
	$id = $db->escapeString(trim($_GET['id']));
	$db->select('pesan','*',null,"idpesan='$id'");
	$j = $db->numRows();
	if($j<=0){
		eksyen('Maaf, data tidak tersedia','index.php');
	}

	$dpes = $db->getResult();
	

	// detail produk
	$idproduk = $dpes[0]['idproduk'];
	$pr = new Database;
	$pr->connect();
	$pr->select('produk','*',null,"idproduk='$idproduk'");
	$d = $pr->getResult();


	// detail alamat penerima
	$ap = new Database;
	$ap->connect();
	$ap->select('penerima','*',null,"idpesan='$id'");
	$dap = $ap->getResult();

}

if(isset($_POST['ucapan'])){
	echo "Processing...";
	$id = $db->escapeString(trim($_POST['id']));
	$ucapan = $db->escapeString(trim($_POST['ucapan']));
	$idproduk = $db->escapeString(trim($_POST['idproduk']));
	$idbiodata = $_SESSION['idbiodata'];
	$harga = konvert('produk','idproduk',$idproduk,'harga');
	$nama = $db->escapeString(trim($_POST['nama']));
	$provinsi = $db->escapeString(trim($_POST['provinsi']));
	$kabupaten = $db->escapeString(trim($_POST['kabupaten']));
	$kecamatan = $db->escapeString(trim($_POST['kecamatan']));
	$kelurahan = $db->escapeString(trim($_POST['kelurahan']));
	$alamat = $db->escapeString(trim($_POST['alamat']));
	$pos = $db->escapeString(trim($_POST['pos']));
	$nohp = $db->escapeString(trim($_POST['nohp']));

	$db->update('pesan',array(
								'idbiodata'=>$idbiodata,
								'idproduk'=>$idproduk,
								'teks'=>$ucapan,
								'total'=>$harga,
								'usrupd'=>$_SESSION['idpengguna'],
								'dtmupd'=>wkt()
							),
						"idpesan='$id'") or eksyen('Error MySQL Pesan: Hubungi Administrator','index.php');

	$db->update('penerima',array(
								'nama'=>$nama,
								'alamat'=>$alamat,
								'kel'=>$kelurahan,
								'kec'=>$kecamatan,
								'kab'=>$kabupaten,
								'prov'=>$provinsi,
								'kodepos'=>$pos,
								'nohape'=>$nohp,
							),
						"idpesan='$id'") or eksyen('Error MySQL Penerima: Hubungi Administrator','index.php');

	// upload gambar. jika ada
	if($_FILES['gambar']['name']!=""){
		$target_dir = "pesanan/";
		$target_file = $target_dir . sid() . basename($_FILES["gambar"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Periksa keaslian gambar
		if(isset($_POST["nama"])) {
		    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
		    if($check !== false) {
		        echo "Berkas berupa gambar - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        echo "Berkas bukan gambar.";
		        $uploadOk = 0;
		    }
		}
		// Periksa apakah sudah ada gambar yang sama
		if (file_exists($target_file)) {
		    echo "Maaf, berkas sudah ada.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["gambar"]["size"] > 500000) {
		    echo "Maaf, gambar Anda terlalu besar.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Maaf, hanya JPG, JPEG, PNG & GIF yang diperbolehkan.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    echo "Maaf, gambar Anda gagal diunggah.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
		        echo "Gambar ". basename( $_FILES["gambar"]["name"]). " berhasil diunggah.";

		        $db->update('pesan',array(
		        							'gambar'=>$target_file
		        						),"idpesan='$id'") or eksyen('Error MySQL Pesan: Hubungi administrator','?hal=produk');
		        //eksyen('','?hal=produk');
		    } else {
		        eksyen('Maaf, ada kesalahan dalam unggahan gambar Anda.','?hal=produk');
		    }
		}
	}

	eksyen('','?hal=order');
}
?>
<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<p>Pilih Kategori</p>
				<ul class="list-group">
					<?php 
					$sd = new Database;
					$sd->connect();
					$sd->select('kategori');
					$dsd = $sd->getResult();
					foreach($dsd as $dsd){ ?>
					<li class="list-group-item"><a href="?hal=kategori&id=<?=$dsd['idkategori'];?>"><?=$dsd['kategori'];?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>	
	</div>
	<div class="col-md-9">
		<?php foreach($dpes as $dp){ foreach($d as $d){ ?>
		<div class="row">
			<div class="col-md-3">
				<img src="web/<?=$d['gambar'];?>" class="img-responsive">
				<?php if($dp['gambar']!=""){ ?>
				<p>&nbsp;</p>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Gambar Pesanan</h3>
					</div>
					<div class="panel-body">
							<img src="<?=$dp['gambar'];?>" class="img-responsive">
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="col-md-9">
				<h1>PESAN <?=strtoupper($d['nama']);?> <small>- <a href="?hal=order">Kembali</a></small></h1>
				<ol class="breadcrumb">
					<li><a href=".">Cokelat</a></li>
					<li><a href="?hal=kategori&id=<?=$d['idkategori'];?>"><?=konvert('kategori','idkategori',$d['idkategori'],'kategori');?></a></li>
					<li class="active"><?=$d['nama'];?></li>
				</ol>
				<form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
					<input type="hidden" name="id" id="inputId" class="form-control" value="<?=$_GET['id'];?>">
					<input type="hidden" name="idproduk" id="inputIdproduk" class="form-control" value="<?=$d['idproduk'];?>">

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Detail Kue</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<div class="form-group">
									<label for="inputUcapan" class="col-sm-2 control-label">Ucapan:</label>
									<div class="col-sm-9">
										<input type="text" name="ucapan" id="inputUcapan" class="form-control" value="<?=$dp['teks'];?>" placeholder="Tuliskan ucapan." maxlength="50" autofocus>
										<span id="helpBlock" class="help-block">Maksimal 50 karakter.</span>
									</div>
								</div>
								<div class="form-group">
									<label for="inputGambar" class="col-sm-2 control-label">Gambar:</label>
									<div class="col-sm-10">
										<input type="file" name="gambar" id="inputGambar">
										<span id="helpBlock" class="help-block">Gambar akan dicetak menjadi ukuran A6. Mengunggah gambar baru, akan menghapus <strong>gambar pesanan</strong>.</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Detail Penerima</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label for="inputNama" class="col-sm-3 control-label">Nama:</label>
								<div class="col-sm-9">
									<input type="text" name="nama" id="inputNama" class="form-control" value="<?=$dap[0]['nama'];?>" required="required" placeholder="Nama Penerima">
								</div>
							</div>
							<div class="form-group">
								<label for="inputProvinsi" class="col-sm-3 control-label">Provinsi:</label>
								<div class="col-sm-9">
									<select name="provinsi" id="inputProvinsi" class="form-control" >
										<option value="<?=$dap[0]['prov'];?>"><?=konvert('provinsi','id',$dap[0]['prov'],'name');?></option>
										<option value="">----- Pilih Provinsi -----</option>
									<?php $pro=new Database; $pro->connect(); $pro->select('provinsi'); $dpro=$pro->getResult(); foreach($dpro as $dpro){ ?>
										<option value="<?=$dpro['id'];?>"><?=$dpro['name'];?></option>
									<?php } ?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="inputKabupaten" class="col-sm-3 control-label">Kabupaten:</label>
								<div class="col-sm-9">
									<select name="kabupaten" id="inputKabupaten" class="form-control" >
										<option value="<?=$dap[0]['kab'];?>"><?=konvert('kabupaten','id',$dap[0]['kab'],'name');?></option>
										<option value="">----- Pilih Kabupaten -----</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="inputKecamatan" class="col-sm-3 control-label">Kecamatan:</label>
								<div class="col-sm-9">
									<select name="kecamatan" id="inputKecamatan" class="form-control" >
										<option value="<?=$dap[0]['kec'];?>"><?=konvert('kecamatan','id',$dap[0]['kec'],'name');?></option>
										<option value="">----- Pilih Kecamatan -----</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="inputKelurahan" class="col-sm-3 control-label">Kelurahan:</label>
								<div class="col-sm-9">
									<select name="kelurahan" id="inputKelurahan" class="form-control" >
										<option value="<?=$dap[0]['kel'];?>"><?=konvert('kelurahan','id',$dap[0]['kel'],'name');?></option>
										<option value="">----- Pilih Kelurahan -----</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="inputAlamat" class="col-sm-3 control-label">Alamat:</label>
								<div class="col-sm-9">
									<input type="text" name="alamat" id="inputAlamat" class="form-control" value="<?=$dap[0]['alamat'];?>" required="required" placeholder="Alamat Detail" maxlength="50">
								</div>
							</div>

							<div class="form-group">
								<label for="inputKodepos" class="col-sm-3 control-label">Kode Pos:</label>
								<div class="col-sm-9">
									<input type="number" name="pos" id="inputKodepos" class="form-control" maxlength="5" value="<?=$dap[0]['kodepos'];?>" placeholder="Kode Pos" max="99999">
								</div>
							</div>

							<div class="form-group">
								<label for="inputNohp" class="col-sm-3 control-label">No Handphone:</label>
								<div class="col-sm-9">
									<input type="text" name="nohp" id="inputNohp" class="form-control" value="<?=$dap[0]['nohape'];?>" required="required" placeholder="Nomor Handphone" maxlength="15">
								</div>
							</div>
						</div>
					</div>
				
				<p>
					<button type="submit" class="btn btn-info">Rp.<?=number_format($d['harga']);?></button>
					<button type="submit" class="btn btn-success"><i class="fa fa-pencil"></i> Ubah</button>
					<a href="?hal=batal&id=<?=$_GET['id'];?>" class="btn btn-default pull-right" <?=yakin();?>><i class="fa fa-remove"></i> Batalkan Pesanan</a>
				</p>
				</form>
			</div>
		</div>
		<?php } } ?>
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
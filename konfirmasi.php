<h1>Konfirmasi Pembayaran <small>- <a href="?hal=order">Kembali</a></small></h1>

<?php
// Pembatasan Pemesanan
// Harus login terlebih dahulu
if(!isset($_SESSION['idpengguna'])){
	eksyen('Maaf, Anda harus login terlebih dahulu','?hal=masuk');
}

// Memeriksa keadaan produk
if(!isset($_GET['id'])){
	eksyen('','?hal=order');
}else{
	// cek keberadaan order
	$id = $db->escapeString(trim($_GET['id']));
	$db->select('pesan','*',null,"idpesan='$id'");
	$j = $db->numRows();
	if($j<=0){
		eksyen('Maaf, tidak ada pesanan','?hal=order');
	}

	$d = $db->getResult();
}

// simpan konfirmasi pembayaran
if(isset($_POST['nama'])){
	$nama = $db->escapeString(trim($_POST['nama']));
	$idpesan = $db->escapeString(trim($_POST['idpesan']));
	$bank = $db->escapeString(trim($_POST['bank']));
	$jumlah = $db->escapeString(trim($_POST['jumlah']));
	$tanggal = $db->escapeString(trim($_POST['tanggal']));
	$idpengguna = $_SESSION['idpengguna'];

	// upload gambar dahulu
	if($_FILES['gambar']['name']!=""){
		$target_dir = "konfirmasi/";
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

		        // input ke tabel konfirmasi
		        $db->insert('konfirmasi',array(
		        							'idkonfirmasi'=>id(),
		        							'idpengguna'=>$idpengguna,
		        							'idpesan'=>$idpesan,
		        							'pengirim'=>$nama,
		        							'bank'=>$bank,
		        							'jumlah'=>$jumlah,
		        							'tanggal'=>$tanggal,
		        							'gambar'=>$target_file,
		        							'usrcrt'=>$_SESSION['idpengguna'],
		        							'dtmcrt'=>wkt()
		        						)) or eksyen('Error MySQL Konfirmasi: Hubungi administrator','?hal=order');

		        // update status pemesanan
		        $db->update('pesan',array('konfirmasi'=>'1'),"idpesan='$idpesan'") or eksyen('Error MySQL Pesan: Hubungi administrator','?hal=order');
		        
		        eksyen('','?hal=order');
		    } else {
		        eksyen('Maaf, ada kesalahan dalam unggahan gambar Anda.','?hal=order');
		    }
		}
	}
}
?>

<?=jqui();?>
<script>
$( function() {
	$( "#datepicker" ).datepicker({
		dateFormat: 'yy-mm-dd'
	});
} );
</script>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Detail Pembayaran</h3>
	</div>
	<div class="panel-body">
		<form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
			<input type="hidden" name="idpesan" id="inputIdpesan" class="form-control" value="<?=$_GET['id'];?>">
			<div class="form-group">
				<label for="inputNama" class="col-sm-2 control-label">Nama Pengirim:</label>
				<div class="col-sm-10">
					<input type="text" name="nama" id="inputNama" class="form-control" value="" required="required" placeholder="Nama Pemilik Nomor Rekening" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label for="inputBank" class="col-sm-2 control-label">Nama Bank:</label>
				<div class="col-sm-10">
					<input type="text" name="bank" id="inputBank" class="form-control" value="" required="required" placeholder="Nama Bank Pengirim">
				</div>
			</div>
			<div class="form-group">
				<label for="inputJumlah" class="col-sm-2 control-label">Jumlah Transfer:</label>
				<div class="col-sm-10">
					<input type="number" min="1" max="9999999" name="jumlah" id="inputJumlah" class="form-control" value="" required="required" placeholder="Nominal yang ditransfer">
				</div>
			</div>
			<div class="form-group">
				<label for="datepicker" class="col-sm-2 control-label">Tanggal Transfer:</label>
				<div class="col-sm-10">
					<input type="text" name="tanggal" id="datepicker" class="form-control" value="" required="required" placeholder="Tanggal transfer">
				</div>
			</div>
			<div class="form-group">
				<label for="inputBukti" class="col-sm-2 control-label">Bukti Transfer:</label>
				<div class="col-sm-10">
					<input type="file" name="gambar" id="inputBukti" placeholder="Unggah bukti pembayaran" required>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-10 col-sm-offset-2">
					<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</div>
		</form>
	</div>
</div>
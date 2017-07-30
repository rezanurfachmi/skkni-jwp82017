<h1>Ubah Data Produk <small>- <a href="?hal=produk">Kembali</a></small></h1>

<?php

if(isset($_GET['id'])){
	$id = $db->escapeString(trim($_GET['id']));

	$db->select('produk','*',null,"idproduk='$id'");
	$d = $db->getResult();
}else{
	eksyen('','?hal=produk');
}


if(isset($_POST['nama'])){
	$nama = $db->escapeString(trim($_POST['nama']));
	$kategori = $db->escapeString(trim($_POST['kategori']));
	$deskripsi = $db->escapeString(trim($_POST['deskripsi']));
	$harga = $db->escapeString(trim($_POST['harga']));

	// upload gambar dahulu
	if($_FILES['gambar']['name']!=""){
		$target_dir = "foto/";
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

		        $db->update('produk',array(
		        							'idkategori'=>$kategori,
		        							'nama'=>$nama,
		        							'deskripsi'=>$deskripsi,
		        							'harga'=>$harga,
		        							'gambar'=>$target_file,
		        							'usrupd'=>$_SESSION['idpengguna'],
		        							'dtmupd'=>wkt()
		        						),
		        			"idproduk='$id'") or eksyen('Error MySQL Produk: Hubungi administrator','?hal=produk');
		    } else {
		        eksyen('Maaf, ada kesalahan dalam unggahan gambar Anda.','?hal=produk');
		    }
		}
	}else{
		$db->update('produk',array(
        							'idkategori'=>$kategori,
        							'nama'=>$nama,
        							'deskripsi'=>$deskripsi,
        							'harga'=>$harga,
        							'usrupd'=>$_SESSION['idpengguna'],
        							'dtmupd'=>wkt()
        						),
        			"idproduk='$id'") or eksyen('Error MySQL Produk: Hubungi administrator','?hal=produk');
	}
	eksyen('','?hal=produk');
}


foreach($d as $d){
?>
<div class="col-md-9">
	<form action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
		<div class="form-group">
			<label for="inputNama" class="col-sm-2 control-label">Nama Kue:</label>
			<div class="col-sm-10">
				<input type="text" name="nama" id="inputNama" class="form-control" value="<?=$d['nama'];?>" required="required" placeholder="Nama Kue" maxlength="50" autofocus>
			</div>
		</div>

		<div class="form-group">
			<label for="inputKategori" class="col-sm-2 control-label">Kategori:</label>
			<div class="col-sm-2">
				<select name="kategori" id="inputKategori" class="form-control" required="required">
					<option value="<?=$d['idkategori'];?>"><?=konvert('kategori','idkategori',$d['idkategori'],'kategori');?></option>
					<option value="">-- Pilih Kategori Kue --</option>
							<?php
							$kt = new Database;
							$kt->connect();
							$kt->select('kategori');
							$dkt = $kt->getResult();
							foreach($dkt as $dkt){ ?>
							<option value="<?=$dkt['idkategori'];?>"><?=$dkt['kategori'];?></option>
							<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="textareaDeskripsi" class="col-sm-2 control-label">Deskripsi:</label>
			<div class="col-sm-10">
				<textarea name="deskripsi" id="textareaDeskripsi" class="form-control" rows="3" required="required" placeholder="Deskripsi Kue" maxlength="255"><?=$d['deskripsi'];?></textarea>
			</div>
		</div>

		<div class="form-group">
			<label for="inputHarga" class="col-sm-2 control-label">Harga:</label>
			<div class="col-sm-10">
				<input type="number" name="harga" id="inputHarga" value="<?=$d['harga'];?>" class="form-control" min="1" max="9999999" placeholder="Harga Kue" maxlength="7">
			</div>
		</div>

		<div class="form-group">
			<label for="inputGambar" class="col-sm-2 control-label">Gambar:</label>
			<div class="col-sm-10">
				<input type="file" name="gambar" id="inputGambar">
				<span id="helpBlock" class="help-block">Dengan mengupload gambar baru, maka akan menghapus gambar yang lama.</span>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<button type="submit" class="btn btn-primary"><i class="fa fa-saves"></i> Simpan</button>
			</div>
		</div>
	</form>
</div>
<div class="col-md-3">
	<img src="<?=$d['gambar'];?>" class="img-responsive">
</div>
<?php } ?>
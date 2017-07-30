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

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title">Detail Kue</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<div class="form-group">
									<label for="inputUcapan" class="col-sm-2 control-label">Ucapan:</label>
									<div class="col-sm-9">
										<input type="text" name="ucapan" id="inputUcapan" class="form-control" value="<?=$dp['teks'];?>" placeholder="Tuliskan ucapan." maxlength="50" disabled>
										<span id="helpBlock" class="help-block">Maksimal 50 karakter.</span>
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
									<input type="text" name="nama" id="inputNama" class="form-control" value="<?=$dap[0]['nama'];?>" required="required" placeholder="Nama Penerima" disabled>
								</div>
							</div>
							<div class="form-group">
								<label for="inputProvinsi" class="col-sm-3 control-label">Provinsi:</label>
								<div class="col-sm-9">
									<select name="provinsi" id="inputProvinsi" class="form-control" disabled>
										<option value="<?=$dap[0]['prov'];?>"><?=konvert('provinsi','id',$dap[0]['prov'],'name');?></option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="inputKabupaten" class="col-sm-3 control-label">Kabupaten:</label>
								<div class="col-sm-9">
									<select name="kabupaten" id="inputKabupaten" class="form-control" disabled>
										<option value="<?=$dap[0]['kab'];?>"><?=konvert('kabupaten','id',$dap[0]['kab'],'name');?></option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="inputKecamatan" class="col-sm-3 control-label">Kecamatan:</label>
								<div class="col-sm-9">
									<select name="kecamatan" id="inputKecamatan" class="form-control" disabled>
										<option value="<?=$dap[0]['kec'];?>"><?=konvert('kecamatan','id',$dap[0]['kec'],'name');?></option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="inputKelurahan" class="col-sm-3 control-label">Kelurahan:</label>
								<div class="col-sm-9">
									<select name="kelurahan" id="inputKelurahan" class="form-control" disabled>
										<option value="<?=$dap[0]['kel'];?>"><?=konvert('kelurahan','id',$dap[0]['kel'],'name');?></option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="inputAlamat" class="col-sm-3 control-label">Alamat:</label>
								<div class="col-sm-9">
									<input type="text" name="alamat" id="inputAlamat" class="form-control" value="<?=$dap[0]['alamat'];?>" required="required" placeholder="Alamat Detail" maxlength="50" disabled>
								</div>
							</div>

							<div class="form-group">
								<label for="inputKodepos" class="col-sm-3 control-label">Kode Pos:</label>
								<div class="col-sm-9">
									<input type="number" name="pos" id="inputKodepos" class="form-control" maxlength="5" value="<?=$dap[0]['kodepos'];?>" placeholder="Kode Pos" max="99999" disabled>
								</div>
							</div>

							<div class="form-group">
								<label for="inputNohp" class="col-sm-3 control-label">No Handphone:</label>
								<div class="col-sm-9">
									<input type="text" name="nohp" id="inputNohp" class="form-control" value="<?=$dap[0]['nohape'];?>" required="required" placeholder="Nomor Handphone" maxlength="15" disabled>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php } } ?>
	</div>
</div>
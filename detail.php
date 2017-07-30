<?php
if(!isset($_GET['id'])){
	eksyen('','index.php');
}else{
	// cek keberadaan produk
	$id = $db->escapeString(trim($_GET['id']));
	$db->select('produk','*',null,"idproduk='$id'");
	$j = $db->numRows();
	if($j<=0){
		eksyen('Maaf, kue tidak tersedia','index.php');
	}

	$d = $db->getResult();
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
		<?php foreach($d as $d){ ?>
		<div class="row">
			<div class="col-md-3">
				<img src="web/<?=$d['gambar'];?>" class="img-responsive">
			</div>
			<div class="col-md-9">
				<h1><?=strtoupper($d['nama']);?></h1>
				<ol class="breadcrumb">
					<li><a href=".">Cokelat</a></li>
					<li><a href="?hal=kategori&id=<?=$d['idkategori'];?>"><?=konvert('kategori','idkategori',$d['idkategori'],'kategori');?></a></li>
					<li class="active"><?=$d['nama'];?></li>
				</ol>
				<p><?=$d['deskripsi'];?></p>
				<p>
					<a href="?hal=pesan&id=<?=$d['idproduk'];?>" class="btn btn-info">Rp.<?=number_format($d['harga']);?></a>
					<a href="?hal=pesan&id=<?=$d['idproduk'];?>" class="btn btn-danger"><i class="fa fa-shopping-cart"></i> Beli</a>
				</p>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
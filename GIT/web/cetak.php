<?php 
session_start(); 
include '../db.php';
$db = new Database;
$db->connect();


if(!isset($_SESSION['idpengguna'])){
	eksyen('Maaf, Anda harus login terlebih dahulu','../?hal=masuk');
}

// Memeriksa keadaan produk
if(!isset($_GET['idpesan'])){
	eksyen('','index.php');
}else{
	// cek keberadaan produk
	$id = $db->escapeString(trim($_GET['idpesan']));
	$db->select('pesan','*',null,"idpesan='$id'");
	$j = $db->numRows();
	if($j<=0){
		eksyen('Maaf, data tidak tersedia','?hal=pesanan');
	}

	$dpes = $db->getResult();
	foreach($dpes as $dpes){
?><!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Toklat - Toko Cokelat</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="../css/crulean-bootstrap.min.css">
		<link rel="stylesheet" href="../css/font-awesome.min.css">
		<link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->


		<!-- jQuery -->
		<script src="../js/jquery-1.11.1.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="../js/bootstrap.min.js"></script>

	    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
	    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

	</head>
	<body class="container-fluid">
	<div class="row text-center">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Dari <?=strtoupper(konvert('biodata','idbiodata',$dpes['idbiodata'],'nama'));?>, Spesial Untuk Kamu</h3>
				</div>
				<div class="panel-body">
					<h4><?=$dpes['teks'];?></h4>
					<img src="../<?=$dpes['gambar'];?>" height="300">
				</div>
				<div class="panel-footer">
					<p>Toklat - Toko Cokelat</p>
					<p>www.toklat.id</p>
				</div>
			</div>
		</div>
	</div>
<?php }} ?>
<script type="text/javascript">
	window.print();
	window.close();
</script>
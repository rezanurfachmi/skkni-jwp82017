<?php 
session_start(); 
include '../db.php';
$db = new Database;
$db->connect();

// cek level
$cl = new Database;
$cl->connect();
$cl->sql("select idlevel from level where level='Administrator'");
$dcl = $cl->getResult();
$idadmin = $dcl[0]['idlevel'];

if($_SESSION['idadmin']!=$idadmin){
	eksyen('Anda harus masuk terlebih dahulu','../?hal=masuk');
}
?><!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Administrator Toklat - Toko Cokelat</title>

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
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href=".">Toklat - Toko Coklat</a>
				</div>
		
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Data Level <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?hal=level">Data Level</a></li>
								<li><a href="?hal=level&aksi=input">Tambah Level</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i> Data Customer <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?hal=customer">Data Customer</a></li>
								<li><a href="?hal=customer_ubah">Tambah Customer</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> Data Kategori <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?hal=kategori">Data Kategori</a></li>
								<li><a href="?hal=kategori&aksi=input">Tambah Kategori</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-folder"></i> Data Produk <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="?hal=produk">Data Produk</a></li>
								<li><a href="?hal=produk_input">Tambah Produk</a></li>
							</ul>
						</li>
						<li><a href="?hal=pesanan"><i class="fa fa-shopping-cart"></i> Data Pesanan</a></li>
						<li><a href="?hal=konfirmasi"><i class="fa fa-dollar"></i> Konfirmasi Pembayaran</a></li>
					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="../keluar.php?key=<?=$_SESSION['idpengguna'];?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div>
		</nav>

		<?php
		if(isset($_GET['hal'])){
			include $_GET['hal'].".php";
		}else{
			include 'home.php';
		}
		?>
		<script>
	    $(function () {
	      $("#tbl,#tbl2").DataTable({
	        "pageLength": 50,
	        "scrollX": true
	      });
	    });
	    </script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 		<script src="Hello World"></script>
	</body>
</html>
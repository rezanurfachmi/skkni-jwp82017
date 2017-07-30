<?php 
session_start(); 
include 'db.php';
$db = new Database;
$db->connect();
?><!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Toklat - Toko Cokelat</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/crulean-bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

		<style type="text/css">
			body {
			  padding-top: 70px;
			}

		</style>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->


		<!-- jQuery -->
		<script src="js/jquery-1.11.1.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="js/bootstrap.min.js"></script>

	    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
	    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

	</head>
	<body class="container-fluid">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
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
							<?php
							$kt = new Database;
							$kt->connect();
							$kt->select('kategori');
							$dkt = $kt->getResult();
							foreach($dkt as $dkt){ ?>
								<li><a href="?hal=kategori&id=<?=$dkt['idkategori'];?>"><?=$dkt['kategori'];?> Cake</a></li>
							<?php } ?>
					</ul>

					<!--<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Cari Kue">
						</div>
						<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Cari</button>
					</form>-->

					<ul class="nav navbar-nav navbar-right">
						<?php if(!isset($_SESSION['idpengguna'])){ ?>
						<li><a href="?hal=masuk"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Masuk</a></li>
						<?php }else{ ?>
						<?php
						// temukan jumlah pesanan yang belum dibayar
						$by = new Database;
						$by->connect();
						$idbio = $_SESSION['idbiodata'];
						$by->select('pesan','*',null,"idbiodata='$idbio' and konfirmasi='0' and hapus='0'");
						$jb = $by->numRows();
						?>
						<li><a href="?hal=order"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> <?=$jb;?> Pesanan</a></li>
						<li><a href="keluar.php?key=<?=$_SESSION['idpengguna'];?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
						<?php } ?>
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

		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title">Hubungi Toklat</h3>
							</div>
							<div class="panel-body">
								<p><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Pondok Pesantren La Tansa</p>
								<p>Parakansantri, Lebakgedong, Lebak-Banten 42372</p>
								<p><i class="fa fa-phone"></i> (0252) 204334</p>
								<p><i class="fa fa-envelope"></i> sekretariat@latansa.sch.id</p>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title">Tentang Toklat</h3>
							</div>
							<div class="panel-body">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque euismod elementum pretium. Morbi eget accumsan urna. Curabitur faucibus eros non auctor consectetur. Nam gravida ex sapien, at tincidunt ex consequat ac. Duis ac pharetra nisl. Curabitur libero eros, egestas eget odio nec, efficitur iaculis lorem. Lorem ipsum dolor sit amet. 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 		<script src="Hello World"></script>
	</body>
</html>
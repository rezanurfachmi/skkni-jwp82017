<?php
// temukan jumlah pesanan yang belum dibayar
$by = new Database;
$by->connect();
$by->select('pesan','*',null,"verifikasi='0' and hapus='0'");
$jb = $by->numRows();
?>
<h1>Hello, Administrator!</h1>
<h3>Kamu memiliki <?=$jb;?> pesanan menunggu. <a href="?hal=pesanan" class="btn btn-danger btn-xs"><i class="fa fa-search"></i> Lihat</a></h3>
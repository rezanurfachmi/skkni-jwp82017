<h1>Konfirmasi Pembayaran</h1>
<?php
// Memeriksa keadaan produk
if(isset($_GET['id'])){
	echo "Processing...";
	// cek keberadaan produk
	$id = $db->escapeString(trim($_GET['id']));
	$db->select('konfirmasi','*',null,"idkonfirmasi='$id'");
	$j = $db->numRows();
	if($j<=0){
		eksyen('Maaf, data tidak tersedia','?hal=konfirmasi');
	}

	$d = $db->getResult();

	$idpesan = $d[0]['idpesan'];
	$db->update('pesan',array('verifikasi'=>'1','konfirmasi'=>'2','usrupd'=>$_SESSION['idpengguna'],'dtmupd'=>wkt()),"idpesan='$idpesan'");
	$db->update('konfirmasi',array('oke'=>'1','usrupd'=>$_SESSION['idpengguna'],'dtmupd'=>wkt()),"idkonfirmasi='$id'");
	eksyen('','?hal=konfirmasi');

}

// menghapus konfirmasi
if(isset($_GET['inv'])){
	echo "Processing...";
	// cek keberadaan produk
	$id = $db->escapeString(trim($_GET['inv']));
	$db->select('konfirmasi','*',null,"idkonfirmasi='$id'");
	$j = $db->numRows();
	if($j<=0){
		eksyen('Maaf, data tidak tersedia','?hal=konfirmasi');
	}

	$d = $db->getResult();

	$idpesan = $d[0]['idpesan'];
	$db->update('pesan',array('verifikasi'=>'0','konfirmasi'=>'0','usrupd'=>$_SESSION['idpengguna'],'dtmupd'=>wkt()),"idpesan='$idpesan'");
	$db->delete('konfirmasi',"idkonfirmasi='$id'");
	eksyen('','?hal=konfirmasi');

}
?>
<table class="table table-hover table-bordered" id="tbl">
	<thead>
		<tr>
			<th class="col-md-1 text-center">No</th>
			<th class="col-md-2 text-center">Bank Pengirim</th>
			<th>Nama Pengirim</th>
			<th class="col-md-2 text-center">Jumlah</th>
			<th class="col-md-1 text-center">Bukti</th>
			<th class="col-md-1 text-center">Konfirmasi</th>
			<th class="col-md-1 text-center">Invalid</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	$db->select('konfirmasi','*',null,null,"oke asc");
	$d =  $db->getResult();
	foreach($d as $d){ ?>
		<tr>
			<td class="text-center"><?=$i++;?></td>
			<td><?=$d['bank'];?></td>
			<td><?=$d['pengirim'];?></td>
			<td class="text-center">Rp.<?=number_format($d['jumlah']);?></td>
			<td class="text-center"><a href="?hal=bukti&id=<?=$d['idkonfirmasi'];?>" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> Lihat</a></td>
			<td class="text-center">
				<?php if($d['oke']=='0'){ ?>
				<a href="?hal=konfirmasi&id=<?=$d['idkonfirmasi'];?>" class="btn btn-success btn-block btn-xs"><i class="fa fa-check"></i> Konfirmasi</a>
				<?php }else{ echo "Oke"; } ?>
			</td>
			<td class="text-center">
				<?php if($d['oke']=='0'){ ?>
				<a href="?hal=konfirmasi&inv=<?=$d['idkonfirmasi'];?>" class="btn btn-danger btn-xs" <?=yakin();?>><i class="fa fa-remove"></i> Batal</a>
				<?php }else{ echo "Oke"; } ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
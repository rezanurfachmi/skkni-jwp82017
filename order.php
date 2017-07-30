<?php
// Pembatasan Pemesanan
// Harus login terlebih dahulu
if(!isset($_SESSION['idpengguna'])){
	eksyen('Maaf, Anda harus login terlebih dahulu','?hal=masuk');
}
?>
<h1>Pemesanan</h1>
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th class="col-md-1 text-center">No</th>
			<th>Nama Kue</th>
			<th class="col-md-2">Total</th>
			<th class="col-md-2">Tanggal</th>
			<th class="col-md-1 text-center">Detail</th>
			<th class="col-md-1 text-center">Konfirmasi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$idbiodata = $_SESSION['idbiodata'];
	$db->select('pesan','*',null,"idbiodata='$idbiodata' and hapus='0' and konfirmasi!='2'","dtmcrt desc");
	$d = $db->getResult();
	$i = 1;
	foreach($d as $d){ ?>
		<tr>
			<td class="text-center"><?=$i++;?></td>
			<td><?=konvert('produk','idproduk',$d['idproduk'],'nama');?></td>
			<td>Rp.<?=number_format($d['total']);?></td>
			<td><?=TanggalIndo($d['dtmcrt']);?></td>
			<td class="text-center">
				<?php if($d['verifikasi']=='0'){ ?>
				<a href="?hal=dorder&id=<?=$d['idpesan'];?>" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> Ubah</a>
				<?php }else{ ?>
				<a href="?hal=deorder&id=<?=$d['idpesan'];?>" class="btn btn-primary btn-xs"><i class="fa fa-search"></i> Detail</a>
				<?php } ?>
			</td>
			<td class="text-center">
				<?php if($d['konfirmasi']=='0'){ ?>
				<a href="?hal=konfirmasi&id=<?=$d['idpesan'];?>" class="btn btn-danger btn-xs btn-block">Konfirmasi</a>
				<?php 
				}elseif($d['konfirmasi']=='1'){ 
					echo "Menunggu"; 
				}
				?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<h1>Histori Pemesanan</h1>
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th class="col-md-1 text-center">No</th>
			<th>Nama Kue</th>
			<th class="col-md-2">Total</th>
			<th class="col-md-2">Tanggal</th>
			<th class="col-md-1">Status</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$idbiodata = $_SESSION['idbiodata'];
	$db->select('pesan','*',null,"idbiodata='$idbiodata' and konfirmasi='2' and verifikasi='1' or idbiodata='$idbiodata' and hapus='1'");
	$d = $db->getResult();
	$i = 1;
	$jumlah = 0; //inisiasi total jumlah pemesanan yang telah dilakukan
	foreach($d as $d){ 
		$harga = ($d['hapus']=='1') ? "0" : $d['total'];
		$jumlah = $jumlah + $harga;
		?>
		<tr>
			<td class="text-center"><?=$i++;?></td>
			<td><?=konvert('produk','idproduk',$d['idproduk'],'nama');?></td>
			<td>Rp.<?=number_format($d['total']);?></td>
			<td><?=TanggalIndo($d['dtmcrt']);?></td>
			<td>
				<?php
				if($d['hapus']=='1'){
					echo "Batal";
				}else{
					echo "Dibayar";
				}
				?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2"></td>
			<td colspan="3"><strong>Rp.<?=number_format($jumlah);?></strong></td>
		</tr>
	</tfoot>
</table>
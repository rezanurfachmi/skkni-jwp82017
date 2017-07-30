<?php
if(!isset($_GET['id'])){
    eksyen('','index.php');
}else{
    // cek keberadaan kategori
    $id = $db->escapeString(trim($_GET['id']));
    $db->select('kategori','*',null,"idkategori='$id'");
    $j = $db->numRows();
    if($j<=0){
        eksyen('Maaf, kategori tidak tersedia','index.php');
    }

    $d = $db->getResult();
}
?>
<style type="text/css">
.stepwizard-step p {
    margin-top: 10px;    
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;     
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;
    
}

.stepwizard-step {    
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
</style>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h1 class="panel-title"><?=$d[0]['kategori'];?></h1>
    </div>
</div>

<div class="row text-center">

    <?php
    $db->select('produk','*',null,"hapus='0' and idkategori='$id'","dtmcrt desc");
    $d = $db->getResult();
    foreach($d as $d){ ?>

    <div class="col-md-3 col-sm-6 hero-feature">
        <div class="thumbnail">
            <a href="?hal=detail&id=<?=$d['idproduk'];?>"><img src="web/<?=$d['gambar'];?>" alt="" class="img-responsive"></a>
            <div class="caption">
                <a href="?hal=detail&id=<?=$d['idproduk'];?>"><h3><?=$d['nama'];?></h3></a>
                <p>Kue <?=konvert('kategori','idkategori',$d['idkategori'],'kategori');?></p>
                <p>Rp.<?=number_format($d['harga']);?></p>
                <p>
                    <a href="?hal=pesan&id=<?=$d['idproduk'];?>" class="btn btn-danger">Pesan Sekarang!</a> <a href="?hal=detail&id=<?=$d['idproduk'];?>" class="btn btn-default">Detail</a>
                </p>
            </div>
        </div>
    </div>

    <?php } ?>

</div>
<!-- /.row -->
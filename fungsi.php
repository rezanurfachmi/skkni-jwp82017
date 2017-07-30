<?php debug_backtrace() || die("Forbidden"); ?>
<?php
define("DBHOST","localhost");
define("DBUSER","root");
define("DBPASS", "");
define("DBNAME", "coko");
date_default_timezone_set("Asia/Jakarta");
ini_set("max_execution_time", 0);
$_SESSION['id'] = "c5e0ca31-3849-11e6-8a58-843497738d6e";
function kon(){
	$q = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
	return $q;
}

// costumized definition
define("DENDA", "500");

function konvert($tabel,$tbl,$id,$kolom){
	$q = mysqli_query(kon(),"select $kolom from $tabel where $tbl='$id'");
	$d = mysqli_fetch_array($q);
	return $d[$kolom];
}

function id(){
	$q = mysqli_query(kon(),"select uuid() as id");
	$d = mysqli_fetch_array($q);
	return $d['id'];
}

function sid(){
	$q = mysqli_query(kon(),"select uuid_short() as id");
	$d = mysqli_fetch_array($q);
	return $d['id'];
}

function wkt(){
	$q = mysqli_query(kon(),"select now() as id");
	$d = mysqli_fetch_array($q);
	return $d['id'];
}

function jqui(){
	$c = "<link rel=\"stylesheet\" href=\"plugins/jQueryUI/jquery-ui.min.css\"><script src=\"plugins/jQueryUI/jquery-ui.min.js\"></script>";
	return $c;
}

function selisih($tgl){
	$skrg = date('Y-m-d');
	$q = mysqli_query(kon(),"SELECT DATEDIFF('$tgl','$skrg') AS DiffDate");
	$d = mysqli_fetch_array($q);
	return $d['DiffDate'];
}

function sesi($grup){
	if($_SESSION['l'] != $grup){
		echo '<script>window.location.assign("index.php");</script>';
	}
}

function cekbok($a,$b){
	if($a==$b){
		echo "checked";
	}
}

function selek($a,$b){
	if($a==$b){
		echo "selected";
	}
}

function yakin(){
	echo "onClick=\"return confirm('Anda yakin ingin melakukan tindakan ini?');\" ";
}

function eksyen($teks=false,$tujuan){ // buat pindah halaman
	if($teks){
		die("<script>alert('$teks');</script><script>window.location.assign('$tujuan');</script>");
	}else{
		die("<script>window.location.assign('$tujuan');</script>");
	}
}

function tbl_ubah($url){
	echo '<a href="'.$url.'" class="btn btn-info btn-xs" alt="edit" title="edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Ubah</a>';
}

function tbl_lihat($url){
	echo '<a href="'.$url.'" class="btn btn-success btn-xs" alt="view" title="view"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Lihat</a>';
}

function tbl_hapus($url){
	echo '<a href="'.$url.'" class="btn btn-danger btn-xs" onClick="return confirm(\'Anda yakin ingin menghapus data ini?\')"  alt="delete" title="delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Hapus</a>';
}

function tbl_cetak($url){
	echo '<a href="'.$url.'" class="btn btn-primary btn-xs" onClick="return confirm(\'Are you sure to print this item?\')"  alt="print" title="print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>';
}

function hom(){
	if(!isset($_GET['hal'])){
		echo ' class="active"';
	}
}

function aktif(array $id){
	foreach($id as $id){	
		if(isset($_GET['hal'])){
			if($_GET['hal']==$id){
				echo ' class="active"';
			}
		}
	}
}

function laktif(array $id){
  foreach($id as $id){	
	if(isset($_GET['hal'])){
		if($_GET['hal']==$id){
			echo ' active';
		}
	}
  }
}

function tgl($tgl){
	$a = explode(" ", $tgl);
	return $a[0];
}

function tanggal($tgl){
	$date = new DateTime($tgl);
	return $date->format('D, d M Y');	// ('D, d M Y H:i:s');
	//return $date->format('d/m/Y');	// ('D, d M Y H:i:s');
}

function jam($tgl){
	$date = new DateTime($tgl);
	return $date->format('H:i:s');	// ('D, d M Y H:i:s');
}

function TanggalIndo($date){
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);
 
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}

function bln_romawi(){
	$tgl = date("Y-m-d");
	$BulanIndo = array("I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); 
	$bulan = substr($tgl, 5, 2);
	return($BulanIndo[(int)$bulan-1]);
}

function TanggalIndo2($date){
	$date = new DateTime($tgl);
	$date = $date->format('D, d M Y');	// ('D, d M Y H:i:s');

	//$BulanIndo = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des");
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);
 
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}

//function indonesian_date ($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
function indonesian_date ($timestamp = '', $date_format = 'l, j F Y', $suffix = '') {
    if (trim ($timestamp) == '')
    {
            $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
        $timestamp = strtotime ($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
        '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
        '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
        '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/',
        '/November/','/December/',
    );
    $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
        'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
        'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
        'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
        'Oktober','November','Desember',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    return $date;
} 

function time_ago( $date )
{
    if( empty( $date ) )
    {
        return "No date provided";
    }

    $periods = array("detik", "menit", "jam", "hari", "minggu", "bulan", "tahun", "dekade");

    $lengths = array("60","60","24","7","4.35","12","10");

    $now = time();

    $unix_date = strtotime( $date );

    // check validity of date

    if( empty( $unix_date ) )
    {
        return "Bad date";
    }

    // is it future date or past date

    if( $now > $unix_date )
    {
        $difference = $now - $unix_date;
        $tense = "yang lalu";
    }
    else
    {
        $difference = $unix_date - $now;
        $tense = "dari sekarang";
    }

    for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ )
    {
        $difference /= $lengths[$j];
    }

    $difference = round( $difference );

    if( $difference != 1 )
    {
        //$periods[$j].= "s";
        $periods[$j].= "";
    }

    return "$difference $periods[$j] {$tense}";
}
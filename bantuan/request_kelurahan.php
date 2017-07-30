<?php
include '../db.php';
$db = new Database(); $db->connect();
$idkecamatan = $_GET['idkecamatan'];
$db->select('kelurahan','*',null,"idkecamatan='$idkecamatan'","name asc");
$dk = $db->getResult();
echo '<option value="">----- Pilih Kelurahan -----</option>';
foreach ($dk as $dk) {
	echo "<option value=\"".$dk['id']."\">".$dk['name']."</option>\n";
}
?>
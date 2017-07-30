<?php
include '../db.php';
$db = new Database(); $db->connect();
$idkabupaten = $_GET['idkabupaten'];
$db->select('kecamatan','*',null,"idkabupaten='$idkabupaten'","name asc");
$dk = $db->getResult();
echo '<option value="">----- Pilih Kecamatan -----</option>';
foreach ($dk as $dk) {
	echo "<option value=\"".$dk['id']."\">".$dk['name']."</option>\n";
}
?>
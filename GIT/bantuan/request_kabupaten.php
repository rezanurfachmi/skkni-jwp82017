<?php
include '../db.php';
$db = new Database(); $db->connect();
$idprovinsi = $_GET['idprovinsi'];
$db->select('kabupaten','*',null,"idprovinsi='$idprovinsi'","name asc");
$dk = $db->getResult();
echo '<option value="">----- Pilih Kabupaten -----</option>';
foreach ($dk as $dk) {
	echo "<option value=\"".$dk['id']."\">".$dk['name']."</option>\n";
}
?>
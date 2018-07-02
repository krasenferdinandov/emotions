<?php
date_default_timezone_set("Europe/Sofia");
require_once "constantsbg.php";
require_once "db_pass.php";

echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
//echo '<br>ID: ' . $_POST['id'];

$id = $_POST['id'];

$data1 = $pdo->query("SELECT id FROM miniscripts");
$row = $data1->fetch(PDO::FETCH_BOTH);
$m = $row['id'];

for($i = 0; $i<MINISCRIPTS_NUMBER; $i++){
	if(isset($_POST['miniscript'.$i])) {
		$timing = $_POST['time-miniscript' . $i];
		$pdo->exec("INSERT INTO miniscripts2_stat VALUES ($id,$i,'$timing')");
	}
}
echo '<meta http-equiv="Refresh" content="0;exitbg.php?id='.$id.'" />';
//echo '<meta http-equiv="Refresh" content="0;exitbg.php?id='.$id.'" />';
require "end.php";
?>
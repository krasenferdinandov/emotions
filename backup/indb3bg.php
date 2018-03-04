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
		$pdo->exec("INSERT INTO miniscripts_stat VALUES ($id,$i,'$timing')");
	}
}
if(isset($_POST['manag']) && isset($_POST['posi']) && isset($_POST['nega']) && isset($_POST['ambi'])){
	
	$posi = $_POST['posi'];
	$nega = $_POST['nega'];
	$ambi = $_POST['ambi'];
	$manag = $_POST['manag'];
		
	$data = $pdo->query("SELECT * FROM management where id=$manag");
	$r = $data->fetch(PDO::FETCH_BOTH);
		
	$pdo->exec("INSERT INTO id_stat VALUES ($id,$posi,$nega,$ambi,$manag)");
}
echo '<meta http-equiv="Refresh" content="0;statementsbg.php?id='.$id.'" />';
//echo '<meta http-equiv="Refresh" content="0;exitbg.php?id='.$id.'" />';
require "end.php";
?>
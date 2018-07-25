<?php
date_default_timezone_set("Europe/Sofia");
require_once "constants.php";
require_once "db_pass.php";

$data = $pdo->query("SELECT id FROM choice_stat ORDER BY id DESC LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id']+1;

for($a = 0; $a<PHOTOES_NUMBER; $a++){
	if(isset($_POST['label_'.$a])) {
		$label = $_POST['label_'.$a]; 
		$label_timing = $_POST['time-label_'.$a];
		}
		$pdo->exec("INSERT INTO photoes_stat VALUES ($id,$a,'$label','$label_timing');");
	}
$timeStarted = mysql_escape_string($_POST['timeStarted']);
$pdo->exec("INSERT INTO choice_stat VALUES ($id, '$timeStarted', NOW());");

echo '<meta http-equiv="Refresh" content="0;choice.php?id='.$id.'" />';
require "end.php";
?>
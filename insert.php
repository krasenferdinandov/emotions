<?php
date_default_timezone_set("Europe/Sofia");
require_once "constants.php";
require_once "db_pass.php";

$data = $pdo->query("SELECT id FROM emotions_stat ORDER BY id DESC LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
	
$id = $r['id']+1;

for($i = 0; $i<EMOTIONS_NUMBER; $i++){
	if(!isset($_POST['emotion_'.$i])) continue;
	$e_slider = intval($_POST['e_slider_'.$i]);
	validateInt($e_slider);
	$pdo->exec("INSERT INTO emotions_stat VALUES ($id,$i,$e_slider);");
}

for($a = 0; $a<STATES_NUMBER; $a++){
	if(isset($_POST['state_'.$a])){
		$pdo->exec("INSERT INTO states_stat VALUES ($id,$a);");
	}
}
	$timeStarted = mysql_escape_string($_POST['timeStarted']);
	$pdo->exec("INSERT INTO choice_stat VALUES ($id, '$timeStarted', NOW() );");
	
echo '<meta http-equiv="Refresh" content="0;show.php?id='.$id.'" />';
require "end.php";
?>
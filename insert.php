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
	$data = $pdo->query("SELECT domain_id FROM emotions WHERE id=$i");
	$row = $data->fetch(PDO::FETCH_BOTH);
	$timing = $_POST['domaintiming_'.$row['domain_id']];
	//echo $i . ' -> ' . $timing . '<br/>';
	$pdo->exec("INSERT INTO emotions_stat VALUES ($id,$i,$e_slider,'$timing');");
}

for($a = 0; $a<STATES_NUMBER; $a++){
	if(isset($_POST['state_'.$a])){
		$s_slider = intval($_POST['s_slider_'.$a]);
		validateInt($s_slider);
		$timing = $_POST['statestiming_' . $a];
		//echo $a . ' -> ' . $timing . '<br/>';
		$pdo->exec("INSERT INTO states_stat VALUES ($id,$a,$s_slider,'$timing');");
	}
}
for($o = 0; $o<STATIS_NUMBER; $o++){
	if(isset($_POST['stati_'.$o])){
		$timing = $_POST['time-stati_' . $o];
		//echo $o . ' -> ' . $timing . '<br/>';
		$pdo->exec("INSERT INTO statis_stat VALUES ($id,$o,'$timing');");
	}
}

$timeStarted = mysql_escape_string($_POST['timeStarted']);
$pdo->exec("INSERT INTO choice_stat VALUES ($id, '$timeStarted', NOW() );");
	
echo '<meta http-equiv="Refresh" content="0;show.php?id='.$id.'" />';
require "end.php";
?>
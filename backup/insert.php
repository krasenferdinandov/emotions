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

$timeStarted = mysql_escape_string($_POST['timeStarted']);
	if($_POST['choice']== '0') {
		$pdo->exec("INSERT INTO choice_stat VALUES ($id,'0', '$timeStarted', NOW(), NOW() );");
		for($a = 0; $a<STATES_NUMBER; $a++){
			if(isset($_POST['state_'.$a])){
				$pdo->exec("INSERT INTO statis_stat VALUES ($id,$a);");
			}
		}
	echo '<meta http-equiv="Refresh" content="0;showi.php?id='.$id.'" />';
	}
	if($_POST['choice']== '1') {
		$pdo->exec("INSERT INTO choice_stat VALUES ($id,'1','$timeStarted', NOW(), NOW() );");
		for($a = 0; $a<STATES_NUMBER_1; $a++){
			if(isset($_POST['state_'.$a])){
				$pdo->exec("INSERT INTO states_stat VALUES ($id,$a);");
			}
		}
	echo '<meta http-equiv="Refresh" content="0;show.php?id='.$id.'" />';
	}
	if($_POST['choice']== '2') {
		$pdo->exec("INSERT INTO choice_stat VALUES ($id,'2','$timeStarted', NOW(), NOW() );");
		for($a = 0; $a<STATES_NUMBER_2; $a++){
			if(isset($_POST['state_'.$a])){
				$pdo->exec("INSERT INTO statys_stat VALUES ($id,$a);");
			}
		}
	echo '<meta http-equiv="Refresh" content="0;showy.php?id='.$id.'" />';
	}
	if($_POST['choice']== '3') {
		$pdo->exec("INSERT INTO choice_stat VALUES ($id,'3','$timeStarted', NOW(), NOW() );");
		for($t = 0; $t<TRAITS_NUMBER; $t++){
			if(!isset($_POST['trait_'.$t])) continue;
			$pdo->exec("INSERT INTO traits_stat VALUES ($id,$t);");
		}
	echo '<meta http-equiv="Refresh" content="0;showu.php?id='.$id.'" />';
	}
require "end.php";
?>
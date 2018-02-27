<?php
date_default_timezone_set("Europe/Sofia");
require_once "constantsbg.php";
require_once "db_pass.php";
if (array_key_exists('id', $_POST))
	{
	echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
	$id = $_POST['id'];
	} 
echo '<input type="hidden" name="id" value="'.$id.'">';
//echo '<br>Избор: ' . $_POST['choice'];
//echo '<br>ID: ' . $_POST['id'];
echo '<input type="hidden" name="id" value="'.$id.'">';
$timeStarted = mysql_escape_string($_POST['timeStarted']);
	if($_POST['choice']== '1') {
		echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
		//echo 'Начало: '.$_POST['timeStarted'];
		$pdo->exec("INSERT INTO tests_stat VALUES ($id,'1','$timeStarted', NOW());");
		for($a = 0; $a<STATES_NUMBER; $a++){
			if(isset($_POST['stato_'.$a])){
				$timing = $_POST['time-stato_' . $a];
				//echo $a. ' -> ' . $timing . '<br/>';
				$pdo->exec("INSERT INTO statos_stat VALUES ($id,$a,'$timing');");
			}		
		}
	}
	if($_POST['choice']== '2') {
		echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
		//echo 'Начало: '.$_POST['timeStarted'];
		$pdo->exec("INSERT INTO tests_stat VALUES ($id,'2','$timeStarted', NOW());");
		for($a = 0; $a<STATES_NUMBER_1; $a++){
			if(isset($_POST['stati_'.$a])){
				$timing = $_POST['time-stati_' . $a];
				//echo $a. ' -> ' . $timing . '<br/>';
				$pdo->exec("INSERT INTO statis_stat VALUES ($id,$a,'$timing');");
			}
		}
	}
	if($_POST['choice']== '3') {
		echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
		//echo 'Начало: '.$_POST['timeStarted'];
		$pdo->exec("INSERT INTO tests_stat VALUES ($id,'3','$timeStarted', NOW());");
		for($a = 0; $a<STATES_NUMBER_2; $a++){
			if(isset($_POST['staty_'.$a])){
				$timing = $_POST['time-staty_' . $a];
				//echo $a. ' -> ' . $timing . '<br/>';
				$pdo->exec("INSERT INTO statys_stat VALUES ($id,$a,'$timing');");
			}
		}
	}
	if($_POST['choice']== '4') {
		echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
		//echo 'Начало: '.$_POST['timeStarted'];
		$pdo->exec("INSERT INTO tests_stat VALUES ($id,'4','$timeStarted', NOW());");
		for($a = 0; $a<STATES_NUMBER_3; $a++){
			if(isset($_POST['statu_'.$a])){
				$timing = $_POST['time-statu_' . $a];
				//echo $a. ' -> ' . $timing . '<br/>';
				$pdo->exec("INSERT INTO status_stat VALUES ($id,$a,'$timing');");
			}
		}
	
	}
$c = $_POST['choice'];
echo '<input type="hidden" name="choice" value="'.$c.'"/>';
echo '<meta http-equiv="Refresh" content="0;finalbg.php?id='.$id.'&choice=' . $c . '"/>';
require "end.php";
?>
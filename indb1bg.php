<?php
date_default_timezone_set("Europe/Sofia");
require_once "constantsbg.php";
require_once "db_pass.php";

echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
$id = $_POST['id'];
//echo '<br>ID: ' . $_POST['id'];
for($i = 0; $i<EMOTIONS_NUMBER; $i++){
	if(!isset($_POST['emotion_'.$i])) continue;
	$e_slider = intval($_POST['e_slider_'.$i]);
	validateInt($e_slider);
	$data = $pdo->query("SELECT domain_id FROM emotions WHERE id=$i");
	$row = $data->fetch(PDO::FETCH_BOTH);
	$timing = $_POST['domaintiming_'.$row['domain_id']];
	//echo $i . ' -> ' . $timing . '<br/>';
	//echo $i . ' -> ' . $e_slider . '<br/>';
	$pdo->exec("INSERT INTO emotions_stat VALUES ($id,$i,$e_slider,'$timing');");
}
echo '<meta http-equiv="Refresh" content="0;themesbg.php?id='.$id.'" />';
require "end.php";
?>
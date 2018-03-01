<?php
date_default_timezone_set("Europe/Sofia");
require_once "constantsbg.php";
require_once "db_pass.php";

echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
$id = $_POST['id'];
//echo '<br>ID: ' . $_POST['id'];
for($a = 0; $a<STATES_NUMBER; $a++){
	if(isset($_POST['state_'.$a])){
		$g_slider = intval($_POST['g_slider_'.$a]);
		validateInt($g_slider);
		$timing = $_POST['statestiming_' . $a];
		//echo $a . ' -> ' . $timing . '<br/>';
		$pdo->exec("INSERT INTO gros_stat VALUES ($id,$a,$g_slider,'$timing');");
	}
}
echo '<meta http-equiv="Refresh" content="0;exitbg.php?id='.$id.'" />';
require "end.php";
?>
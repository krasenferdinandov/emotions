<?php
date_default_timezone_set("Europe/Sofia");
require_once "constants.php";
require_once "db_pass.php";

echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
$id = $_POST['id'];
//echo '<br>ID: ' . $_POST['id'];
for($a = 0; $a<THEMES_NUMBER; $a++){
	if(isset($_POST['state_'.$a])){
		$s_slider = intval($_POST['s_slider_'.$a]);
		validateInt($s_slider);
		$timing = $_POST['time-state_' . $a];
		//echo $a . ' -> ' . $timing . '<br/>';
		$pdo->exec("INSERT INTO states_stat VALUES ($id,$a,$s_slider,'$timing');");
	}
}
echo '<meta http-equiv="Refresh" content="0;scripts.php?id='.$id.'" />';
require "end.php";
?>
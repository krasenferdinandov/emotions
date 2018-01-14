<?php
require "header.php"; 
echo '<form method="POST" action="statiments.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
if (array_key_exists('timeStarted', $_POST))
	{
		echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
	} 
	else
	{
		redirect ('http://testrain.info/emotions.php');
	}
echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
//echo 'Started at: '.$_POST['timeStarted'];
	$table = '<center>';
	$table .= '<table>';
	$table .= '<tr>';
	$table .= '<th colspan="5"><p><center>'.HOW_LONG.'<center/></th>';
	echo '<input type="hidden" value="1" name="choice"/>';
	$table .= '</tr>';
	
for($i = 0; $i<DOMAINS_NUMBER; $i++)
	{
		if(!isset($_POST['domaintiming_'.$i])) continue;
		$timing = $_POST['domaintiming_'.$i];
		//echo $i . ' -> ' . $timing . '<br/>';
		echo '<input type="hidden" value="'.$timing.'" name="domaintiming_'.$i.'"/>';
	}
	
for($i = 0; $i<EMOTIONS_NUMBER; $i++){
	if(!isset($_POST['emotion_'.$i])) continue;
	$e_slider=$_POST['e_slider_'.$i];
	echo '<input type="hidden" value="1" name="emotion_'.$i.'"/>';
	echo '<input type="hidden" value="'.$e_slider.'" name="e_slider_'.$i.'"/>';
}
$count=0;
for($a = 0; $a<STATES_NUMBER; $a++){
	if(!isset($_POST['state_'.$a])) continue;
		$data = $pdo->query("SELECT bg_name, en_name FROM statements WHERE id=$a");
		$result=$data->fetch(PDO::FETCH_BOTH);
		$count+=1;
		$table .= '<tr>';
		$en_name = $result['en_name'];
		$table .= '<tr><td><a title="'.$result['bg_name'].'"><b>'.quot($en_name).'<b/></a></td>';
		$table .= '<td>'.LITTLE.'</td>';
		$table .= '<td class="slider_text"></td>';
		$timing = $_POST['time-state_' . $a];
		// echo $a . ' -> ' . timing . '<br/>';
		echo '<input type="hidden" value="'.$timing.'" name="statestiming_'.$a.'"/>';
		$table .= '<input type="hidden" value="1" name="state_'.$a.'"/>';
		$table .= '<td><input type="range" name="s_slider_'.$a.'" class="s_slider" value="1" min="1" max="10" step="1" onchange="showNums()"/></td>';
		$table .= '<td>'.VERY.'</td>';
		$table .= '</tr>';	
}
$table .= '<tr><td colspan="5"><p align="center"><input type="submit" value="'.NEXT.'"/></td></tr></table></p>';
echo $table;
echo '</form>';	
require_once('js/numbers.js');
echo '<script src="js/refreshBack.js"></script>';
echo '<script>refreshBack("emotionsbg.php")</script>';
require "end.php";
?>
<?php
	require "headerbg.php"; 
	//echo 'Started at: '.$_POST['timeStarted'];
	echo '<form method="POST" action="statementsbg.php" enctype="multipart/form-data">';
	if (array_key_exists('timeStarted', $_POST))
	{
		echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
	} 
	else
	{
		redirect ('http://testrain.info/emotions.php');
	}
	$table = '<center>';
	$table .= '<table>';
	$table .= '<tr>';
	$table .= '<th colspan="5">'.HOW_FAST.'</th>';
	echo '<input type="hidden" value="1" name="choice"/>';
	$table .= '</tr>';

	for($i = 0; $i<DOMAINS_NUMBER; $i++)
	{
		if(!isset($_POST['time-' . $i])) continue;
		$timing = $_POST['time-' . $i];
		//echo $i . ' -> ' . $timing . '<br/>';
		echo '<input type="hidden" value="'.$timing.'" name="domaintiming_'.$i.'"/>';
		
	}
	$count=0;
	for($i = 0; $i<EMOTIONS_NUMBER; $i++)
	{
		//if(!isset($_POST['emotion_'.$i])) continue;
		$data2 = $pdo->query("SELECT domain_id FROM emotions WHERE id=$i");
		$result2 = $data2 -> fetch(PDO::FETCH_BOTH);
		$domain = $result2['domain_id'];
		
		if(!isset($_POST[$domain])) continue;
		if($_POST[$domain] != $i) continue;
		$count+=1;
		$data = $pdo->query("SELECT bg_name, en_name FROM emotions WHERE id=$i");
		$result=$data->fetch(PDO::FETCH_BOTH);

		$table .= '<tr>';
		$en_name = $result['en_name'];
		$table .= '<tr><td><a title="'.quot($en_name).'"><b>'.$result['bg_name'].'</a><b/></td>';
		$table .= '<td>'.FASTEST.'</td>';
		$table .= '<td class="slider_text"></td>';
		$table .= '<input type="hidden" value="1" name="emotion_'.$i.'"/>';
		$table .= '<td><input type="range" name="e_slider_'.$i.'" class="e_slider" value="1" min="1" max="10" step="1" onchange="showNums()"/></td>';
		$table .= '<td>'.SLOWEST.'</td>';
		$table .= '</tr>';
	}
	//if($count>=2 && $count<=6) {
	if($count>=2) {
		$table .= '<tr><td colspan="5"><p align="center"><input type="submit" value="'.NEXT.'"/></td></tr></table></p>';
		echo $table;
	}else{
		echo NOT_ENOUGH_OR_TOO_MANY;
	}
	echo '</form>';	
require_once('js/numbers.js');
echo '<script src="js/refreshBack.js"></script>';
echo '<script>refreshBack("emotionsbg.php")</script>';
require "end.php";
?>
<?php
require "header.php"; 
//echo 'Started at: '.$_POST['timeStarted'];
echo '<form method="POST" action="statements.php" enctype="multipart/form-data">';
	echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
	$table = '<center>';
	$table .= '<table>';
	$table .= '<tr>';
	$table .= '<th colspan="5"><p><center>'.HOW_FAST.'<center/></th>';
	//$table .= '<th>'.EMOTION.'</th>';
	echo '<input type="hidden" value="1" name="choice"/>';
	
	$table .= '</tr>';

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
		$table .= '<tr><td><a title="'.$result['bg_name'].'"><b>'.quot($en_name).'<b/></a></td>';
		$table .= '<td>'.FASTEST.'</td>';
		$table .= '<td class="slider_text"></td>';
		$table .= '<input type="hidden" value="1" name="emotion_'.$i.'"/>';
		$table .= '<td><input type="range" name="e_slider_'.$i.'" class="e_slider" value="1" min="1" max="10" step="1" onchange="showNums()"/></td>';
		$table .= '<td>'.SLOWEST.'</td>';
		$table .= '</tr>';	
	}
	/*$table .= '<tr><td colspan="5"><p align="center"><input type="submit" value="'.NEXT.'"/></td></tr></table></p>';
	echo $table;
	echo '</form>';
	require_once('js/numbers.js');*/
	
	//if($count>=2 && $count<=6) {
	if($count>=2) {
		$table .= '<tr><td colspan="5"><p align="center"><input type="submit" value="'.NEXT.'"/></td></tr></table></p>';
		echo $table;
	}else{
		echo NOT_ENOUGH_OR_TOO_MANY;
	}
	echo '</form>';	
require_once('js/numbers.js');
require "end.php";
?>
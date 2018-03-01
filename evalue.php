<?php
require "header.php"; 
echo '<form method="POST" action="indb4.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
if (array_key_exists('id', $_POST))
	{
		echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
		//echo '<br>ID: ' . $_POST['id'];
	} 
	$table = '<center>';
	$table .= '<table>';
	$table .= '<tr>';
	$table .= '<th colspan="5"><p><center><b>LAST STEP:</b><br/><b>How often do you do that?</b><center/></th>';
	$table .= '</tr>';
	
$count=0;
for($a = 0; $a<STATES_NUMBER; $a++){
	if(!isset($_POST['state_'.$a])) continue;
		$data = $pdo->query("SELECT bg_name, en_name FROM gros WHERE id=$a");
		$result=$data->fetch(PDO::FETCH_BOTH);
		$count+=1;
		$table .= '<tr>';
		$en_name = $result['en_name'];
		$table .= '<tr>';
		$table .= '<td>Seldom</td>';
		$timing = $_POST['time-state_' . $a];
		// echo $a . ' -> ' . timing . '<br/>';
		echo '<input type="hidden" value="'.$timing.'" name="statestiming_'.$a.'"/>';
		$table .= '<input type="hidden" value="1" name="state_'.$a.'"/>';
		$table .= '<td><input type="range" name="g_slider_'.$a.'" class="g_slider" value="1" min="1" max="7" step="1" onchange="showNums()"/></td>';
		$table .= '<td>Always</td>';
		$table .= '<td class="slider_text"></td>';
		$table .= '<td><a title="'.$result['bg_name'].'">'.quot($en_name).'</a></td>';
		
		$table .= '</tr>';
}
$table .= '<tr><td colspan="5"><p align="center"><input type="submit" value="'.NEXT.'"/></td></tr></table></p>';
echo $table;
echo '</form>';	
require_once('js/numbers.js');
require "end.php";
?>
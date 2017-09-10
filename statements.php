<?php
require "header.php";
echo '<form method="POST" action="value.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
//echo 'Начало: '.$_POST['timeStarted'];
$table = '';
$table .= '<table>';
echo '<center><table class="borders"><tr>';
$table .= '</tr>';

if($_POST['choice'] == '1') {
		echo '<input type="hidden" value="1" name="choice"/>';
		echo '<p>'.CHOOSE_STATES . '<br/>';
	}
	
for($i = 0; $i<EMOTIONS_NUMBER; $i++){
	if(!isset($_POST['emotion_'.$i])) continue;
	$e_slider=$_POST['e_slider_'.$i];
	echo '<input type="hidden" value="1" name="emotion_'.$i.'"/>';
	echo '<input type="hidden" value="'.$e_slider.'" name="e_slider_'.$i.'"/>';
}

echo '<table class="borders">';
$data = $pdo->query("SELECT * FROM statements");
while($row = $data->fetch(PDO::FETCH_BOTH)){
	$id=$row["id"];
	$bg_name=$row["bg_name"];
	$en_name=$row["en_name"];
		//echo '<tr><td><input id="checkit'.$id.'" type="radio" name="state_'.$id.'" value="1"></td>';
		echo '<tr><td><input id="checkit'.$id.'" type="checkbox" name="state_'.$id.'" value="1"></td>';
		echo '<td><a title="'.quot($bg_name).'"><p><label for="checkit'.$id.'">'.$en_name.'</a></label></td></tr>';
		
		//За показване на Id на тъврдението.
		//echo '<td><a title="'.quot($en_name).'">№'.$id.' '.$bg_name.'</a></td></tr>';
		/*echo '<tr><td><input type="checkbox" name="state_'.$id.'" value="1"></td>';
		echo '<td><a title="'.quot($en_name).'">'.$bg_name.'</a></td></tr>';*/
	}

$table .= '<tr><td><p><input type="submit" value="'.NEXT.'"/></td></tr></table>';
echo $table;
require "end.php";	
?>
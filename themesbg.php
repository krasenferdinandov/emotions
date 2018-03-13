<?php
require "headerbg.php";
echo '<form id="the_form" method="POST" action="indb2bg.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
if (array_key_exists('id', $_POST))
	{
		echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
		//echo '<br>ID: ' . $_POST['id'];
	} 
$table = '';
$table .= '<table>';
echo '<center>';
$table .= '</tr>';
echo '<p><b>ТРЕТА СТЪПКА:</b><br/>'.CHOOSE_STATES . '</center>';
echo '<center style="position: absolute; left: 40%; text-align: left;">';

for($i = 0; $i<DOMAINS_NUMBER; $i++)
	{
		if(!isset($_POST['time-' . $i])) continue;
		$timing = $_POST['time-' . $i];
		//echo $i . '->' . $timing . '<br/>';
		echo '<input type="hidden" value="'.$timing.'" name="domaintiming_'.$i.'"/>';
	}
	
for($i = 0; $i<EMOTIONS_NUMBER; $i++){
	if(!isset($_POST['e_slider_'.$i])) continue;
	$e_slider=$_POST['e_slider_'.$i];
	//echo $i . ':' . $e_slider . '<br/>';
	echo '<input type="hidden" value="1" name="emotion_'.$i.'"/>';
	echo '<input type="hidden" value="'.$e_slider.'" name="e_slider_'.$i.'"/>';
}
echo '<table class="borders">';
$data = $pdo->query("SELECT * FROM statements");
while($row = $data->fetch(PDO::FETCH_BOTH)){
	$id=$row["id"];
	$bg_name=$row["bg_name"];
	$en_name=$row["en_name"];
	echo '<p><input style="display: inline;" class="timed for_slider" id="checkit'.$id.'" type="checkbox" name="state_'.$id.'" value="1" onchange="toggle_slider (' . $id . ');">';
	echo '<a title="'.quot($en_name).'"><label for="checkit'.$id.'">'.$bg_name.'</label></p>';
	echo '<table class="borders"><tr><td style="font-weight: bold; text-align:center; width: 20px; display: none;" data-for="s_slider_' . $id . '" ></td>';
	echo '<td style="display: none;" data-label="s_slider_' . $id . '">Незначително</td>';
	echo '<td style="display: none;" data-for="checkit' . $id . '"></td>';
	echo '<td style="display: none;" data-label="s_slider_' . $id . '">Напълно</td></tr></table>';
}
$table .= '<tr><td><p><input type="submit" value="'.NEXT.'"/></td></tr></table>';
echo $table;
echo '<script src="js/add_slider.js"></script>';
echo '<script src="js/collectTiming.js"></script>';
require "js/numbers.js";
require "end.php";	
?>
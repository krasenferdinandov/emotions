<?php
require "headerbg.php";
echo '<form id="the_form" method="POST" action="indb2bg.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
if (array_key_exists('id', $_POST))
	{
		echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
		//echo '<br>ID: ' . $_POST['id'];
	} 
	/*else
	{
		redirect ('photoesbg.php');
	}*/
$table = '';
$table .= '<table>';
echo '<center><table class="borders"><tr>';
$table .= '</tr>';
echo '<p><b>ЧЕТВЪРТА СТЪПКА:</b><br/>'.CHOOSE_STATES . '<br/>';

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
echo '<table class="borders">';
$data = $pdo->query("SELECT * FROM statements");
while($row = $data->fetch(PDO::FETCH_BOTH)){
	$id=$row["id"];
	$bg_name=$row["bg_name"];
	$en_name=$row["en_name"];
	echo '<tr><td><input class="timed for_slider" id="checkit'.$id.'" type="checkbox" name="state_'.$id.'" value="1" onchange="toggle_slider (' . $id . ');"></td>';
	echo '<td><a title="'.quot($en_name).'"><p><label for="checkit'.$id.'">'.$bg_name.'</p></a></label></td>';
	echo '<td style="font-weight: bold; text-align:center; width: 20px; display: none;" data-for="s_slider_' . $id . '" ></td>';
	echo '<td style="display: none;" data-label="s_slider_' . $id . '">Слабо</td>';
	echo '<td style="display: none;" data-for="checkit' . $id . '"></td>';
	echo '<td style="display: none;" data-label="s_slider_' . $id . '">Напълно</td></tr>';
}
$table .= '<tr><td><p><input type="submit" value="'.NEXT.'"/></td></tr></table>';
echo $table;
echo '<script src="js/add_slider.js"></script>';
echo '<script src="js/collectTiming.js"></script>';
require "js/numbers.js";
//echo '<script src="js/refreshBack.js"></script>';
//echo '<script>refreshBack("photoesbg.php")</script>';
require "end.php";	
?>
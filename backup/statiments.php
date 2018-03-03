<?php
require "header.php";
echo '<form id="the_form" method="POST" action="insert.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
if (array_key_exists('timeStarted', $_POST))
	{
		echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
	} 
	else
	{
		redirect ('http://testrain.info/emotions.php');
	}
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
for($a = 0; $a<STATES_NUMBER; $a++){
	if(!isset($_POST['state_'.$a])) continue;
	$s_slider=$_POST['s_slider_'.$a];
	$timing = $_POST['statestiming_' . $a];
	//echo $a . ' -> ' . $timing . '<br/>';
	echo '<input type="hidden" value="'.$timing.'" name="statestiming_'.$a.'"/>';
	echo '<input type="hidden" value="1" name="state_'.$a.'"/>';
	echo '<input type="hidden" value="'.$s_slider.'" name="s_slider_'.$a.'"/>';
}

echo '<table class="borders">';
$data = $pdo->query("SELECT * FROM statiments");
while($row = $data->fetch(PDO::FETCH_BOTH)){
	$id=$row["id"];
	$bg_name=$row["bg_name"];
	$en_name=$row["en_name"];
		echo '<tr><td><input class="timed" id="checkit'.$id.'" type="checkbox" name="stati_'.$id.'" value="1"></td>';
		echo '<td><a title="'.quot($bg_name).'"><p><label for="checkit'.$id.'">'.$en_name.'</a></label></td></tr>';
	}

$table .= '<tr><td><p><input type="submit" value="'.NEXT.'"/></td></tr></table>';
echo $table;
echo '<script src="js/collectTiming.js"></script>';
echo '<script src="js/refreshBack.js"></script>';
echo '<script>refreshBack("emotionsbg.php")</script>';
require "end.php";		
?>
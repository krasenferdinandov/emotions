<?php
require "header.php";
echo '<form id="the_form" method="POST" action="indb5.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
if (array_key_exists('id', $_POST))
	{
	echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
	//echo '<br>ID: ' . $_POST['id'];
	$id = $_POST['id'];
	}
else if (array_key_exists('id', $_GET))
	{
	echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
	//echo '<br>ID: ' . $_POST['id'];
	$id = $_GET['id'];
	}
	/*else
	{
		redirect ('photoes.php');
	}*/
$table = '';
$table .= '<table>';
echo '<center><table class="borders"><tr>';
$table .= '</tr>';
echo '<p><b>THE LAST STEP:</b><br/><b>Choose only these sentences, which most accuratly describe your behavior.</b><br/>';

echo '<table class="borders">';
$data = $pdo->query("SELECT * FROM gros");
while($row = $data->fetch(PDO::FETCH_BOTH)){
	$id=$row["id"];
	$bg_name=$row["bg_name"];
	$en_name=$row["en_name"];
	echo '<tr><td><input class="timed for_slider" id="checkit'.$id.'" type="checkbox" name="state_'.$id.'" value="1" onchange="toggle_slider (' . $id . ');"></td>';
	echo '<td colspan="2"><a title="'.quot($bg_name).'"><p><label for="checkit'.$id.'">'.$en_name.'</p></a></label></td></tr>';
	echo '<tr><td style="font-weight: bold; text-align:center; width: 20px; display: none;" data-for="s_slider_' . $id . '" ></td>';
	echo '<td colspan="3"><table><tr><td style="display: none;" data-label="s_slider_' . $id . '">Barely</td>';
	echo '<td style="display: none;" data-for="checkit' . $id . '"></td>';
	echo '<td style="display: none;" data-label="s_slider_' . $id . '">Completely</td></tr></table></tr>';
}
$table .= '<tr><td><p><input type="submit" value="Confirm"/></td></tr></table>';
echo $table;
echo '<script src="js/add_slider.js"></script>';
echo '<script src="js/collectTiming.js"></script>';
require "js/numbers.js";
//echo '<script src="js/refreshBack.js"></script>';
//echo '<script>refreshBack("photoes.php")</script>';
require "end.php";	
?>
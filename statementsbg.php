<?php
require "headerbg.php";
echo '<form id="the_form" method="POST" action="evaluebg.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
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
		redirect ('photoesbg.php');
	}*/
$table = '';
$table .= '<table>';
echo '<center><table class="borders"><tr>';
$table .= '</tr>';
echo '<p><b>СЕДМА СТЪПКА:</b><br/><b>Избери тези изречения, които най-точно съответстват на поведението ти.</b><br/>';

echo '<table class="borders">';
$data = $pdo->query("SELECT * FROM gros");
while($row = $data->fetch(PDO::FETCH_BOTH)){
	$id=$row["id"];
	$bg_name=$row["bg_name"];
	$en_name=$row["en_name"];
		echo '<tr><td><input class="timed" id="checkit'.$id.'" type="checkbox" name="state_'.$id.'" value="1"></td>';
		echo '<td><a title="'.quot($en_name).'"><p><label for="checkit'.$id.'">'.$bg_name.'</a></label></td></tr>';
		//За показване на Id на тъврдението.
		//echo '<td><a title="'.quot($en_name).'">№'.$id.' '.$bg_name.'</a></td></tr>';
		/*echo '<tr><td><input type="checkbox" name="state_'.$id.'" value="1"></td>';
		echo '<td><a title="'.quot($en_name).'">'.$bg_name.'</a></td></tr>';*/
	}
$table .= '<tr><td><p><input type="submit" value="'.NEXT.'"/></td></tr></table>';
echo $table;
echo '<script src="js/collectTiming.js"></script>';
//echo '<script src="js/refreshBack.js"></script>';
//echo '<script>refreshBack("photoesbg.php")</script>';
require "end.php";	
?>
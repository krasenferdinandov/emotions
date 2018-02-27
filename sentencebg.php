<?php
require "headerbg.php";
echo '<form method="POST" id="the_form" action="insrtbg.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
if (array_key_exists('id', $_POST))
	{
	echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
	$id = $_POST['id'];
	} 
echo '<input type="hidden" name="id" value="'.$id.'">';
echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
//echo 'Начало: '.$_POST['timeStarted'];
//echo '<br>Избор: ' . $_POST['choice'];
//echo '<br>ID: ' . $_POST['id'];
//$table = '';
$table = '<table>';
echo '<center><table class="borders"><tr>';
if(isset($_POST['choice'])){
	if($_POST['choice'] == '1') {
		echo '<b>ВТОРА СТЪПКА:<br></b>'.CHOOSE_STATIS . '';
		echo '<input type="hidden" value="1" name="choice"/>';
		echo '<table class="borders">';
		$data = $pdo->query("SELECT * FROM statoments");
		while($row = $data->fetch(PDO::FETCH_BOTH)){
			$id=$row["id"];
			$bg_name=$row["bg_name"];
			$en_name=$row["en_name"];
		echo '<tr><td><br><input class="timed" id="checkit'.$id.'" type="checkbox" name="stato_'.$id.'" value="1"></td>';
		echo '<td><br><a title="'.quot($en_name).'"><label for="checkit'.$id.'">'.$bg_name.'</a></label></td></tr>';
		}
		echo '<input type="hidden" value="1" name="choice"/>';
		echo $table;
		}
	else if($_POST['choice'] == '2') {
			echo '<b>ВТОРА СТЪПКА:<br></b>'.CHOOSE_STATIS . '';
			echo '<input type="hidden" value="2" name="choice"/>';
		echo '<table class="borders">';
		$data = $pdo->query("SELECT * FROM statiments");
		while($row = $data->fetch(PDO::FETCH_BOTH)){
			$id=$row["id"];
			$bg_name=$row["bg_name"];
			$en_name=$row["en_name"];
		echo '<tr><td><br><input class="timed" id="checkit'.$id.'" type="checkbox" name="stati_'.$id.'" value="1"></td>';
		echo '<td><br><a title="'.quot($en_name).'"><label for="checkit'.$id.'">'.$bg_name.'</a></label></td></tr>';
		
			}
		echo '<input type="hidden" value="2" name="choice"/>';
		echo $table;
		}
	else if($_POST['choice'] == '3') {
			echo '<b>ВТОРА СТЪПКА:<br></b>'.CHOOSE_STATIS . '';
			echo '<input type="hidden" value="3" name="choice"/>';
		echo '<table class="borders">';
		$data = $pdo->query("SELECT * FROM statyments");
		while($row = $data->fetch(PDO::FETCH_BOTH)){
			$id=$row["id"];
			$bg_name=$row["bg_name"];
			$en_name=$row["en_name"];
		echo '<tr><td><br><input class="timed" id="checkit'.$id.'" type="checkbox" name="staty_'.$id.'" value="1" ></td>';
		echo '<td><br><a title="'.quot($en_name).'"><label for="checkit'.$id.'">'.$bg_name.'</a></label></td></tr>';
		
			}
		echo '<input type="hidden" value="3" name="choice"/>';
		echo $table;
		}
	else if($_POST['choice'] == '4') {
			echo '<b>ВТОРА СТЪПКА:<br></b>'.CHOOSE_STATIS . '';
			echo '<input type="hidden" value="4" name="choice"/>';
		echo '<table class="borders">';
		$data = $pdo->query("SELECT * FROM statusments");
		while($row = $data->fetch(PDO::FETCH_BOTH)){
			$id=$row["id"];
			$bg_name=$row["bg_name"];
			$en_name=$row["en_name"];
		echo '<tr><td><br><input class="timed" id="checkit'.$id.'" type="checkbox" name="statu_'.$id.'" value="1"></td>';
		echo '<td><br><a title="'.quot($en_name).'"><label for="checkit'.$id.'">'.$bg_name.'</a></label></td></tr>';
		
			}
		echo '<input type="hidden" value="4" name="choice"/>';
		echo $table;
		}
		echo '<br><input id="-1" class="moving" type="submit" value="'.NEXT.'"></form>';
		echo '<script src="js/collectTiming.js"></script>';
	}
else{
		echo NOT_ENOUGH;
	}
require "end.php";	
?>
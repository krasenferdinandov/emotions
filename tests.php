<?php
require "header.php";
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

date_default_timezone_set("Europe/Sofia");
echo '<form method="POST" action="sentence.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
	$timeNow = time();
	$dt = new DateTime();
	$dt->setTimestamp($timeNow);
$table = '<center><table class="borders"><tr><th colspan="2"><b><center>ПЪРВА СТЪПКА:<br>'.CHOOSE. '</br></center></b></th></tr>';
$data = $pdo->query("SELECT * FROM tests_stat WHERE id=$id");
$all_completed = array();
while($r = $data->fetch(PDO::FETCH_BOTH)){
$choice = $r['choice'];
echo 'Вече избрани тестове:'. $choice;
		if (isset ($choice)) {			
					$all_completed[] = $choice;
		}
}
$data = $pdo->query("SELECT * FROM tests_stat WHERE id=$id");
if(count($all_completed) == CHOICE_NUMBER)
{
		redirect ('full.php?id=' . $id . '');
		echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
}
for ($i = 1 ; $i <= CHOICE_NUMBER ; $i ++) {
	$to_add = true;
	foreach($all_completed as $val)
		if (''.$i == $val)
		{
			$to_add = false;
			break;
		}
		if ($to_add)
		{
				if ($i == '1') {
						$table .= '<tr><td colspan="2" align="left"><br><input id="Def" type="radio" name="choice" value="1"><label for="Def">'.CHOOSE_AI.'</label></br>';
				}
				if ($i == '2') {
						$table .= '<tr><td colspan="2" align="left"><br><input id="Style" type="radio" name="choice" value="2"><label for="Style">'.CHOOSE_SELF.'</label></br>';
				}
				if ($i == '3') {
						$table .= '<tr><td colspan="2" align="left"><br><input id="Impact" type="radio" name="choice" value="3"><label for="Impact">'.CHOOSE_IM.'</label></br>';
				}
				if ($i == '4') {
						$table .= '<tr><td colspan="2" align="left"><br><input id="Judging" type="radio" name="choice" value="4"><label for="Judging">'.CHOOSE_ST.'</label></br>';
				}			
		}
		
}
$table .= '<input type="hidden" name="timeStarted" value="'.$dt->format("Y-m-d H:i:s").'">';
$table .= '<p align="center"><input type="submit" value="'.NEXT.'"/></p>';
echo '<input type="hidden" name="id" value="'.$id.'">';
$table .= '</tr>';
echo $table;
//echo '<script src="js/refreshBack.js"></script>';
//echo '<script>refreshBack("exit.php?id='.$id.'")</script>';
require "end.php";
?>
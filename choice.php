<?php
date_default_timezone_set("Europe/Sofia");
require "header.php";
if (array_key_exists('id', $_GET))
	{
		$id = $_GET['id'];
		validateInt($id);
		//echo '<br>ID: ' . $id;
	}
	else
	{
		redirect ('photoes.php');
	}

echo SELECT_EMOTIONS.'<br/>';
echo '<form id="the_form" style="height: 0vh;overflow:auto" method="POST" action="slide.php" enctype="multipart/form-data">';
$data = $pdo->query("SELECT id, bg_name, en_name, domain_id FROM emotions ORDER BY id ASC");
require "js/star.html";
//require "js/star2.html";
while($row = $data->fetch(PDO::FETCH_BOTH)){
	echo '<input type="hidden" name="id" value="'.$id.'">';
	echo '<label id="'.$row['id'].'" class="moving" title="'.$row['bg_name'].'">';
	echo '<input class="timed" type="radio" name="'. $row['domain_id'] . '" value="'. $row['id'] .'">'.$row['en_name'];
	echo '</label><br/>';
}
echo '<input id="-1" class="moving" type="submit" value="'.NEXT.'"></form>';
	//Джурка емоциите в началото
	//echo '<script>start_moving ()</script>';
	//Подрежда емоциите в началото
echo '<script>place_words()</script>';
echo '<script src="js/collectTiming.js"></script>';
//echo '<script src="js/refreshBack.js"></script>';
//echo '<script>refreshBack("photoes.php")</script>';
require "end.php";
?>

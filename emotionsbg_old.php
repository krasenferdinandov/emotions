<?php
date_default_timezone_set("Europe/Sofia");
require "headerbg.php";
	$timeNow = time();
	$dt = new DateTime();
	$dt->setTimestamp($timeNow);
		//echo '<center>"CHOOSE_EMOTIONS"<center/>';
		echo CHOOSE_EMOTIONS.'<br/>';
		echo '<form id="the_form" style="height: 0vh;overflow:auto" method="POST" action="densitybg.php" enctype="multipart/form-data">';
		echo '<input type="hidden" name="timeStarted" value="'.$dt->format("H:i").'">';
		//echo '<input type="hidden" name="timeStarted" value="'.$_POST['timeStarted'].'">';
			$data = $pdo->query("SELECT id, bg_name, en_name, domain_id FROM emotions ORDER BY id ASC");
			require "star.html";
			while($row = $data->fetch(PDO::FETCH_BOTH)){
			
				echo '<label id="'.$row['id'].'" class="moving" title="'.$row['en_name'].'">';
				echo '<input type="checkbox" name="emotion_'.$row['id'].'" value="1">'.$row['bg_name'];
				//echo '<input type="radio" name="'. $row['domain_id'] . '" value="'. $row['id'] .'">'.$row['bg_name'];
				echo '</label><br/>';
			}
		echo '<input id="-1" class="moving" type="submit" value="'.NEXT.'"></form>';
			//Джурка емоциите в началото
			echo '<script>place_words()</script>';
			//echo '<script>start_moving ()</script>';
require "end.php";	
?>
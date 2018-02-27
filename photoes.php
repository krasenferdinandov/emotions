<?php
date_default_timezone_set("Europe/Sofia");
require "header.php";
$timeNow = time();
$dt = new DateTime();
$dt->setTimestamp($timeNow);
	echo '<form id="the_form" method="POST" action="indb1.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
	echo '<input type="hidden" id="startTime" name="timeStarted" value="'.$dt->format("Y-m-d H:i:s").'">';
	echo '<center><table class="borders"><tr>';
	echo '<b><center>FIRST STEP:<br>Guess the emotion on the face.<center/><b/>';
	echo '<style> center input[type=range] { width: 84%; } .slider_text { text-align: right; } p.danger { display: none; } p.danger:last-of-type { display: block !important; } td,th { text-align: left; } </style><table class="borders">';
	$data = $pdo->query("SELECT * FROM photoes");
	$photoes = $data->rowCount();
	$id_current_photo = 0;
	while($row = $data->fetch(PDO::FETCH_BOTH)){
		$id=$row["id"];
		$bg_name=$row["en_name"];
		$bg_alt=$row["en_alt"];
		$url=$row["url"];
		if ($id_current_photo == 0) {
			echo '<tr class="' . $id_current_photo . '"><td></td><td></td><td></td><th><center><img src="' . $url . '"></th><td></td><td></td></tr>';
			
			echo '<tr class="' . $id_current_photo . '"><td></td>
			<td><label><input class="timed" value="1" type="radio" name="label_'.$id_current_photo.'" class="radio"></input>'. $bg_name . '</label></td><td></td><td></td><td><label><input class="timed" value="0" type="radio" name="label_'.$id_current_photo.'" class="radio"></input>' . $bg_alt . '</label></td><td></td></tr>';
			
			echo '<tr class="' . $id_current_photo . '"><td colspan="2"></td><td colspan="2"><center><button type="button" onclick="next(' . $id_current_photo . ');">'.NEXT.'</button></center></td><td colspan="2"></td></tr>';
		}
		else {
			if ($id_current_photo == $photoes - 1) {
				echo '<tr style="display: none;" class="' . $id_current_photo . '"><td></td><td></td><td></td><th><center><img src="' . $url . '"></th><td></td><td></td></tr>';
				
				echo '<tr style="display: none;" class="' . $id_current_photo . '"><td></td><td><label><input class="timed" value="1" type="radio" name="label_'.$id_current_photo.'" class="radio"></input>'. $bg_name . '</label></td><td></td><td></td>
				<td><label><input class="timed" value="0" type="radio" name="label_'.$id_current_photo.'" class="radio"></input>' . $bg_alt . '</label></td><td></td></tr>';
				
				echo '<tr style="display: none;" class="' . $id_current_photo . '"><td colspan="2"></td><td colspan="2"><center><input type="submit" onclick="checkValid (' . $id_current_photo . ');" value="'.NEXT.'"/></center></td><td colspan="2"></td></tr>';
			}
			else {
				echo '<tr style="display: none;" class="' . $id_current_photo . '"><td></td><td></td><td></td><th><center><img src="' . $url . '"></th><td></td><td></td></tr>';
				
				echo '<tr style="display: none;" class="' . $id_current_photo . '"><td></td><td><label><input class="timed" value="1" type="radio" name="label_'.$id_current_photo.'" class="radio"></input>'. $bg_name . '</label></td><td></td><td></td><td><label><input class="timed" value="0" type="radio" name="label_'.$id_current_photo.'" class="radio"></input>' . $bg_alt . '</label></td><td></td></tr>';
				
				echo '<tr style="display: none;" class="' . $id_current_photo . '"><td colspan="2"></td><td colspan="2"><center><button type="button" onclick="next(' . $id_current_photo . ');">'.NEXT.'</button></center></td><td colspan="2"></td></tr>';
			}
		}
		$id_current_photo ++;
	}

echo '<script src="js/show_one_by_one_en.js"></script>';
echo '<script src="js/collectTiming.js"></script>';
require_once('js/numbers.js');
echo '<script src="js/refreshBack.js"></script>';
echo '<script>refreshBack("photoes.php")</script>';
require "end.php";	
?>
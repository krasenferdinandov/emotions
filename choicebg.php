<?php
date_default_timezone_set("Europe/Sofia");
require "headerbg.php";
if (array_key_exists('id', $_GET))
	{
		$id = $_GET['id'];
		validateInt($id);
		//echo '<br>ID: ' . $id;
	} 
echo SELECT_EMOTIONS.'<br/>';
echo '<form id="the_form" style="height: 0vh;overflow:auto" method="POST" action="themesbg.php" enctype="multipart/form-data">';
$data = $pdo->query("SELECT id, bg_name, en_name, domain_id FROM emotions ORDER BY id ASC");
require "js/star.html";
echo '<div id="star">';
echo '<input type="hidden" name="id" value="'.$id.'">';
while($row = $data->fetch(PDO::FETCH_BOTH)){
	echo '<label id="'.$row['id'].'" class="moving" title="'.$row['en_name'].'">';
	echo '<input onclick="show_slider (' . $row['id'] . ')" class="timed" type="radio" name="'. $row['domain_id'] . '" value="'. $row['id'] .'" id="input'. $row['id'] .'">'.$row['bg_name'];
	echo '</label><br/>';
}
echo "</div>";
echo '<input disabled id="-1" class="moving" type="submit" value="Избери" data-value="'.NEXT.'">';
echo '</form>';
//Подрежда емоциите в началото
echo '<style>
#slider {
	height: 100%;
	width: 100%;
	/*background-color:rgba(192,192,192,0.7);*/
	background-color:rgba(255,255,255,1);
	/*position: absolute;
	top: 0%; 
	left: 0%; 
	*/
	
    position:fixed;
    top: 50%;
    left: 50%;
    width:20em;
    height:7em;
    margin-top: -2em; /*set to a negative number 1/2 of your height*/
    margin-left: -10em; /*set to a negative number 1/2 of your width*/
    border: 1px solid #ccc;
    /*background-color: #f3f3f3;*/
}
#slider > * {
	top: 45%;
	width: 100%;
}
#slider tr {
	width: 100%;
	text-align: center;
	align-items : center;
}
td.slider_text {
	min-width: 20px;
	text-align: right;
}
</style>';
echo '<div style="display:none;" id="slider">';
echo '</div>';
echo '<script>place_words()</script>';
require_once('js/numbers.js');
echo '<script src="js/combine-slider.js"></script>';
echo '<script src="js/collectTiming.js"></script>';
require "end.php";
?>
<?php
require "headerbg.php";
require "js/toggle.js";
echo '<form id="the_form" method="POST" action="indb4bg.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
if (array_key_exists('id', $_GET))
	{
		$id = $_GET['id'];
		validateInt($id);
		//echo '<br>ID: ' . $id;
	}
	else
	{
		redirect ('photoesbg.php');
	}
echo '<input type="hidden" name="id" value="'.$id.'">';
$table_result = '<center><table class="borders"><tr><th colspan="2"></th></tr>';
$table_result.= '<tr><th colspan="2"><p><center>ШЕСТ СТЪПКА: <br><center/>'.TIPS.'</th><tr/>';
$data = $pdo->query('SELECT * FROM miniscripts');
while($r = $data->fetch(PDO::FETCH_BOTH)){
		$m=$r['id'];

$table_result .= '<th colspan="1" align="left" style="border: 0px solid #c0c0c0;"><input class="timed" id="script_'.$m.'" type="checkbox" name="miniscript'.$m.'" value="1">';
$table_result .= '<label for="script_'.$m.'">'.$r['bg_name'].'<td align="right"><button type="button" class="show" data-id="script_desc_'. $m . '">Значение</button></td></label></th></tr><tr style="display:none" id="script_desc_'. $m . '"><td colspan="2"><p class="desc-res5" align="right">'.quot($r['bg_desc']).'</p></td></tr>';
}
$table_result .= '<center/></table>';
echo $table_result;
echo '</br><input type="submit" value="Продължи"/><br/>';
echo '<script src="js/collectTiming.js"></script>';
//echo '<script src="js/refreshBack.js"></script>';
//echo '<script>refreshBack("photoesbg.php")</script>';
require('js/showText.js');
require "end.php";
?>

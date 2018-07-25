<?php
require "headerbg.php";
require "js/toggle.js";
echo '<form id="the_form" method="POST" action="indb3bg.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
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

$posi = '';
$nega = '';
$ambi = '';
$manag = 0;

$table_result = '<center><table class="borders"><tr><th colspan="2"></th></tr>';

$sum_pos=0;$count_pos=0;
$sum_neg=0;$count_neg=0;
$sum_ambi=0;$count_ambi=0;
$miniscript_condition='domainX_id=-1';

$sel_emotions = $pdo->query("SELECT * FROM emotions_stat WHERE id=$id");
while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
	$e_id=$r['emotion_id'];
	$e_sl=$r['e_slider'];

	$data = $pdo->query("SELECT manag FROM id_stat WHERE id = $id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$manag = $r['manag'];

	$data = $pdo->query("SELECT domain_id, dimension_id, bg_name, en_name, string_id, tension_id FROM emotions WHERE id = $e_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$domain_id = intval($r['domain_id']);
	$e_name = $r['bg_name'];
	$en_name = $r['en_name'];
	$dimension_id = $r['dimension_id'];
	$e_string = $r['string_id'];
	$e_tension = $r['tension_id'];

		if ($e_string == 0){
		$density= (($e_sl*0.4)+$e_tension);
		}
		else if($e_string == 1){
		$density=(($e_sl*0.6)+$e_tension);
		}
		else if($e_string == 2){
		$density=(($e_sl*0.8)+$e_tension);
		}
	$data = $pdo->query("SELECT bg_name, script_id FROM domains WHERE id = $domain_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$domain_name = $r['bg_name'];
	$script_id = intval($r['script_id']);

	$data = $pdo->query("SELECT bg_name, bg_desc FROM scripts WHERE id=$script_id");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$script_name = $r['bg_name'];
	$script_desc = $r['bg_desc'];
//Показва плътността на избраните състояния
		if($dimension_id == 0){
			$sum_pos+=$density;
			$count_pos+=1;
		}
		if($dimension_id == 1){
			$sum_neg+=$density;
			$count_neg+=1;
		}
		if($dimension_id == 99){
			$sum_ambi+=$density;
			$count_ambi+=1;
		}
//Показва резултати за Miniscripts
	$miniscript_condition.=' OR domainX_id='.$domain_id;
}
$table_result.= '<tr><th colspan="2"><p><center>ПЕТА СТЪПКА: <br><center/>'.TIP.'</th><tr/>';

$data = $pdo->query('SELECT id,bg_name,bg_desc,domain1_id,domain2_id FROM miniscripts WHERE ( '.str_replace('X', '1', $miniscript_condition).' ) AND ( '.str_replace('X', '2', $miniscript_condition).' );');
while($r = $data->fetch(PDO::FETCH_BOTH)){
		$m=$r['id'];

$table_result .= '<th colspan="1" align="left" style="border: 0px solid #c0c0c0;"><input class="timed" id="script_'.$m.'" type="checkbox" name="miniscript'.$m.'" value="1">';
$table_result .= '<label for="script_'.$m.'">'.$r['bg_name'].'<td align="right"><button type="button" class="show" data-id="script_desc_'. $m . '">Значение</button></td></label></th></tr><tr style="display:none" id="script_desc_'. $m . '"><td colspan="2"><p class="desc-res5" align="right">'.quot($r['bg_desc']).'</p></td></tr>';
}
//Показва съотношението между положителните и отрицателните емоции според стойностите от слайдера: "AFFECT MANAGEMENT"
if($count_pos==0) $count_pos=1;
if($count_neg==0) $count_neg=1;
if($count_ambi==0) $count_ambi=1;
//За премахване на стойностите на слайдера от съотношението между + и - емоции замени "sum_pos/neg..." със "count_pos/neg..."
$score_neg=scores_level($sum_neg, $count_neg-$count_ambi);
$score_pos=scores_level($sum_pos, $count_pos-$count_ambi);
$score_ambi=scores_level($sum_ambi, $count_ambi);
$score_group=$score_neg.$score_pos;
$data = $pdo->query("SELECT id,bg_name,bg_desc FROM management WHERE score_group LIKE '%$score_group%'");
$r = $data->fetch(PDO::FETCH_BOTH);
$id_manag = 99;
if ($r){
	$id_manag = $r['id'];
	$bg_name = $r['bg_name'];
	$bg_desc = $r['bg_desc'];
}else{
	$bg_name='';
	$bg_desc='';
}
$posi = percent($sum_pos, $sum_pos+$sum_neg+$sum_ambi);
$nega = percent($sum_neg, $sum_pos+$sum_neg+$sum_ambi);
$ambi = percent($sum_ambi, $sum_pos+$sum_neg+$sum_ambi);

$table_result .= '<input type="hidden" value="'.$posi.'" name="posi"/>';
$table_result .= '<input type="hidden" value="'.$nega.'" name="nega"/>';
$table_result .= '<input type="hidden" value="'.$ambi.'" name="ambi"/>';

$manag = $id_manag;
$table_result .= '<input type="hidden" value="'.$manag.'" name="manag"/>';
$table_result .= '<center/></table>';
echo $table_result;
echo '</br><input type="submit" value="Продължи"/><br/>';
echo '<script src="js/collectTiming.js"></script>';
//echo '<script src="js/refreshBack.js"></script>';
//echo '<script>refreshBack("photoesbg.php")</script>';
require('js/showText.js');
require "end.php";
?>

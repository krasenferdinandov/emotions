<?php
require "headerbg.php";
require "js/blockback.js";
require "js/toggle.js";
echo '<form method="POST" action="mininsertbg.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
//Показва съобщение за резултата с текущото ID
if(!array_key_exists('id', $_GET)){
	die();
}
$id = $_GET['id'];
validateInt($id);

echo '<input type="hidden" name="id" value="'.$id.'">';

echo '<center>'.MEANING.'<center/>';

$posi = '';
$nega = '';
$ambi = '';
$manag = 0;

//$table_result = '<center><table class="borders"><tr><th colspan="2">'.RESULTS.'</th></tr>';
$table_result = '<center><table class="borders"><tr><th colspan="2"></th></tr>';

$sum_pos=0;$count_pos=0;
$sum_neg=0;$count_neg=0;
$sum_ambi=0;$count_ambi=0;
$axis_stat=array();
$axis_stat_count=0;
$axis_list=array();
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
		//$density=$e_sl;	
	
	$data = $pdo->query("SELECT bg_name, script_id FROM domains WHERE id = $domain_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$domain_name = $r['bg_name'];
	$script_id = intval($r['script_id']);
	
	$data = $pdo->query("SELECT bg_name, bg_desc FROM scripts WHERE id=$script_id");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$script_name = $r['bg_name'];
	$script_desc = $r['bg_desc'];

//Показва плътността на избраните състояния
	//$table_result .= '<tr><td style="border: 1px solid #c0c0c0;"><a title="'.quot($script_name).', '.quot($script_desc).'">'.quot($e_name).'</a></td>';
	//$table_result .= '<td style="border: 1px solid #c0c0c0;">'.DENSITY.''.$density.'</td></tr>';
	
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
//Показва резултати за Subscripts и Miniscripts
	$miniscript_condition.=' OR domainX_id='.$domain_id;
}
$table_result.= '<tr><th colspan="2"><p>'.TIP.'</th><tr/>';

$sel_states = $pdo->query("SELECT * FROM states_stat WHERE id=$id");
while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
	$state_id = $r['state_id'];
	$data = $pdo->query("SELECT bg_name, axis_id FROM statements WHERE id = $state_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$bg_name = $r['bg_name'];
	$axis = $r['axis_id'];
	
	if(!isset($axis_stat[$axis])){
		$axis_stat[$axis] = 0;
		$axis_list[$axis] = array();
	}
	
	$axis_stat[$axis] += 1;
	$axis_list[$axis][] = $bg_name;
	$axis_stat_count += 1;
}

$data = $pdo->query('SELECT id,bg_name,bg_desc,domain1_id,domain2_id FROM miniscripts WHERE ( '.str_replace('X', '1', $miniscript_condition).' ) AND ( '.str_replace('X', '2', $miniscript_condition).' );');
while($r = $data->fetch(PDO::FETCH_BOTH)){
		$m=$r['id'];

$table_result .= '<th colspan="1" align="left" style="border: 0px solid #c0c0c0;"><input id="script_'.$m.'" type="checkbox" name="miniscript'.$m.'" value="1">';
$table_result .= '<label for="script_'.$m.'">'.$r['bg_name'].'<p id='.$m.' class="desc-res" style="display:none" align="right">'.quot($r['bg_desc']).'</p> <td><button type="button" onclick="myFunction('.$m.')">Значение</button></td></label></th></tr>';
}
$table_result.= '<tr><th colspan="2"><center><br/><b>'.SECONDARY.'<center/></th><tr/>';

//Показва съотношението между положителните и отрицателните емоции според стойностите от слайдера: "AFFECT MANAGEMENT"
if($count_pos==0) $count_pos=1;
if($count_neg==0) $count_neg=1;
if($count_ambi==0) $count_ambi=1;
//За премахване на стойностите на слайдера от съотношението между + и - емоции замени "sum_pos/neg..." със "count_pos/neg..."
$table_result.= '<tr><td style="border: 1px solid #c0c0c0;">'.RATIO.'</td>';

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
//----------------->Етикет на SOM!
	/*$som_name = "";
			if($posi>=68){
				$som_name = '<a title="Предполагаем научен показател за прекалена самоувереност, импулсивност или недооценка на ролята и значението на отрицателните преживявания.">Прекомерен оптимизъм<a/>';
			}else if($posi>=56){
				$som_name = '<a title="Предполагаем научен показател за адекватно справяне с общия житейски стрес.">Добро напасване<a/>';
			}else if ($posi>=44) {
				$som_name = '<a title="Предполагаем научен показател за вътрешни конфликти, които могат да надделеят над общата способност за справяне под формата на натрапчиви мисли или леки тревожности.">Вътрешни конфликти<a/>';
			}else if ($posi>=32) {
				$som_name = '<a title="Предполагаем научен показател за средно изразени тревожности, раздразнителност или емоционална потиснатост.">Тревожни състояния<a/>';
			}else{
				$som_name = '<a title="Предполагаем научен показател за тежки и сериозни сътресения в емоционалния живот. ">Критични състояния<a/>';
			}*/


//$table_result.= '<td style="border: 1px solid #c0c0c0;">* '.$som_name.'<br>- '.POSITIVE.': '.percent($sum_pos, $sum_pos+$sum_neg).'%<br>- '.NEGATIVE.': '.percent($sum_neg, $sum_pos+$sum_neg).'%</td>';
//-----------------
$table_result.= '<td style="border: 1px solid #c0c0c0;">- '.POSITIVE.': '.percent($sum_pos, $sum_pos+$sum_neg+$sum_ambi).'%<br>- '.NEGATIVE.': '.percent($sum_neg, $sum_pos+$sum_neg+$sum_ambi).'%<br>- '.AMBIVALENT.': '.percent($sum_ambi, $sum_pos+$sum_neg+$sum_ambi).'%</td>';


$table_result .= '<input type="hidden" value="'.$posi.'" name="posi"/>';
$table_result .= '<input type="hidden" value="'.$nega.'" name="nega"/>';
$table_result .= '<input type="hidden" value="'.$ambi.'" name="ambi"/>';

$table_result.= '<tr><td style="border: 1px solid #c0c0c0;">'.CONTROL.'</td>'.'<td style="border: 1px solid #c0c0c0;">* '.quot($bg_name).'</br><p class="desc-res2" align="right">'.$bg_desc.'</p></td><tr/>';

$manag = $id_manag;
$table_result .= '<input type="hidden" value="'.$manag.'" name="manag"/>';
//$table_result .= $manag . "\n";

//Показва процентите от "statements"
$table_result.= '<tr><td colspan="2"><center><br/><b>'.ATTITUDES.'<center/><tr/>';
$axis_count_total=0;
$sel_axis = $pdo->query("SELECT id,bg_name,bg_desc FROM axis ORDER BY id");
$table_result.='<tr><td style="border-right: none; border: 1px solid #c0c0c0;" colspan="2">';
while($r = $sel_axis->fetch(PDO::FETCH_BOTH)) {
	$axis_id = $r['id'];
	$bg_name = $r['bg_name'];
	$bg_desc = $r['bg_desc'];
	
	if(!isset($axis_stat[$axis_id])) {
		continue;
	}
	$axis_list[$axis_id]=array_unique($axis_list[$axis_id]);
	$data = $pdo->query("SELECT COUNT(id) FROM statements WHERE axis_id=$axis_id");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$axis_total = $r['COUNT(id)'];
	
	$data = $pdo->query("SELECT COUNT(stat.id) FROM states_stat stat join statements s on stat.state_id = s.id where s.axis_id = $axis_id and stat.id = " . $id . "");
			$ri = $data->fetch(PDO::FETCH_BOTH);
			$axis_total_d = $ri['COUNT(stat.id)'];
						
//Показва избраните изречения за всеки "axis"
	$chosen_states = '';
	foreach($axis_list[$axis_id] as $axis){
		$chosen_states .= $axis . "\n";
	}
		
	$level_axis = percent(sizeof($axis_list[$axis_id]), $axis_total);
	$label_axis = "";
	if ($level_axis <= 30){
		$label_axis = 'Нискa';
	}
	if ($level_axis > 30 && $level_axis < 60){
		$label_axis = 'Среднa';
	}
	if ($level_axis >= 60){
		$label_axis = 'Високa';
	}
	
	$table_result.= '<br><a title="'.quot($bg_desc).'">* <b/>'.quot($bg_name).'<a title="'.$chosen_states.'">, '.$level_axis.'% <a title="Показва колко предпочитан е дадения показател от избрания тест пред другите. Под 30% е ниска, от 30% до 60% - средна; над 60 % - висока."> Обща изразеност</a></br></b>'."\n";
	
}

$table_result .= '<center/></table>';
echo $table_result;
echo '</br><a title="">Потвърди резултатите и направените избори: </a><input type="submit" value="Потвърждение"/><br/>';
echo '<br>'.CONTRIBUTION.'</br>';
require "end.php";
?>
<?php
require "header.php";
require "js/toggle.js";
echo '<form id="the_form" method="POST" action="mininsert.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';
//Показва съобщение за резултата с текущото ID
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
$axes_stat=array();
$axes_stat_count=0;
$axes_list=array();
$miniscript_condition='domainX_id=-1';

$sel_emotions = $pdo->query("SELECT * FROM emotions_stat WHERE id=$id");
while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
	$e_id=$r['emotion_id'];
	$e_sl=$r['e_slider'];
	
	$data = $pdo->query("SELECT manag FROM id_stat WHERE id = $id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$manag = $r['manag'];
	
	$data = $pdo->query("SELECT domain_id, dimension_id, en_name, bg_name, string_id, tension_id FROM emotions WHERE id = $e_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$domain_id = intval($r['domain_id']);
	$e_name = $r['en_name'];
	$bg_name = $r['bg_name'];
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
	
	$data = $pdo->query("SELECT en_name, script_id FROM domains WHERE id = $domain_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$domain_name = $r['en_name'];
	$script_id = intval($r['script_id']);
	
	$data = $pdo->query("SELECT en_name, en_desc FROM scripts WHERE id=$script_id");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$script_name = $r['en_name'];
	$script_desc = $r['en_desc'];

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
//Demorest
$sel_states = $pdo->query("SELECT * FROM states_stat WHERE id=$id");
while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
	$state_id = $r['state_id'];
	$data = $pdo->query("SELECT en_name, axis_id FROM statements WHERE id = $state_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$en_name = $r['en_name'];
	$axis = $r['axis_id'];
	
	if(!isset($axis_stat[$axis])){
		$axis_stat[$axis] = 0;
		$axis_list[$axis] = array();
	}
	
	$axis_stat[$axis] += 1;
	$axis_list[$axis][] = $en_name;
	$axis_stat_count += 1;
}
//RJD
$sel_statis = $pdo->query("SELECT * FROM statis_stat WHERE id=$id");
while($r = $sel_statis->fetch(PDO::FETCH_BOTH)){
	$stati_id = $r['stati_id'];
	$data_st = $pdo->query("SELECT en_name, axes_id FROM statiments WHERE id = $stati_id LIMIT 1");
	$r = $data_st->fetch(PDO::FETCH_BOTH);
	$en_name = $r['en_name'];
	$axes = $r['axes_id'];
	
	if(!isset($axes_stat[$axes])){
		$axes_stat[$axes] = 0;
		$axes_list[$axes] = array();
	}
	
	$axes_stat[$axes] += 1;
	$axes_list[$axes][] = $en_name;
	$axes_stat_count += 1;
}

$data = $pdo->query('SELECT id,en_name,en_desc,domain1_id,domain2_id FROM miniscripts WHERE ( '.str_replace('X', '1', $miniscript_condition).' ) AND ( '.str_replace('X', '2', $miniscript_condition).' );');
while($r = $data->fetch(PDO::FETCH_BOTH)){
		$m=$r['id'];

$table_result .= '<th colspan="1" align="left" style="border: 0px solid #c0c0c0;"><input class="timed" id="script_'.$m.'" type="checkbox" name="miniscript'.$m.'" value="1">';
$table_result .= '<label for="script_'.$m.'">'.$r['en_name'].'<p id='.$m.' class="desc-res" style="display:none" align="right">'.quot($r['en_desc']).'</p> <td><button type="button" onclick="myFunction('.$m.')">Meaning</button></td></label></th></tr>';
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
$data = $pdo->query("SELECT id,en_name,en_desc FROM management WHERE score_group LIKE '%$score_group%'");
$r = $data->fetch(PDO::FETCH_BOTH);
$id_manag = 99;
if ($r){
	$id_manag = $r['id'];
	$en_name = $r['en_name'];
	$en_desc = $r['en_desc'];
}else{
	$en_name='';
	$en_desc='';
}
$posi = percent($sum_pos, $sum_pos+$sum_neg+$sum_ambi);
$nega = percent($sum_neg, $sum_pos+$sum_neg+$sum_ambi);
$ambi = percent($sum_ambi, $sum_pos+$sum_neg+$sum_ambi);
/*----------------->Етикет на SOM!
	$som_name = "";
			if($posi>=68){
				$som_name = '<a title="Hypothetic scientific sign of overconfidence, impulsiveness and neglected negative experiences.">Excessive Optimism<a/>';
			}else if($posi>=56){
				$som_name = '<a title="Hypothetic scientific sign of good coping">Optimal Adjustment<a/>';
			}else if ($posi>=44) {
				$som_name = '<a title="Hypothetic scientific sign of mild anxiety or obsessive mindset.">Internal Conflicts<a/>';
			}else if ($posi>=32) {
				$som_name = '<a title="Hypothetic scientific sign of noderate anxiety or depression.">Problematic Coping<a/>';
			}else{
				$som_name = '<a title="Hypothetic scientific sign of severe disturbances.">Critical Maladjustment<a/>';
			}


//$table_result.= '<td style="border: 1px solid #c0c0c0;">* '.$som_name.'<br>- '.POSITIVE.': '.percent($sum_pos, $sum_pos+$sum_neg).'%<br>- '.NEGATIVE.': '.percent($sum_neg, $sum_pos+$sum_neg).'%</td>';
----------------->*/
$table_result.= '<td style="border: 1px solid #c0c0c0;">- '.POSITIVE.': '.percent($sum_pos, $sum_pos+$sum_neg+$sum_ambi).'%<br>- '.NEGATIVE.': '.percent($sum_neg, $sum_pos+$sum_neg+$sum_ambi).'%<br>- '.AMBIVALENT.': '.percent($sum_ambi, $sum_pos+$sum_neg+$sum_ambi).'%</td>';


$table_result .= '<input type="hidden" value="'.$posi.'" name="posi"/>';
$table_result .= '<input type="hidden" value="'.$nega.'" name="nega"/>';
$table_result .= '<input type="hidden" value="'.$ambi.'" name="ambi"/>';

$table_result.= '<tr><td style="border: 1px solid #c0c0c0;">'.CONTROL.'</td>'.'<td style="border: 1px solid #c0c0c0;">* '.quot($en_name).'</br><p class="desc-res2" align="right">'.$en_desc.'</p></td><tr/>';

$manag = $id_manag;
$table_result .= '<input type="hidden" value="'.$manag.'" name="manag"/>';
//$table_result .= $manag . "\n";

//Показва процентите от "statements"
$table_result.= '<tr><td colspan="2"><center><br/><b>'.ATTITUDES.'<center/><tr/>';
$axis_count_total=0;
$sel_axis = $pdo->query("SELECT id,en_name,en_desc FROM axis ORDER BY id");
$table_result.='<tr><td style="border: 1px solid #c0c0c0;" colspan="2">';
while($r = $sel_axis->fetch(PDO::FETCH_BOTH)) {
	$axis_id = $r['id'];
	$en_name = $r['en_name'];
	$en_desc = $r['en_desc'];
	
	if(!isset($axis_stat[$axis_id])) {
		continue;
	}
	$axis_list[$axis_id]=array_unique($axis_list[$axis_id]);
	$data = $pdo->query("SELECT COUNT(id) FROM statements WHERE axis_id=$axis_id");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$axis_total = $r['COUNT(id)'];
	$data = $pdo->query("SELECT COUNT(stat.id) FROM states_stat stat join statements s on stat.state_id = s.id where s.axis_id = $axis_id and stat.id = " . $id . "");
			$r = $data->fetch(PDO::FETCH_BOTH);
			$axis_total_d = $r['COUNT(stat.id)'];

//Demorest Показва избраните изречения за всеки "axis" 
	$chosen_states = '';
	foreach($axis_list[$axis_id] as $axis){
		$chosen_states .= $axis . "\n";
	}

	$level_axis = percent(sizeof($axis_list[$axis_id]), $axis_total);
	$label_axis = "";
	if ($level_axis < 30){
		$label_axis = 'Low';
	}
	if ($level_axis >= 30 && $level_axis < 60){
		$label_axis = 'Moderate';
	}
	if ($level_axis >= 60){
		$label_axis = 'High';
	}
	
	$table_result.= '<br><a title="'.quot($en_desc).'">* <b/>'.quot($en_name).'<a title="'.$chosen_states.'">, '.$level_axis.'%<a title="Shows what is the significance of types of emotion related scenes."> General significance </a></br></b>'."\n";
	
}
//RJD Показва процентите от "statiments"
$table_result.= '<tr><td colspan="2"><center><br/><b>'.STYLE.'<center/><tr/>';
$axes_count_total=0;
$sel_axes = $pdo->query("SELECT id,en_name,en_desc FROM axes ORDER BY id");
$table_result.='<tr><td style="border: 1px solid #c0c0c0;" colspan="2">';
while($r = $sel_axes->fetch(PDO::FETCH_BOTH)) {
	$axes_id = $r['id'];
	$en_name = $r['en_name'];
	$en_desc = $r['en_desc'];
	
	if(!isset($axes_stat[$axes_id])) {
		continue;
	}
	$axes_list[$axes_id]=array_unique($axes_list[$axes_id]);
	$data = $pdo->query("SELECT COUNT(id) FROM statiments WHERE axes_id=$axes_id");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$axes_total = $r['COUNT(id)'];
	$data = $pdo->query("SELECT COUNT(stet.id) FROM statis_stat stet join statiments s on stet.stati_id = s.id where s.axes_id = $axes_id and stet.id = " . $id . "");
			$r = $data->fetch(PDO::FETCH_BOTH);
			$axes_total_d = $r['COUNT(stet.id)'];

//Показва избраните изречения за всеки "axis"
	$chosen_statis = '';
	foreach($axes_list[$axes_id] as $axes){
		$chosen_statis .= $axes . "\n";
	}

	$level_axes = percent(sizeof($axes_list[$axes_id]), $axes_total);
	$label_axes = "";
	if ($level_axes < 30){
		$label_axes = 'Low';
	}
	if ($level_axes >= 30 && $level_axes < 60){
		$label_axes = 'Moderate';
	}
	if ($level_axes >= 60){
		$label_axes = 'High';
	}
	
	$table_result.= '<br><a title="'.quot($en_desc).'">* <b/>'.quot($en_name).'<a title="'.$chosen_statis.'">, '.$level_axes.'%<a title="Shows what is the significance of one personality property compare to other psychological variables from the test."> General significance </a></br></b>'."\n";
}
$table_result .= '<center/></table>';
echo $table_result;
echo '</br><a title="">Confirm the results and choices you`ve made above: </a><input type="submit" value="Submit"/><br/>';
echo '<br>'.CONTRIBUTION.'</br>';
echo '<script src="js/collectTiming.js"></script>';
echo '<script src="js/refreshBack.js"></script>';
echo '<script>refreshBack("emotionsbg.php")</script>';
require "end.php";

?>

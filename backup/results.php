<?php
require "header.php";
if(!array_key_exists('id', $_GET)){
	die();
}
$id = $_GET['id'];
validateInt($id);

//Показва съобщение за резултата с текущото ID
echo'<center></br>'.ID.'</br>'.TIP2.'<b>'.$id.'</b><center/><br>';
echo '<center><b>'.RESULTS.'</b></center>';
$table_result = '<center><table>';
$sum_pos=0;$count_pos=0;
$sum_neg=0;$count_neg=0;
$sum_ambi=0;$count_ambi=0;
$axis_stat=array();
$axis_stat_count=0;
$axis_list=array();
$axes_stat=array();
$axes_stat_count=0;
$axes_list=array();
$string = array();
$tension = array();
$sel_emotions = array();
$statement = $pdo->query("SELECT id, string_id, tension_id FROM emotions");
while($row = $statement->fetch(PDO::FETCH_BOTH))
{
	$string[$row['id']] = $row['string_id'];
	$tension[$row['id']] = $row['tension_id'];
}
function isInDomain($emotion_search){
	if($emotion_search >= 0 && $emotion_search <= 8)return 0;
	if($emotion_search >= 9 && $emotion_search <= 17)return 1;
	if($emotion_search >= 18 && $emotion_search <= 26)return 2;
	if($emotion_search >= 27 && $emotion_search <= 35)return 3;
	if($emotion_search >= 36 && $emotion_search <= 44)return 4;
	if($emotion_search >= 45 && $emotion_search <= 53)return 5;
	if($emotion_search >= 54 && $emotion_search <= 62)return 6;
	if($emotion_search >= 63 && $emotion_search <= 71)return 7;
	if($emotion_search >= 72 && $emotion_search <= 80)return 8;
	if($emotion_search >= 81 && $emotion_search <= 89)return 9;
}
			
$count_e=0;	
	$sel_emotions = $pdo->query("Select * FROM emotions_stat WHERE id=$id");
	while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
		$count_e+=1;
		}
$count_s=0;	
	$sel_scripts = $pdo->query("Select * FROM miniscripts_stat WHERE id=$id");
	while($r = $sel_scripts->fetch(PDO::FETCH_BOTH)){
	$count_s+=1;
		}		
			
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
	$en_name = $r['en_name'];
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
	$table_result .= '<tr><td style="border: 1px solid #c0c0c0;"><a title="'.quot($script_name).', '.quot($script_desc).'">* '.quot($en_name).'</a></td>';
	$table_result .= '<td style="border: 1px solid #c0c0c0;">'.DENSITY.''.$density.'</td></tr>';

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
}
//Demorest
$sel_states = $pdo->query("SELECT * FROM states_stat WHERE id=$id");
while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
	$state_id = $r['state_id'];
	$s_slider = $r['s_slider'];
	$data = $pdo->query("SELECT en_name, axis_id FROM statements WHERE id = $state_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$en_name = $r['en_name'];
	$axis = $r['axis_id'];
	
	if(!isset($axis_stat[$axis])){
		$axis_stat[$axis] = 0;
		$axis_list[$axis] = array();
		$axis_subaxis[$axis] = array();
	}
	$axis_stat[$axis] += 1;
	$axis_list[$axis][] = $en_name;
	$axis_stat_count += 1;
}
//RJD
$sel_states = $pdo->query("SELECT * FROM statis_stat WHERE id=$id");
		while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
			$state_id = $r['state_id'];
			$data = $pdo->query("SELECT en_name, axis_id FROM statiments WHERE id = $state_id LIMIT 1");
			$r = $data->fetch(PDO::FETCH_BOTH);
			$bg_name = $r['en_name'];
			$axis = $r['axis_id'];

			if(!isset($axis_stat[$axis])){
				$axis_stat[$axis] = 0;
				$axis_list[$axis] = array();
				$axis_subaxis[$axis] = array();
			}
			$axis_stat[$axis] += 1;
			$axis_list[$axis][] = $bg_name;
			$axis_stat_count += 1;
}

//Показва резултати за Miniscripts
$table_result.= '<tr><th colspan="2"><center><br/><b>'.CONFIRMED.'<center/></th><tr/>';

$data_s = $pdo->query('SELECT miniscripts.id,miniscripts.en_name, miniscripts.domain1_id, miniscripts.domain2_id, miniscripts.en_name,miniscripts.en_desc FROM miniscripts inner join miniscripts_stat on miniscripts.id = miniscripts_stat.miniscript_id WHERE miniscripts_stat.id='.$id.'');
	
while($r = $data_s->fetch(PDO::FETCH_BOTH)){
//Показва id на потвърдените miniscripts;
			//$table_result .= '<a title="'.quot($r['en_desc']).'">'.$r['id'].$r['en_name'].'</a>'; 
$table_result .= '<tr><td colspan="2" align="left" style="border-right: none; border: 1px solid #c0c0c0;">* <b><a title="'.quot($r['en_desc']).'">'.$r['en_name'].'</a></b>, ';
			
			$magnification_m = "?";
					$density_em1 = $r['domain1_id'];
					$density_em2 = $r['domain2_id'];
					
					$sel_emotions1 = $pdo->query("SELECT * FROM emotions em join emotions_stat e 
					on em.id = e.emotion_id where e.id = " . $id . "");
					while($ro = $sel_emotions1->fetch(PDO::FETCH_BOTH)){
						if(isInDomain($ro['emotion_id']) == $density_em1){
							$mas1 = $ro['emotion_id'];
							$e_sl_1=$ro['e_slider'];
						}
						if(isInDomain($ro['emotion_id']) == $density_em2){
							$mas2 = $ro['emotion_id'];
							$e_sl_2=$ro['e_slider'];
						}
					}
								
					$string_id_1 = $string[$mas1];
					$string_id_2 = $string[$mas2];
					$tension_id_1 = $tension[$mas1];
					$tension_id_2 = $tension[$mas2];
					
					if ($string_id_1 == 0){			
					$density_em1 = (($e_sl_1*0.4)+$tension_id_1);
					}
					else if($string_id_1 == 1){
					$density_em1 = (($e_sl_1*0.6)+$tension_id_1);
					}
					else if($string_id_1 == 2){
					$density_em1 = (($e_sl_1*0.8)+$tension_id_1);
					}
					
					if ($string_id_2 == 0){			
					$density_em2 = (($e_sl_2*0.4)+$tension_id_2);
					}
					else if($string_id_2 == 1){
					$density_em2 = (($e_sl_2*0.6)+$tension_id_2);
					}
					else if($string_id_2 == 2){
					$density_em2 = (($e_sl_2*0.8)+$tension_id_2);
					}
					
					if ($string_id_2 == 0){			
					$density_em2 = (($e_sl_2*0.4)+$tension_id_2);
					}
					else if($string_id_2 == 1){
					$density_em2 = (($e_sl_2*0.6)+$tension_id_2);
					}
					else if($string_id_2 == 2){
					$density_em2 = (($e_sl_2*0.8)+$tension_id_2);
					}	
		
	
	$count_e=0;	
			$sel_emotions = $pdo->query("Select * FROM emotions_stat WHERE id=$id");
			while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
				$count_e+=1;
			}
	$count_s=0;	
			$sel_scripts = $pdo->query("Select * FROM miniscripts_stat WHERE id=$id");
			while($r = $sel_scripts->fetch(PDO::FETCH_BOTH)){
				$count_s+=1;
			}
		$magnification_m = round(($count_e * ($density_em1  + $density_em2))/($count_s), 1) ;
	
		
		$table_result .= '<a title="Degree of magnification gives an psychological advantage. Magnification explains how much one emotional script is exagerated to take advantage toward others making a significant impact in someone`s personal behavior, habits, values, traits or convictions. Magnification advantage could exceed 100. Magnification has a additional property to create conductance, resistance or reactance depends on how high or low is its value. If it is high then it is probably to assotiate more scences, strivings, habits or traits in common script and vice versa, to resist and react against the creation of variants and divergence in personal experience probably due to negative investments or lack of emotional interest.">Advantage:</a> '. $magnification_m. '</a></li></br>';
		}
$table_result .= '</ul></td></tr>';

//--------------------
$table_result.= '<tr><th colspan="2"><center><br/><b>'.SECONDARY.'<center/></th><tr/>';
// Показва съотношението между положителните и отрицателните емоции според стойностите от слайдера: "AFFECT MANAGEMENT"
if($count_pos==0) $count_pos=1;
if($count_neg==0) $count_neg=1;
if($count_ambi==0) $count_ambi=1;
//За премахване на стойностите на слайдера от съотношението между + и - емоции замени "sum_pos/neg..." със "count_pos/neg..."
$table_result.= '<tr><td style="border: 1px solid #c0c0c0;"><b>'.RATIO.'<b/></td>';

$score_neg=scores_level($sum_neg, $count_neg-$count_ambi);
$score_pos=scores_level($sum_pos, $count_pos-$count_ambi);
$score_ambi=scores_level($sum_ambi, $count_ambi);
$score_group=$score_neg.$score_pos;
$data = $pdo->query("SELECT en_name,en_desc FROM management WHERE score_group LIKE '%$score_group%'");
$r = $data->fetch(PDO::FETCH_BOTH);
if ($r){
	$en_name = $r['en_name'];
	$en_desc = $r['en_desc'];
}else{
	$en_name='';
	$en_desc='';
}
$posi = percent($sum_pos, $sum_pos+$sum_neg+$sum_ambi);
$nega = percent($sum_neg, $sum_pos+$sum_neg+$sum_ambi);
$ambi = percent($sum_ambi, $sum_pos+$sum_neg+$sum_ambi);

$table_result.= '<td style="border: 1px solid #c0c0c0;">- '.POSITIVE.': '.percent($sum_pos, $sum_pos+$sum_neg+$sum_ambi).'%<br>- '.NEGATIVE.': '.percent($sum_neg, $sum_pos+$sum_neg+$sum_ambi).'%<br>- '.AMBIVALENT.': '.percent($sum_ambi, $sum_pos+$sum_neg+$sum_ambi).'%</td>';

$table_result.= '<tr><td style="border-right: none; border: 1px solid #c0c0c0;">'.CONTROL.'</td>'.'<td style="border-right: none; border: 1px solid #c0c0c0;"><a title="'.quot($en_desc).'"><b>* '.quot($en_name).'<b/></a></br></td><tr/>';

//Показва процентите от "statements"
$table_result.= '<tr><td colspan="2"><center><br/><b>'.ATTITUDES.'<center/><tr/>';
$axis_count_total=0;
$sel_axis = $pdo->query("SELECT id,en_name,en_desc FROM axis ORDER BY id");
$table_result.='<tr><td style="border: 1px solid #c0c0c0;" colspan="2">';
while($r = $sel_axis->fetch(PDO::FETCH_BOTH)) {
	$axis_id = $r['id'];
	$en_name = $r['en_name'];
	$en_desc = $r['en_desc'];
}
$table_result .= "<br/><center><b>List of selected themes:<center/>";
$sel_states = $pdo->query("SELECT * FROM states_stat WHERE id=$id");
while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
	$s_id=$r['state_id'];
	$s_sl=$r['s_slider'];
	
	$data = $pdo->query("SELECT en_name, bg_name, axis_id FROM statements WHERE id = $s_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$axis_id = intval($r['axis_id']);
	$en_name = $r['en_name'];
	
	$data = $pdo->query("SELECT en_name, en_desc FROM axis WHERE id=$axis_id");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$axis_name = $r['en_name'];
	$axis_desc = $r['en_desc'];
	
	$table_result .= '<tr><td style="border: 1px solid #c0c0c0;"><a title="'.quot($axis_name).', '.quot($axis_desc).'"><b>- '.quot($en_name).'<b/></a></td>';
	$table_result .= '<td style="border: 1px solid #c0c0c0;">Preference: <b>'.$s_sl.'<b/></td></tr>';
}
//RJD --> Показва процентите от "statiments"
$table_result.= '<tr><td colspan="2"><center><br/><b>'.STYLE.'<center/><tr/>';
$axis_count_total=0;
$sel_axis = $pdo->query("SELECT id,en_name,en_desc FROM axis ORDER BY id");
$table_result.='<tr><td style="border: 1px solid #c0c0c0;" colspan="2">';
while($r = $sel_axis->fetch(PDO::FETCH_BOTH)) {
	$axis_id = $r['id'];
	$bg_name = $r['en_name'];
	$bg_desc = $r['en_desc'];
	
	if(!isset($axis_stat[$axis_id])) {
		continue;
	}
	$axis_list[$axis_id]=array_unique($axis_list[$axis_id]);
	$data = $pdo->query("SELECT COUNT(id) FROM statiments WHERE axis_id=$axis_id");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$axis_total = $r['COUNT(id)'];
	$data = $pdo->query("SELECT COUNT(stet.id) FROM statis_stat stet join statiments s on stet.state_id = s.id where s.axis_id = $axis_id and stet.id = " . $id . "");
			$r = $data->fetch(PDO::FETCH_BOTH);
			$axis_total_d = $r['COUNT(stet.id)'];

//Показва избраните изречения за всеки "axes"
	$chosen_statis = '';
	foreach($axis_list[$axis_id] as $axis){
		$chosen_statis .= $axis . "\n";
	}

	$level_axes = percent(sizeof($axis_list[$axis_id]), $axis_total);
	$table_result.= '<br><a title="'.quot($bg_desc).'">* <b/>'.quot($bg_name).'<a title="'.$chosen_statis.'">, '.$level_axes.'%<a title="Shows what is the significance of one personality property compare to other psychological variables from the test."></b> significance</a></br>'."\n";
}		
$table_result.='</td><tr/>';
$table_result .= '<center/></table>';
echo $table_result;
echo '</br>Download and read the full description:</br><form action="http://testrain.info/download/Full_Description_en.pdf" target="_blank" method="get"><input type="submit" value="Full Description"></form><br/>';
echo '</br>'.CONTRIBUTION.'</br>';
require "end.php";
?>
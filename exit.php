<?php
require "header.php";
if(!array_key_exists('id', $_GET)){
	die();
}
$id = $_GET['id'];
validateInt($id);
echo '<form id="the_form" method="POST" action="tests.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">';

echo '<input type="hidden" name="id" value="'.$id.'">';
//Показва съобщение за резултата с текущото ID
echo'<center><b>'.ID.'<br></b>'.TIP2.'<b>'.$id.'</b><center/>';
echo '</br><input type="submit" value="Other tests"/><br/>';
$table_result = '<table class="borders"><tr><th colspan="2"><center>'.RESULTS.'<center/></th><center/><br/></tr>';
$sum_pos=0;$count_pos=0;
$sum_neg=0;$count_neg=0;
$sum_ambi=0;$count_ambi=0;
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

//Показва "плътността" на избраните емоции.
	$table_result .= '<tr><td style="border: 1px solid #c0c0c0;"><a title="'.quot($script_name).', '.quot($script_desc).'"><b>* '.quot($en_name).'</b></a></td>';
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

//Показва резултати за предимството на "сценариите".
$table_result.= '<tr><th colspan="2"><center><br/><b>'.CONFIRMED.'</b><center/></th><tr/>';

$data_s = $pdo->query('SELECT miniscripts.id, miniscripts.bg_name, miniscripts.domain1_id, miniscripts.domain2_id, miniscripts.bg_name, miniscripts.en_desc, miniscripts.en_name FROM miniscripts inner join miniscripts_stat on miniscripts.id = miniscripts_stat.miniscript_id WHERE miniscripts_stat.id='.$id.'');
	
while($r = $data_s->fetch(PDO::FETCH_BOTH)){
//Показва id на потвърдените miniscripts;
//$table_result .= '<a title="'.quot($r['bg_desc']).'">'.$r['id'].$r['bg_name'].'</a>'; 
$table_result .= '<tr><td colspan="2" align="left" style="border-right: none; border: 1px solid #c0c0c0;">* <b><a title="'.quot($r['bg_name']).', '.quot($r['en_desc']).'">'.$r['en_name'].'</a></b>, ';
			
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

//$table_result.= '<tr><th colspan="2"><center><br/><b>СЪЗДАЙ СВОЯ "КАРТА НА ЧУВСТВАТА"!<center/><form action="http://testrain.info/download/Flowscape.pdf" target="_blank" method="get"><input type="submit" value="Виж как става"></form></b><center/></th><tr/>';

//-------------------->

$table_result.= '<tr><th colspan="2"><center><br/><b>'.SECONDARY.'</b><center/></th><tr/>';

//------------>Показва колко от снимките са разпознати.
$recognition=0;
$photoes = $pdo->query("Select SUM(label) FROM photoes_stat WHERE id=$id");
$r = $photoes->fetch(PDO::FETCH_BOTH);
$recognition= $r['SUM(label)'];
$table_result.= '<tr><td style="border: 1px solid #c0c0c0;"><b>Guessing: </b></td><td style="border: 1px solid #c0c0c0;"><p class="desc-res2" align="right">Successfully guessed: <b>'.$recognition.' from 5 pictures</b></p></td><tr/>';
//------------>

//------------>Показва съотношението между положителните и отрицателните емоции според стойностите от слайдера: "AFFECT MANAGEMENT"
if($count_pos==0) $count_pos=1;
if($count_neg==0) $count_neg=1;
if($count_ambi==0) $count_ambi=1;
//За премахване на стойностите на слайдера от съотношението между + и - емоции замени "sum_pos/neg..." със "count_pos/neg..."
$table_result.= '<tr><td style="border: 1px solid #c0c0c0;"><b>'.RATIO.'</b></td>';

$score_neg=scores_level($sum_neg, $count_neg-$count_ambi);
$score_pos=scores_level($sum_pos, $count_pos-$count_ambi);
$score_ambi=scores_level($sum_ambi, $count_ambi);
$score_group=$score_neg.$score_pos;
$data = $pdo->query("SELECT en_name,en_desc FROM management WHERE score_group LIKE '%$score_group%'");
$r = $data->fetch(PDO::FETCH_BOTH);
if ($r){
	$bg_name = $r['en_name'];
	$bg_desc = $r['en_desc'];
}else{
	$bg_name='';
	$bg_desc='';
}
$posi = percent($sum_pos, $sum_pos+$sum_neg+$sum_ambi);
$nega = percent($sum_neg, $sum_pos+$sum_neg+$sum_ambi);
$ambi = percent($sum_ambi, $sum_pos+$sum_neg+$sum_ambi);

$table_result.= '<td style="border: 1px solid #c0c0c0;">- '.POSITIVE.': '.percent($sum_pos, $sum_pos+$sum_neg+$sum_ambi).'%<br>- '.NEGATIVE.': '.percent($sum_neg, $sum_pos+$sum_neg+$sum_ambi).'%<br>- '.AMBIVALENT.': '.percent($sum_ambi, $sum_pos+$sum_neg+$sum_ambi).'%</td>';

//Demorest --> Показва избраните изречения за всеки "axis"

$table_result.= '<tr><th colspan="2"><center><br/><b>List of selected themes: </b><center/></th><tr/>';
$sel_states = $pdo->query("SELECT * FROM states_stat WHERE id=$id");
while($r3 = $sel_states->fetch(PDO::FETCH_BOTH)){
	$s_id=$r3['state_id'];
	$s_sl=$r3['s_slider'];
	
	$data_s = $pdo->query("SELECT en_name, bg_name, axis_id FROM statements WHERE id = $s_id LIMIT 1");
	$rs = $data_s->fetch(PDO::FETCH_BOTH);
	$axis_id = intval($rs['axis_id']);
	$bg_name = $rs['en_name'];
	
	$data_sc = $pdo->query("SELECT en_name, en_desc FROM axis WHERE id=$axis_id");
	$rsc = $data_sc->fetch(PDO::FETCH_BOTH);
	$axis_name = $rsc['en_name'];
	$axis_desc = $rsc['en_desc'];
	
	$table_result .= '<tr><td style="border: 1px solid #c0c0c0;"><a title="'.quot($axis_name).', '.quot($axis_desc).'"><b>- '.quot($bg_name).'</a></td>';
	$table_result .= '<td style="border: 1px solid #c0c0c0;">'.SIGNIFICANCE.'<b> '.$s_sl.'</b></td></tr>';
}	
$table_result.='</td><tr/>';
$table_result .= '<center/></table>';
echo $table_result;
echo '</br>'.CONTRIBUTION.'</br>';
require "end.php";
?>
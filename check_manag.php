<?php
require "headerbg.php";
echo '<center>Раздел `Общи Катерогии и Съотношения`<center/>';
$count_data = $pdo->query("SELECT id FROM id_stat ORDER BY id");
$count = 0;
$last = -1;
$id_array = array();
while($r = $count_data->fetch(PDO::FETCH_BOTH))
{
	if($r['id'] != $last)
	{
		$last = $r['id'];
		$id_array[] = $last;
		$count++;
	}
}
echo '<table class="borders">';
echo '<tr><th><a title="Personality Id">№</a></th>
<th><a title="Делът на положителните емоционални изживявания,">Положителни състояния</a></th>
<th><a title="Делът на отрицателните емоционални изживявания, ">Отрицателни състояния</a></th>
<th><a title="Делът на противоречивите емоционални изживявания, ">Противоречиви състояния</a></th>
<th><a title="Ниво на отразен самоконтрол.">Самоконтрол</a></th>
</tr>';
/*
<th><a title="Ако броят на избраните емоции надхвърля 5, съответно броят на избраните сценарии  също, това може да е признак за сложна емоционалнo себеописание.">Брой емоции</a></th>
<th><a title="Ако броят на избраните емоции надхвърля 5, съответно броят на избраните сценарии  също, това може да е признак за сложна емоционалнo себеописание.">Брой сценарии</a></th>
*/

for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];

//...............................................
$posi = '';
$nega = '';
$manag = 0;
$sum_pos=0;$count_pos=0;
$sum_neg=0;$count_neg=0;
$sum_ambi=0;$count_ambi=0;
$sel_emotions = $pdo->query("SELECT * FROM emotions_stat WHERE id=$current_id");
while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
	$e_id=$r['emotion_id'];
	$e_sl=$r['e_slider'];
	
	$data = $pdo->query("SELECT manag FROM id_stat WHERE id = $current_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$manag = $r['manag'];
	
	$data = $pdo->query("SELECT domain_id, dimension_id, string_id, tension_id FROM emotions WHERE id = $e_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$domain_id = intval($r['domain_id']);
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
$manag = $id_manag;

$count_e=0;	
	$sel_emotions = $pdo->query("Select * FROM emotions_stat WHERE id=$current_id");
	while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
		$count_e+=1;
		}
$count_s=0;	
	$sel_scripts = $pdo->query("Select * FROM miniscripts_stat WHERE id=$current_id");
	while($r = $sel_scripts->fetch(PDO::FETCH_BOTH)){
		$count_s+=1;
		}
//...........................>

		echo '<tr><td><center>'.$current_id.'</center></td>
		<td><center>'.$posi.'%</center></td>
		<td><center>'.$nega.'%</center></td>
		<td><center>'.$ambi.'%</center></td>
		<td>'.$bg_name.'</td>
		
		</tr>';
/*............................> Check the id_stat DB:
		<td><center>'.$count_e.'</center></td>
		<td><center>'.$count_s.'</center></td>
		echo '<tr><td><center>('.$current_id.',</center></td>
		<td><center>'.$posi.',</center></td>
		<td><center>'.$nega.',</center></td>
		<td><center>'.$ambi.',</center></td>
		<td><center>'.$manag.'),</center></td>
		</tr>';*/

		
}
echo '</table>';
require "end.php";
?>
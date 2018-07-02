<?php
require "headerbg.php";
echo '<center>Раздел `Обща статистика`<center/>';
$count_data = $pdo->query("SELECT id FROM id_stat ORDER BY id");
$count = 0;
$last = -1;
//--------------------->
$domain = array();
$statement1 = $pdo->query("SELECT * FROM domains s, emotions sc WHERE sc.domain_id = s.id ");
while($row = $statement1->fetch(PDO::FETCH_BOTH))
{
	$domain[$row['id']] = $row['domain_id'];
	
}
//--------------------->
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
echo '<tr>
<th>№</th>
<th>Дял положителни</th>
<th>Дял отрицателни</th>
<th>Афективно управление</th>
<th>Избрани семейства</th>
<th>Сума + семейства</th>
<th>Сума - семейства</th>
<th>Избрани сценараии</th>
<th>Време за участие</th>
</tr>';

for($k = 0; $k<$count; $k++)
{ 
$current_id = $id_array[$k];
$posi = '';
$nega = '';
$manag = 0;
$domain_row_array = array();
$domains_category_array = array();
$sum_pos=0;$count_pos=0;
$sum_neg=0;$count_neg=0;
$sel_emotions = $pdo->query("SELECT * FROM emotions_stat WHERE id=$current_id");
while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
	$e_id=$r['emotion_id'];
	$e_sl=$r['e_slider'];
	
	$data = $pdo->query("SELECT manag FROM id_stat WHERE id = $current_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$manag = $r['manag'];
	$data = $pdo->query("SELECT domain_id, valence_id, string_id, tension_id FROM emotions WHERE id = $e_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$domain_id = intval($r['domain_id']);
	$dimension_id = $r['valence_id'];
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
}		
$score_neg=scores_level($sum_neg, $count_neg);
$score_pos=scores_level($sum_pos, $count_pos);
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
//---------------------------->
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
//----------------------------->
$domains_category_array ['pos'] = array();
$domains_category_array ['neg'] = array();
for($i = 0; $i<DOMAINS_NUMBER; $i++)
	{
		$domain_row_array[] = 0;
		$domains_category_array ['pos'][] = 0;
		$domains_category_array ['neg'][] = 0;
	}
$count_em=0;	
	$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
			
		$e_id = $r['emotion_id'];
		if($e_id != -1)$domain_row_array[$domain[$e_id]] = 1;
		$count_em+=1;
		
		{
			$emotion = $pdo->query("SELECT * FROM emotions WHERE id = $e_id")->fetch(PDO::FETCH_BOTH);
			if ($emotion['valence_id'] == 0)
				$domains_category_array ['pos'][$domain[$e_id]] = 1;
			else
				$domains_category_array ['neg'][$domain[$e_id]] = 1;
		}
	}
//----------------------------->Time
	$sel_emotions = $pdo->query("SELECT * FROM choice_stat WHERE id=$current_id LIMIT 1");
	while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
		$start=$r['start'];
		$stress=$r['end'];
		
		$data = $pdo->query("SELECT time FROM miniscripts_stat WHERE id = $current_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$end = $r['time'];
	}

	$datetime1 = new DateTime($start);
	$datetime2 = new DateTime($stress);
	$datetime3 = new DateTime($end);

	if(isset($id)) {
		$interval = $datetime1->diff($datetime3);
	}
	else {
		$interval = $datetime1->diff($datetime2);
	}
//---------------------------->
		echo '<tr><td><center>'.$current_id.'</center></td>
		<td><center>'.$posi.'%</center></td>
		<td><center>'.$nega.'%</center></td>
		<td><center>'.$id_manag.'</center></td>
		
		<td><center>'.array_sum($domain_row_array).'</center></td>
		<td><center>'.array_sum($domains_category_array['pos']).'</center></td>
		<td><center>'.array_sum($domains_category_array['neg']).'</center></td>
		
		<td><center>'.$count_s.'</center></td>
		<td>'.$interval->format('%H:%i:%s').'</td>
		</tr>';
}
echo '</table>';
require "end.php";
?>
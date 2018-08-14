<?php
require "headerbg.php";
echo '<table class="borders">';
echo '<tr><td>№</td>';
/**/
$string = array();
$domain = array();
$emotions = array();

$label = $pdo->query("SELECT id, en_name, bg_name FROM emotions");
while($row = $label->fetch(PDO::FETCH_BOTH))
{
	$bg_name = $row['en_name'];
	$emotions[$row['id']] ='<a title="'.quot($row['bg_name']).'">'. $bg_name.'</a>';
}

$statement = $pdo->query("SELECT id, string_id FROM emotions");
while($row = $statement->fetch(PDO::FETCH_BOTH))
{
	$string[$row['id']] = $row['string_id'];
		
}

$statement1 = $pdo->query("SELECT * FROM domains s, emotions sc WHERE sc.domain_id = s.id ");
while($row = $statement1->fetch(PDO::FETCH_BOTH))
{
	$domain[$row['id']] = $row['domain_id'];
	
}
for($i=0;$i<DOMAINS_NUMBER;$i++){
	$domain_data = $pdo->query("select en_name, bg_name from domains where id = ". $i . "");
	
	$name = "WRONG";
	while($r = $domain_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}
	echo '<td><center>D'.$i.''.$bg_name.'_'.$en_name.'</center></td>';
	//echo '<td><center>D'.$i.''.$bg_name.'</center></td>';
}
for($i=0;$i<MINISCRIPTS_NUMBER;$i++){
	$miniscript_data = $pdo->query("select en_name, bg_name from miniscripts where id = ". $i . "");
		
	$name = "WTF";
	while($r = $miniscript_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}

	echo '<td><center>S'.$i.''.$bg_name.'_'.$en_name.'</center></td>';
	//echo '<td><center>D'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
	//echo '<td><center>S'.$i.''.$bg_name.'</center></td>';
}
//------------------>
echo '<td><b>Count allFamilies</b></td>';
echo '<td><b>Count posFamilies</b></td>';
echo '<td><b>Count negFamilies</b></td>';
echo '<td><b>Count Scripts</b></td>';
echo '<td><center><b>Affective Management</b></center></td>';
//echo '<td><center><b>Time</b></center></td>';
//------------------>
echo '</tr>';
//..................> Печати само потвърдените
//$count_data = $pdo->query("SELECT id FROM id_stat ORDER BY id");
//..................> Печати всички
$count_data = $pdo->query("SELECT id FROM choice_stat ORDER BY id");
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

for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];
	$emotion_row_array = array();
	$domain_row_array = array();
	$domains_category_array = array();
	$miniscripts_row_array = array();
/*$data = $pdo->query("SELECT * FROM miniscripts_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
if(!isset($id)) continue;*/
//$data = $pdo->query("SELECT * FROM emotions_stat WHERE id = $current_id LIMIT 1");
$data = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id LIMIT 1");
//$data = $pdo->query("SELECT * FROM gros_stat WHERE id = $current_id LIMIT 1");
//$data = $pdo->query("SELECT * FROM status_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
//if($id>102){
if(!isset($id)) continue;

	for($i = 0; $i<EMOTIONS_NUMBER; $i++)
	{
		$emotion_row_array[] = 0;
	}
	$domains_category_array ['pos'] = array();
	$domains_category_array ['neg'] = array();
	for($i = 0; $i<DOMAINS_NUMBER; $i++)
	{
		$domain_row_array[] = 0;
		$domains_category_array ['pos'][] = 0;
		$domains_category_array ['neg'][] = 0;
	}
	for($i = 0; $i<MINISCRIPTS_NUMBER; $i++)
	{
		$miniscripts_row_array[] = 0;
	}
	$count_em=0;	
	$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
			
		$e_id = $r['emotion_id'];
		if($e_id!=-1) $emotion_row_array[$e_id] = 1;
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
	//var_dump($domain_row_array); echo "<br>";
	//echo "number of selected domains: " . array_sum($domain_row_array) . "<br>";
	$count_sc=0;	
	$data = $pdo->query("SELECT miniscript_id FROM miniscripts_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$mi_id = $r['miniscript_id'];
		if($mi_id!=-1) $miniscripts_row_array[$mi_id] = 1;
		
		$count_sc+=1;
	}
//------------------------>
$posi = '';
$nega = '';
$manag = 0;
$sum_pos=0;$count_pos=0;
$sum_neg=0;$count_neg=0;
$sel_emotions = $pdo->query("SELECT * FROM emotions_stat WHERE id=$current_id");
while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
	$e_id=$r['emotion_id'];
	$e_sl=$r['e_slider'];
	
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
$posi = percent($sum_pos, $sum_pos+$sum_neg);
$nega = percent($sum_neg, $sum_pos+$sum_neg);
//---------------------------->
	echo '<tr><td><center>'.$current_id.'</center></td>';
	for($i=0;$i<DOMAINS_NUMBER;$i++)
		if($domain_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
	/*Показва вместо "1/0" предимството и плътността за даденото емоционално семейство.
		else{
			$mas = "";
			$e_slider = "";
			$sel_emotions = $pdo->query("SELECT * FROM emotions_stat e join emotions em on em.id = e.emotion_id WHERE e.id = " . $current_id . "");
			$emo_count = 0;
			while($r1 = $sel_emotions->fetch(PDO::FETCH_BOTH)){
					$mas = $r1['emotion_id'];
					$e_slider = $r1['e_slider'];
					if(floor($mas/9) != $i)continue;
					$string_id = $string[$mas];
					$tension_id = $tension[$mas];
									
					if ($string_id == 0){			
						$e_sl=(($r1['e_slider']*0.4)+$tension_id) ."";
						}
						else if($string_id == 1){
						$e_sl=(($r1['e_slider']*0.6)+$tension_id) ."";
						}
						else if($string_id == 2){
						$e_sl=(($r1['e_slider']*0.8)+$tension_id) ."";
						}
						
			}
			//echo '<td><center><b>'.round(($e_sl),0).'<b/></center></td>';
			echo '<td><center><b>'.$e_slider.'<b/></center></td>';
		}*/
	for($i=0;$i<MINISCRIPTS_NUMBER;$i++)
		if($miniscripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
	
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
		echo '<td><center>'.array_sum($domain_row_array).'</center></td>';
		echo '<td><center>'.array_sum($domains_category_array['pos']).'</center></td>';
		echo '<td><center>'.array_sum($domains_category_array['neg']).'</center></td>';
		echo '<td><center>'.$count_sc.'</center></td>';
		echo '<td><center>'.$id_manag.'</center></td>';
		//echo '<td>'.$interval->format('%H:%i:%s').'</td>';
	echo '</tr>';
	//}
}
echo '</table>';
require "end.php";
?>
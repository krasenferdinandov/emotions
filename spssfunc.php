<?php
require "header.php";
echo '<table class="borders">';
echo '<tr><th>Id</th>';

function isInDomain($emotion_search){
	return (floor($emotion_search));
}
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
	//echo '<td><center>D'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
	//echo '<td><center>F'.$i.'_'.$en_name.'</center></td>';
	//echo '<td><center>F'.$i.'</center></td>';
}
//------------------>
for($i=0;$i<THEMES_NUMBER;$i++){
	$script_data = $pdo->query("select en_name, bg_name from statements where id = ". $i . "");
		
	$name = "WTF";
	while($r = $script_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}
    //echo '<td><center>T'.$i.'_'.$en_name.'</center></td>';
	//echo '<td><center>T'.$i.'</center></td>';
}
for($i=0;$i<MINISCRIPTS_NUMBER;$i++){
	$miniscript_data = $pdo->query("select en_name, bg_name from miniscripts where id = ". $i . "");
		
	$name = "WTF";
	while($r = $miniscript_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}
	//echo '<td><center>S'.$i.', '.$en_name.'</center></td>';
	//echo '<td><center>S'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
	//echo '<td><center>S'.$i.'</center></td>';
}
echo '<td><center><b>Брой разпознати</b></center></td>';
echo '<td><center><b>Брой семейства</b></center></td>';
echo '<td><center><b>Брой положителни</b></center></td>';
echo '<td><center><b>Брой отрицателни</b></center></td>';
echo '<td><center><b>Брой теми</b></center></td>';
echo '<td><center><b>Брой сценарии</b></center></td>';
echo '<td><center><b>Потискане</b></center></td>';
echo '<td><center><b>Преоценка</b></center></td>';
echo '<td><center><b>Афективно управление</b></center></td>';
echo '<td><b>Начало</b></td>';
echo '<td><b>Край</b></td>';
echo '</tr>';

$count_data = $pdo->query("SELECT id FROM states_stat ORDER BY id");

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
	$miniscripts_row_array = array();
	$scripts_row_array = array();
	
//$data = $pdo->query("SELECT * FROM emotions_stat WHERE id = $current_id LIMIT 1");
//$data = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id LIMIT 1");
//$data = $pdo->query("SELECT * FROM states_stat WHERE id = $current_id LIMIT 1");
$data = $pdo->query("SELECT * FROM gros_stat WHERE id = $current_id LIMIT 1");
//$data = $pdo->query("SELECT * FROM status_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
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
	for($i = 0; $i<THEMES_NUMBER; $i++)
	{
		$scripts_row_array[] = 0;
	}
	for($i = 0; $i<MINISCRIPTS_NUMBER; $i++)
	{
		$miniscripts_row_array[] = 0;
	}
	$count_e=0;	
	$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
			
		$e_id = $r['emotion_id'];
		if($e_id!=-1) $emotion_row_array[$e_id] = 1;
		if($e_id != -1)$domain_row_array[$domain[$e_id]] = 1;
		
		$count_e+=1;
	}
	
	
	$count_s=0;	
	$data_s = $pdo->query("SELECT * FROM states_stat WHERE id = $current_id");
	while($r = $data_s->fetch(PDO::FETCH_BOTH)) {
		$si_id = $r['state_id'];
				
		if($si_id!=-1) $scripts_row_array[$si_id] = 1;
		$count_s+=1;
	}
	
	$count_m=0;	
	$data = $pdo->query("SELECT miniscript_id FROM miniscripts_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$mi_id = $r['miniscript_id'];
		if($mi_id!=-1) $miniscripts_row_array[$mi_id] = 1;
		$count_m+=1;
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

/*for($i=0;$i<DOMAINS_NUMBER;$i++)
		if($domain_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
for($i=0;$i<THEMES_NUMBER;$i++)
		if($scripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
		
for($i=0;$i<MINISCRIPTS_NUMBER;$i++)
		if($miniscripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';*/
//---------------------------->
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
//---------------------------->
$count_p=0;	
	$data = $pdo->query("SELECT label FROM photoes_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$p_id = $r['label'];
		if($p_id != "0") $count_p+=1;

	}
//---------------------------->
$sel_emotions = $pdo->query("SELECT * FROM choice_stat WHERE id=$current_id LIMIT 1");
	while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
		$start=$r['end'];
		
		$data = $pdo->query("SELECT time FROM miniscripts_stat WHERE id = $current_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$stress = $r['time'];	
		
		$data = $pdo->query("SELECT timing FROM gros_stat WHERE id = $current_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$end = $r['timing'];
		
		
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
$sum_sup=0;
$sum_reap=0;
$selection = $pdo->query("SELECT * FROM gros_stat WHERE id=$current_id");
while($r = $selection->fetch(PDO::FETCH_BOTH)){
	$g_id=$r['state_id'];
	$g_sl=$r['g_slider'];
	
	$data = $pdo->query("SELECT axis_id FROM gros WHERE id = $g_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$axis_id = $r['axis_id'];
			
		if($axis_id == 19){
			$sum_sup+=$g_sl;
		}
		if($axis_id == 20){
			$sum_reap+=$g_sl;
		}
}		

//---------------------------->
//echo '<td>'.$count_e.'</td>';
echo '<td><center>'.$count_p.'</center></td>';
echo '<td><center>'.array_sum($domain_row_array).'</center></td>';
echo '<td><center>'.array_sum($domains_category_array['pos']).'</center></td>';
echo '<td><center>'.array_sum($domains_category_array['neg']).'</center></td>';
echo '<td><center>'.$count_s.'</center></td>';
echo '<td><center>'.$count_m.'</center></td>';
echo '<td><center>'.$sum_sup.'</center></td>';
echo '<td><center>'.$sum_reap.'</center></td>';
echo '<td><center>'.$id_manag.'</center></td>';
echo '<td><center>'.$start.'</center></td>';
echo '<td><center>'.$end.'</center></td>';
echo '</tr>';

}

echo '</table>';
require "end.php";
?>
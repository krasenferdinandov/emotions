<?php
require "header.php";
echo '<table class="borders">';
echo '<tr><td>№</td>';

/*<td><b>Self Complexity</b></td>
<td><b>Balance Defusion</b></td>*/

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
	echo '<td><center>D'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
	//echo '<td><center>D'.$i.', '.$bg_name.'</center></td>';
}
//------------------>
echo '<td><center><b>Affective Management, Осъзнатост</b></center></td>';
//------------------>
for($i=0;$i<THEMES_NUMBER;$i++){
	$script_data = $pdo->query("select en_name, bg_name from statements where id = ". $i . "");
		
	$name = "WTF";
	while($r = $script_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}

	echo '<td><center>T'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
}
for($i=0;$i<MINISCRIPTS_NUMBER;$i++){
	$miniscript_data = $pdo->query("select en_name, bg_name from miniscripts where id = ". $i . "");
		
	$name = "WTF";
	while($r = $miniscript_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}

	echo '<td><center>S'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
	//echo '<td><center>S'.$i.', '.$bg_name.'</center></td>';
}

echo '</tr>';
//..................> Печати само потвърдените
$count_data = $pdo->query("SELECT id FROM id_stat ORDER BY id");
//..................> Печати всички
//$count_data = $pdo->query("SELECT id FROM choice_stat ORDER BY id");
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
	
/*$data = $pdo->query("SELECT * FROM miniscripts_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
if(!isset($id)) continue;*/

$data = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
//if($id>102){
if(!isset($id)) continue;

	for($i = 0; $i<EMOTIONS_NUMBER; $i++)
	{
		$emotion_row_array[] = 0;
	}
	for($i = 0; $i<DOMAINS_NUMBER; $i++)
	{
		$domain_row_array[] = 0;
	}
	for($i = 0; $i<THEMES_NUMBER; $i++)
	{
		$scripts_row_array[] = 0;
	}
	for($i = 0; $i<MINISCRIPTS_NUMBER; $i++)
	{
		$miniscripts_row_array[] = 0;
	}
	
	$cmpl_label = "";
	$count_e=0;	
	$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
			
		$e_id = $r['emotion_id'];
		if($e_id!=-1) $emotion_row_array[$e_id] = 1;
		if($e_id != -1)$domain_row_array[$domain[$e_id]] = 1;
		
		$count_e+=1;
		if($count_e>=6){
				$count_em = '1';
		}
		else{ 
		$count_em = '0';
		}
	}
	
	$count_m=0;	
	$data = $pdo->query("SELECT miniscript_id FROM miniscripts_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$mi_id = $r['miniscript_id'];
		if($mi_id!=-1) $miniscripts_row_array[$mi_id] = 1;
		
		$count_m+=1;
		if($count_m>=6){
				$count_mi = '1';
		}
		else{ 
		$count_mi = '0';
		}
		
	}

	$count_s=0;	
	$data_s = $pdo->query("SELECT state_id FROM states_stat WHERE id = $current_id");
	while($r = $data_s->fetch(PDO::FETCH_BOTH)) {
		$si_id = $r['state_id'];
		if($si_id!=-1) $scripts_row_array[$si_id] = 1;
		
		$count_s+=1;
		if($count_s>=6){
				$count_sc = '1';
		}
		else{ 
		$count_sc = '0';
		}
		
	}
	
	$am_label = "";
	$data_ma = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id");
	while($r = $data_ma->fetch(PDO::FETCH_BOTH)){
				$manag = $r['manag'];
				$posi = $r['posi']/100;
				$som_name = "";
				if($posi>=0.68){
					$som=4;
					$som_name = '<center>0<center/>';
				}else if($posi>0.56){
					$som=3;
					$som_name = '<center>1<center/>';
				}else if ($posi>0.44) {
					$som=2;
					$som_name = '<center>1<center/>';
				}else if ($posi>0.32) {
					$som=1;
					$som_name = '<center>0<center/>';
				}else{
					$som=0;
					$som_name = '<center>0<center/>';
				}	
				if($manag==0){
				$am_label = '0';
				}
				if($manag==1){
				$am_label = '0';
				}
				if($manag==2){
				$am_label = '1';
				}
				if($manag==3){
				$am_label = '1';
				}
			}
	if (($count_e >=6) && ($count_s >=6)){
		$cmpl_label = '1';
	}
	else {$cmpl_label = '0';}
	
	echo '<tr><td><center>'.$current_id.'</center></td>';
		
	/*echo '<td><center>'.$cmpl_label.'</center></td>';
	echo '<td><center>'.$am_label.'</center></td>';
	echo '<td><center>'.$som.'</center></td>';
	echo '<td><center>'.$som_name.'</center></td>';*/
		
	for($i=0;$i<DOMAINS_NUMBER;$i++)
		if($domain_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
	
	echo '<td><center>'.$manag.'</center></td>';
	
	for($i=0;$i<THEMES_NUMBER;$i++)
		if($scripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
		
	for($i=0;$i<MINISCRIPTS_NUMBER;$i++)
		if($miniscripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
	
	
				
	echo '</tr>';
	//}
}
echo '</table>';
require "end.php";
?>
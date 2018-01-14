<?php
require "header.php";

echo '<table class="borders">';
echo '<tr><th>Id</th>';


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
$string = array();
$domain = array();
$tension = array();
$emotions = array();

$label = $pdo->query("SELECT id, en_name, bg_name FROM emotions");
while($row = $label->fetch(PDO::FETCH_BOTH))
{
	$bg_name = $row['en_name'];
	$emotions[$row['id']] ='<a title="'.quot($row['bg_name']).'">'. $bg_name.'</a>';
}

$statement = $pdo->query("SELECT id, string_id, tension_id FROM emotions");
while($row = $statement->fetch(PDO::FETCH_BOTH))
{
	$string[$row['id']] = $row['string_id'];
	$tension[$row['id']] = $row['tension_id'];	
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
for($i=0;$i<STATES_NUMBER;$i++){
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
	$scripts_row_array = array();
	$miniscripts_row_array = array();
/*$data = $pdo->query("SELECT * FROM miniscripts_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
if(!isset($id)) continue;*/

$data = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
if(!isset($id)) continue;
//if($id>102){
	for($i = 0; $i<EMOTIONS_NUMBER; $i++)
	{
		$emotion_row_array[] = 0;
	}
	for($i = 0; $i<DOMAINS_NUMBER; $i++)
	{
		$domain_row_array[] = 0;
	}
	for($i = 0; $i<STATES_NUMBER; $i++)
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
	
	$count_s=0;	
	$data_s = $pdo->query("SELECT * FROM states_stat WHERE id = $current_id");
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
	
	$am_label = "";
	$data_ma = $pdo->query("SELECT manag FROM id_stat WHERE id = $current_id");
	while($r = $data_ma->fetch(PDO::FETCH_BOTH)){
				$manag = $r['manag'];
			}
	if (($count_e >=6) && ($count_s >=6)){
		$cmpl_label = '1';
	}
	else {$cmpl_label = '0';}
	
	echo '<tr><td><center>'.$current_id.'</center></td>';
	//echo '<td><center>'.$cmpl_label.'</center></td>';
	//echo '<td><center>'.$count_em.'</center></td>';
	//echo '<td><center>'.$count_sc.'</center></td>';
	//echo '<td><center>'.$count_e.'</center></td>';
	//echo '<td><center>'.$count_s.'</center></td>';
	
	for($i=0;$i<DOMAINS_NUMBER;$i++)
		if($domain_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		//else echo '<td><center><b>1<b/></center></td>';
	//Показва вместо "1/0" предимството и плътността за даденото емоционално семейство.
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
		}
	echo '<td><center>'.$manag.'</center></td>';

for($i=0;$i<STATES_NUMBER;$i++)
		if($scripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else {
			$data_t = $pdo->query("SELECT * FROM states_stat WHERE id = " . $current_id . "");
			while($rs = $data_t->fetch(PDO::FETCH_BOTH)) {
			$s_id = $rs['state_id'];
			if($s_id!=$i)continue;
			$s_sl = $rs['s_slider'];
			}
			echo '<td><center><b>'.$s_sl.'<b/></center></td>';
		}			
		//else echo '<td><center><b>1<b/></center></td>';*/
			
for($i=0;$i<MINISCRIPTS_NUMBER;$i++)
		if($miniscripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		//else echo '<td><center><b>1<b/></center></td>';
	
	
	//Показва вместо "1/0" предимството на съответния сценарии.
		else{
			$sel_emotions = $pdo->query("SELECT * FROM emotions_stat e join emotions em on em.id = e.emotion_id WHERE e.id = " . $current_id . "");
			
			$magnification_s = 0;
			
			$data = $pdo->query("SELECT * FROM miniscripts_stat WHERE id =$current_id");
			while ($r = $data->fetch(PDO::FETCH_BOTH)){
				$miniscript_id = $r['miniscript_id'];
				if($miniscript_id!=$i)continue;
				
				if($miniscript_id!=-1) $miniscript_row_array[$miniscript_id] = 1;
				$data_mi = $pdo->query("SELECT miniscripts.id, miniscripts.domain1_id, miniscripts.domain2_id, 
				miniscripts.bg_name,miniscripts.en_name,miniscripts.bg_desc FROM miniscripts inner join miniscripts_stat 
				on miniscripts.id = miniscripts_stat.miniscript_id WHERE miniscript_id = $miniscript_id LIMIT 1");
				while($r = $data_mi->fetch(PDO::FETCH_BOTH)){
					
							$density_em1 = $r['domain1_id'];
					$density_em2 = $r['domain2_id'];
					
					$sel_emotions1 = $pdo->query("SELECT * FROM emotions em join emotions_stat e 
					on em.id = e.emotion_id where e.id = " . $current_id . "");
					$mas1 = "";
					$mas2 = "";
					while($r = $sel_emotions1->fetch(PDO::FETCH_BOTH)){
						if(isInDomain($r['emotion_id']) == $density_em1){
							$mas1 = $r['emotion_id'];
							$e_sl_1=$r['e_slider'];
							$e_tension = $r['tension_id'];
						}
						if(isInDomain($r['emotion_id']) == $density_em2){
							$mas2 = $r['emotion_id'];
							$e_sl_2=$r['e_slider'];
							$e_tension = $r['tension_id'];
						}
					}
								
					$string_id_1 = $string[$mas1];
					$string_id_2 = $string[$mas2];
					$tension_id_1 = $tension[$mas1];
					$tension_id_2 = $tension[$mas2];
					$em1_name = $emotions[$mas1];
					$em2_name = $emotions[$mas2];
					
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
		//$magnification_n = round(($count_e * ($density_em1  + $density_em2))/($count_s), 0) ;
		$magnification_n = round(($count_e * ($e_sl_1  + $e_sl_2))/($count_s), 0) ;		
		}
			}
			echo '<td><center><b>'.$magnification_n.'<b/></center></td>';
		}
	
	echo '</tr>';
	//}
}

echo '</table>';
require "end.php";
?>
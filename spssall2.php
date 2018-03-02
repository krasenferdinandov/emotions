<?php
require "header.php";
echo '<table class="borders">';
echo '<th>Id</th>';
//echo '<tr><td><center>Time</center></td>';

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
$domain = "";
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

for($i=0;$i<EMOTIONS_NUMBER;$i++){
	$emotions_data = $pdo->query("select bg_name, domain_id from emotions where id = ". $i . "");
	$name = "WRONG";
	while($r = $emotions_data->fetch(PDO::FETCH_BOTH))
	{
		$name = $r["bg_name"];
		$domain = $r["domain_id"];
		
	}
	echo '<td>D'.$domain.',E'.$i.','.$name.'</td>';
}
for($i=0;$i<MINISCRIPTS_NUMBER;$i++){
	$miniscript_data = $pdo->query("select bg_name from miniscripts where id = ". $i . "");
		
	$name = "WTF";
	while($r = $miniscript_data->fetch(PDO::FETCH_BOTH))
	{
		$name = $r["bg_name"];
	}

	echo '<td>S'.$i.','.$name.'</td>';
}
echo '</tr>';
//..................> Печати всички
$count_data = $pdo->query("SELECT id FROM choice_stat ORDER BY id");
//$count_data = $pdo->query("SELECT id FROM emotions_stat ORDER BY id");
//..................> Печати само потвърдените
//$count_data = $pdo->query("SELECT id FROM id_stat ORDER BY id");
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
	$miniscripts_row_array = array();

$data = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
//if($id>102){
if(!isset($id)) continue;

	for($i = 0; $i<EMOTIONS_NUMBER; $i++)
	{
		$emotion_row_array[] = 0;
	}
	for($i = 0; $i<MINISCRIPTS_NUMBER; $i++)
	{
		$miniscripts_row_array[] = 0;
	}
	$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		
		$e_id = $r['emotion_id'];
		if($e_id!=-1) $emotion_row_array[$e_id] = 1;
	}
	$data = $pdo->query("SELECT miniscript_id FROM miniscripts_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$mi_id = $r['miniscript_id'];
		if($mi_id!=-1) $miniscripts_row_array[$mi_id] = 1;
	}

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
	
	echo '<tr><td><center>'.$current_id.'</center></td>';
	//echo '<tr><td>'.$interval->format('%H:%i:%s').'</center></td>';	

	
	for($i=0;$i<EMOTIONS_NUMBER;$i++)
		if($emotion_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else{
			$mas = "";
			$sel_emotions = $pdo->query("SELECT * FROM emotions_stat e join emotions em on em.id = e.emotion_id WHERE e.id = " . $current_id . "");
			$emo_count = 0;
			while($r1 = $sel_emotions->fetch(PDO::FETCH_BOTH)){
					$mas = $r1['emotion_id'];
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
			echo '<td><center><b>'.round(($e_sl),0).'<b/></center></td>';
		}
	for($i=0;$i<MINISCRIPTS_NUMBER;$i++)
		if($miniscripts_row_array[$i] != 1)
		echo '<td><center>0</center></td>';
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
		$magnification_n = round(($count_e * ($density_em1  + $density_em2))/($count_s), 0) ; 
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
<?php
require "headerbg.php";
echo '<center>"Избрани сценарии и предимството им"<center/>';

$count_data = $pdo->query("SELECT id FROM id_stat ORDER BY id");
$count = 0;
$last = -1;
$id_array = array();
$emotions = array();

$label = $pdo->query("SELECT id, en_name, bg_name FROM emotions");
while($row = $label->fetch(PDO::FETCH_BOTH))
{
	$bg_name = $row['bg_name'];
	$emotions[$row['id']] ='<a title="'.quot($row['en_name']).'">'. $bg_name.'</a>';
}

$string = array();
$tension = array();
$level = $pdo->query("SELECT id, string_id, tension_id FROM emotions");
while($row = $level->fetch(PDO::FETCH_BOTH))
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
echo '<tr><th>№</th>
<th>Емоционални сценарии</th>
<th><a title="Увеличението показва колко допълнителна емоционална важност е придадена  към значението на един житейски избор, така че да придобие предимството пред другите избори в рамките на групата от емоционални очаквания, за да поддържа впечатление, личното или у другите, че тази специфика е водеща и определя обащата линия на намеренията, поведението, предпочитанията или навиците. Степента на увеличение може да надхвърли 100. Стойността на увеличение има свойството да се превръща и в сила на съпротивление, да се противопоставя на нарастване и взаимно свързване между емоции навици, черти. Колкото по-висока е стойността, толкова повече сцени могат да бъдат свързани в обобщаващ сценарий и да осигурят по-голямо предимство и обратно - колкото по-малка е стойността, толкова по-голямо ше е емоционалното противопоставяне да бъдат свързвани сцени, пориви, навици и намерения по между им.">Предимство</a></th>
</tr>';

for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];
	$miniscript_id_row_array = array();
	
	$data = $pdo->query("SELECT * FROM miniscripts_stat WHERE id =$current_id");
	while ($r = $data->fetch(PDO::FETCH_BOTH)){
		$miniscript_id = $r['miniscript_id'];
		
		$result = -1;
		$data_sub = $pdo->query("select * from id_stat where id=" . $current_id . "");
		while($r3 = $data_sub->fetch(PDO::FETCH_BOTH)){
			$manag = $r3['manag'];
			$data_ma = $pdo->query("SELECT bg_name, en_name FROM management WHERE id LIKE '%$manag%'");
			while($r3 = $data_ma->fetch(PDO::FETCH_BOTH)){
			$manag_name = '<a title="'.quot($r3['en_name']).', '.$r3['bg_name'].'">'.$manag.'</a>';
			}
		
		}
			
	$magnification_n = "?";
		if($miniscript_id!=-1) $miniscript_id_row_array[$miniscript_id] = 1;
		$data_mi = $pdo->query("SELECT miniscripts.id, miniscripts.domain1_id, miniscripts.domain2_id, 
		miniscripts.bg_name,miniscripts.bg_desc FROM miniscripts inner join miniscripts_stat 
		on miniscripts.id = miniscripts_stat.miniscript_id WHERE miniscript_id = $miniscript_id LIMIT 1");
		while($r = $data_mi->fetch(PDO::FETCH_BOTH)){
		
			$miniscript_ttl = '<a title="'.quot($r['bg_desc']).'"> '.$r['bg_name'].'</a>';
					
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
		$magnification_n = round(($count_e * ($density_em1  + $density_em2))/($count_s), 1) ; 
		}
		echo '<tr><td><center>'.$current_id.'</td></center>
		<td>'.$miniscript_ttl.'<br/></td>
		<td><center>'.$magnification_n.'</center></td>
		
		</tr>';
	}
}
echo '</table>';
require "end.php";
?>

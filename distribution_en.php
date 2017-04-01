<?php
require "headerbg.php";
echo '<center><center/>"Selected States and Densities"';

$count_data = $pdo->query("SELECT id FROM id_stat ORDER BY id");
$count = 0;
$last = -1;
$id_array = array();
$script = array();
$domain = array();

$tension = array();
$script = array();
$statement = $pdo->query("SELECT id, string_id, tension_id, dimension_id FROM emotions");
while($row = $statement->fetch(PDO::FETCH_BOTH))
{
	$string[$row['id']] = $row['string_id'];
	$tension[$row['id']] = $row['tension_id'];
	$dimension[$row['id']] = $row['dimension_id'];	
}

$statement1 = $pdo->query("SELECT * FROM scripts s, emotions sc WHERE sc.script_id = s.id ");
while($row = $statement1->fetch(PDO::FETCH_BOTH))
{
	$script[$row['id']] = $row['script_id'];
	
}
$statement1 = $pdo->query("SELECT * FROM domains s, emotions sc WHERE sc.domain_id = s.id ");
while($row = $statement1->fetch(PDO::FETCH_BOTH))
{
	$domain[$row['id']] = $row['domain_id'];
	
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
echo '<tr><th>Id</th>
<th>Selected Emotions</th>
<th>Affective domain</th>
<th><a title="Multiplication of Intensity, Frequency and Duration of The Emotion.">Density</a></th>
<th>Valence</th>
</tr>';

for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];
	$left_row_array = array();
	$sel_emotions = array();
	
	$data = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id");
	$r = $data->fetch(PDO::FETCH_BOTH);		
	$manag = $r['manag'];
	$data_ma = $pdo->query("SELECT bg_name, en_name FROM management WHERE id LIKE '%$manag%'");
		while($r = $data_ma->fetch(PDO::FETCH_BOTH)){
		$manag_name = '<a title="'.quot($r['en_name']).', '.$r['bg_name'].'">'.$manag.'</a>';
		}
			
	$mas = "";
	$sel_emotions = $pdo->query("SELECT * FROM emotions_stat e join emotions em on em.id = e.emotion_id WHERE e.id = " . $current_id . "");
		while($r1 = $sel_emotions->fetch(PDO::FETCH_BOTH)){
				$mas = $r1['emotion_id'];
				$bg_name = $r1['bg_name'];
				$en_name = $r1['en_name'];
				$string_id = $string[$mas];
				$tension_id = $tension[$mas];
				$dimension_id = $dimension[$mas];
				$script_name = $script[$mas];
					if ($script_name == 0){			
					$script_name = 'Affluent striving';
					}
					if ($script_name == 1){			
					$script_name ='Clarification striving';
					}	
					if ($script_name == 2){			
					$script_name ='Anti-Toxic striving';
					}
					if ($script_name == 3){			
					$script_name ='Limitation-remediation striving';
					}
					if ($script_name == 4){			
					$script_name ='Decontamination striving';
					}
					if ($script_name == 5){			
					$script_name ='Demage-Reparaition striving';
					}
				$dimension_name = $dimension[$mas];
					if ($dimension_name == 0){			
					$dimension_name = '+';
					}
					if ($dimension_name == 1){			
					$dimension_name ='-';
					}	
					if ($dimension_name == 99){			
					$dimension_name ='±';
					}
				$domain_name = $domain[$mas];
					if ($domain_name == 0){			
					$domain_name = 'Amusement';
					}
					if ($domain_name == 1){			
					$domain_name ='Sympathy';
					}	
					if ($domain_name == 2){			
					$domain_name ='Enthusiasm';
					}
					if ($domain_name == 3){			
					$domain_name ='Naïvity';
					}
					if ($domain_name == 4){			
					$domain_name ='Terror';
					}
					if ($domain_name == 5){			
					$domain_name ='Rancor';
					}
					if ($domain_name == 6){			
					$domain_name ='Grief';
					}
					if ($domain_name == 7){			
					$domain_name ='Repugnance';
					}
					if ($domain_name == 8){			
					$domain_name ='Coyness';
					}
					if ($domain_name == 9){			
					$domain_name ='Alleviation';
					}
				
				if ($string_id == 0){			
					$e_sl=(($r1['e_slider']*0.4)+$tension_id) ."";
					}
					else if($string_id == 1){
					$e_sl=(($r1['e_slider']*0.6)+$tension_id) ."";
					}
					else if($string_id == 2){
					$e_sl=(($r1['e_slider']*0.8)+$tension_id) ."";
					}
			$mas = '<a title="'. $script_name.'">' .$en_name.'</a>';
			
			echo '<tr><td><center>'.$current_id.'</td></center>
				<td>'.$mas.'</td>
				<td>'.$domain_name.'</td>
				<td><center>'.round (($e_sl),1).'</center></td>
				<td><center>'.$dimension_name.'</center></td>
				</tr>';
		}
}

echo '</table>';
require "end.php";
?>
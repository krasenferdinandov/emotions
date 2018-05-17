<?php
require "headerbg.php";
echo '<center>"Раздел *Общи Катерогии и Съотношения*"<center/>';
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
<th><a title="Времето прекарано с теста.">Време за избор</a></th>
</tr>';
/*
<th><a title="Ако броят на избраните емоции надхвърля 5, съответно броят на избраните сценарии  също, това може да е признак за сложна емоционалнo себеописание.">Брой емоции</a></th>
<th><a title="Ако броят на избраните емоции надхвърля 5, съответно броят на избраните сценарии  също, това може да е признак за сложна емоционалнo себеописание.">Брой сценарии</a></th>
<th><a title="Ниво на отразен самоконтрол.">Самоконтрол</a></th>

*/
for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];
	$posi_row_array = array();
	$nega_row_array = array();
	$ambi_row_array = array();
	$miniscript_id_row_array = array();
	
$data = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id");
$r = $data->fetch(PDO::FETCH_BOTH);
		$posi = $r['posi'];
		$nega = $r['nega'];
		$ambi = $r['ambi'];
		$manag = $r['manag'];
		
		$data_ma = $pdo->query("SELECT bg_name, bg_desc FROM management WHERE id LIKE '%$manag%'");
		while($r = $data_ma->fetch(PDO::FETCH_BOTH)){
		$manag_name = '<a title="'.$r['bg_desc'].'">'.quot($r['bg_name']).'</a>';
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

while($r = $data->fetch(PDO::FETCH_BOTH)) {
		if($posi!=-1) $posi_row_array[$posi] = 1;
		if($nega!=-1) $nega_row_array[$nega] = 1;
		if($ambi!=-1) $ambi_row_array[$nega] = 1;
	}
$data = $pdo->query("SELECT * FROM miniscripts_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];

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

		echo '<tr><td><center>'.$current_id.'</center></td>
		<td><center>'.$posi.'%</center></td>
		<td><center>'.$nega.'%</center></td>
		<td><center>'.$ambi.'%</center></td>
		<td>'.$interval->format('%H:%i:%s').'</td>
		
		</tr>';
		/*
		<td>'.$manag_name.'</td>
		<td><center>'.$count_e.'</center></td>
		<td><center>'.$count_s.'</center></td>
		<td><center>'.$choice.'</center></td><td><center>'.$manag_name.'</center></td>*/
	//}
}
echo '</table>';
require "end.php";
?>
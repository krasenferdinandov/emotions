<?php
require "headerbg.php";
echo '<center><a title="General Proportions and Categories">Раздел `Общи Катерогии и Съотношения`<center/></a>';
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
<th><a title="Numbers of selected emotions. Ако броят на избраните емоции надхвърля 5, съответно броят на избраните сценарии  също, това може да е признак за сложна емоционалнo себеописание.">Брой емоции</a></th>
<th><a title="Numbers of selected scripts. Ако броят на избраните емоции надхвърля 5, съответно броят на избраните сценарии  също, това може да е признак за сложна емоционалнo себеописание.">Брой сценарии</a></th>
</tr>';
for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];
	$posi_row_array = array();
	$nega_row_array = array();
	$miniscript_id_row_array = array();
	$choice_row_array = array();
	
	$data = $pdo->query("SELECT * FROM choice_stat WHERE id = $current_id");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$choice = $r['choice'];
	//if ($choice == "1"){
	
$data = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id");
$r = $data->fetch(PDO::FETCH_BOTH);
		$posi = $r['posi']/100;
		$nega = $r['nega']/100;
		$manag = $r['manag'];
		$som_name = "";
			if($posi>=0.68){
				$som=0;
				$som_name = '<a title="Euphoria, Excessive Optimism, Impulsiveness">Прекомерен оптимизъм<a/>';
			}else if($posi>=0.56){
				$som=1;
				$som_name = '<a title="Good Coping, Optimal Adjustment">Добро напасване<a/>';
			}else if ($posi>=0.44) {
				$som=0;
				$som_name = '<a title="Internal Conflicts, Obsessive mindset">Вътрешни конфликти<a/>';
			}else if ($posi>=0.32) {
				$som=0;
				$som_name = '<a title="Moderate Anxiety or Depression">Тревожни състояния<a/>';
			}else{
				$som=0;
				$som_name = '<a title="Severe Psychopathlogy">Критични състояния<a/>';
			}
		$am_label = "";
				if($manag==0){
				$am_label = 'Успокояващ обмен';
				}
				if($manag==1){
				$am_label = 'Уравновесен обмен';
				}
				if($manag==2){
				$am_label = 'Увличащ обмен';
				}
				if($manag==3){
				$am_label = 'Пристрастяващ обмен';
				}
		
		$data_ma = $pdo->query("SELECT bg_name, en_name FROM management WHERE id LIKE '%$manag%'");
			while($r = $data_ma->fetch(PDO::FETCH_BOTH)){
				$manag_name = '<a title="'.quot($r['bg_name']).', '.$r['en_name'].'">'.$manag.'</a>';
		$data = $pdo->query("SELECT * FROM choice_stat WHERE id = $current_id");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$choice = $r['choice'];
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
		if($nega!=-1) $nega_row_array[$nega] = 1;
	}
		echo '<tr><td><center>'.$current_id.'</center></td>
		<td><center>'.$count_e.'</center></td>
		<td><center>'.$count_s.'</center></td>
		</tr>';
		//<td>'.$som_name.'</td>
		//<td><center>'.$choice.'</center></td><td><center>'.$manag_name.'</center></td>
	//}
}
echo '</table>';
require "end.php";
?>
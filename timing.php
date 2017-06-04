<?php
require "headerbg.php";
echo '<center>Раздел `Време за попълване`<center/>';
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
echo '<tr><th>№</th>
<th>Начало</th>
<th>Междинно</th>
<th>Край</th>
<th>Самоконтрол</th>
</tr>';
//

for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];

//...............................................
$manag = "";
$sel_emotions = $pdo->query("SELECT * FROM choice_stat WHERE id=$current_id");
while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
	$start=$r['start'];
	$stress=$r['end'];
	
	$data = $pdo->query("SELECT time FROM miniscripts_stat WHERE id = $current_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$end = $r['time'];
	
	$data = $pdo->query("SELECT manag FROM id_stat WHERE id = $current_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$manag = $r['manag'];
	
}
//...........................>

		echo '<tr><td><center>'.$current_id.'</center></td>
		<td><center>'.$start.'</center></td>
		<td><center>'.$stress.'</center></td>
		<td><center>'.$end.'</center></td>
		<td><center>'.$manag.'</center></td>
		</tr>';
}
echo '</table>';
require "end.php";
?>
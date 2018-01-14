<?php
require "header.php";
echo '<table class="borders">';
echo '<tr><th>Id</th>';

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
//$count_data = $pdo->query("SELECT id FROM choice_stat ORDER BY id");
//$count_data = $pdo->query("SELECT id FROM emotions_stat ORDER BY id");
//..................> Печати само потвърдените
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

for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];
	$emotion_row_array = array();
	$miniscripts_row_array = array();

$data = $pdo->query("SELECT * FROM emotions_stat WHERE id = $current_id LIMIT 1");
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
	echo '<tr><td><center>'.$current_id.'</center></td>';
	for($i=0;$i<EMOTIONS_NUMBER;$i++)
		if($emotion_row_array[$i] != 1)
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
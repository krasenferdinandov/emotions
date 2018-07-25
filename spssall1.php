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
	$emotions_data = $pdo->query("select bg_name, en_name, domain_id from emotions where id = ". $i . "");
	$name = "WRONG";
	while($r = $emotions_data->fetch(PDO::FETCH_BOTH))
	{
		$name = $r["bg_name"];
		$en_name = $r["en_name"];
		$domain = $r["domain_id"];
		
	}
	echo '<td>D'.$domain.'_E'.$i.'_'.$name.'</td>';
}
for($i=0;$i<MINISCRIPTS_NUMBER;$i++){
	$miniscript_data = $pdo->query("select bg_name, en_name from miniscripts where id = ". $i . "");
		
	$name = "WTF";
	while($r = $miniscript_data->fetch(PDO::FETCH_BOTH))
	{
		$name = $r["bg_name"];
		$en_name = $r["en_name"];
	}

	echo '<td>S'.$i.'_'.$name.'</td>';
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
<?php
require "header.php";
echo '<table class="borders">';
echo '<tr><th>Id</th>';

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
	//echo '<td><center>D'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
	echo '<td><center>F'.$i.'_'.$en_name.'</center></td>';
	//echo '<td><center>F'.$i.'</center></td>';
}
//------------------>
for($i=0;$i<THEMES_NUMBER;$i++){
	$script_data = $pdo->query("select en_name, bg_name from statements where id = ". $i . "");
		
	$name = "WTF";
	while($r = $script_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}
    echo '<td><center>T'.$i.'_'.$en_name.'</center></td>';
	//echo '<td><center>T'.$i.'</center></td>';
}
for($i=0;$i<MINISCRIPTS_NUMBER;$i++){
	$miniscript_data = $pdo->query("select en_name, bg_name from miniscripts where id = ". $i . "");
		
	$name = "WTF";
	while($r = $miniscript_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}
    echo '<td><center>S'.$i.', '.$en_name.'</center></td>';
	//echo '<td><center>S'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
	//echo '<td><center>S'.$i.'</center></td>';
}
echo '<td><center><b>Time, Време</b></center></td>';
echo '</tr>';

$count_data = $pdo->query("SELECT id FROM states_stat ORDER BY id");

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
	
//$data = $pdo->query("SELECT * FROM states_stat WHERE id = $current_id LIMIT 1");
//$data = $pdo->query("SELECT * FROM gros_stat WHERE id = $current_id LIMIT 1");
$data = $pdo->query("SELECT * FROM status_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
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
	$count_e=0;	
	$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
			
		$e_id = $r['emotion_id'];
		if($e_id!=-1) $emotion_row_array[$e_id] = 1;
		if($e_id != -1)$domain_row_array[$domain[$e_id]] = 1;
		
		$count_e+=1;
	}
	
	
	$count_s=0;	
	$data_s = $pdo->query("SELECT * FROM states_stat WHERE id = $current_id");
	while($r = $data_s->fetch(PDO::FETCH_BOTH)) {
		$si_id = $r['state_id'];
				
		if($si_id!=-1) $scripts_row_array[$si_id] = 1;
		$count_s+=1;
	}
	
	$count_m=0;	
	$data = $pdo->query("SELECT miniscript_id FROM miniscripts_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$mi_id = $r['miniscript_id'];
		if($mi_id!=-1) $miniscripts_row_array[$mi_id] = 1;
		$count_m+=1;
	}
echo '<tr><td><center>'.$current_id.'</center></td>';

for($i=0;$i<DOMAINS_NUMBER;$i++)
		if($domain_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
for($i=0;$i<THEMES_NUMBER;$i++)
		if($scripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		/*else {
			$data_t = $pdo->query("SELECT * FROM states_stat WHERE id = " . $current_id . "");
			while($rs = $data_t->fetch(PDO::FETCH_BOTH)) {
			$s_id = $rs['state_id'];
			if($s_id!=$i)continue;
			$s_sl = $rs['s_slider'];
			}
			echo '<td><center><b>'.$s_sl.'<b/></center></td>';
		}*/
		else echo '<td><center><b>1<b/></center></td>';
		
for($i=0;$i<MINISCRIPTS_NUMBER;$i++)
		if($miniscripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
//---------------------------->
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
//---------------------------->
echo '<td>'.$interval->format('%H:%i:%s').'</td>';
echo '</tr>';

}

echo '</table>';
require "end.php";
?>
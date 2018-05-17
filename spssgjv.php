<?php
require "header.php";
echo '<table class="borders">';
echo '<tr><th>Id</th>';

//------------------>
for($i=0;$i<STATES_NUMBER;$i++){
	$script_data = $pdo->query("select en_name, bg_name from gros where id = ". $i . "");
		
	$name = "WTF";
	while($r = $script_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}

	echo '<td><center>T'.$i.''.$en_name.'</center></td>';
}
echo '<td><center><b>Emotions</b></center></td>';
echo '<td><center><b>Scripts</b></center></td>';
echo '<td><center><b>Management</b></center></td>';
echo '</tr>';

$count_data = $pdo->query("SELECT id FROM gros_stat ORDER BY id");

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
	$scripts_row_array = array();
	
$data = $pdo->query("SELECT * FROM gros_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
if(!isset($id)) continue;
	for($i = 0; $i<STATES_NUMBER; $i++)
	{
		$scripts_row_array[] = 0;
	}
	
$data_s = $pdo->query("SELECT * FROM gros_stat WHERE id = $current_id");
while($r = $data_s->fetch(PDO::FETCH_BOTH)) {
	$si_id = $r['state_id'];
	if($si_id!=-1) $scripts_row_array[$si_id] = 1;
			
}
echo '<tr><td><center>'.$current_id.'</center></td>';

for($i=0;$i<STATES_NUMBER;$i++)
		if($scripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else {
			$data_t = $pdo->query("SELECT * FROM gros_stat WHERE id = " . $current_id . "");
			while($rs = $data_t->fetch(PDO::FETCH_BOTH)) {
			$s_id = $rs['state_id'];
			if($s_id!=$i)continue;
			$s_sl = $rs['g_slider'];
			}
			echo '<td><center><b>'.$s_sl.'<b/></center></td>';
		}	
		//else echo '<td><center><b>1<b/></center></td>';
		
	$count_em=0;	
	$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {	
		$e_id = $r['emotion_id'];
			//if($e_id!=-1) $emotion_row_array[$e_id] = 1;
		if($e_id!=-1) $emotion_row_array[$domain[$e_id]] = 1;
		if($e_id != -1)$domain_row_array[$domain[$e_id]] = 1;	
		$count_em+=1;
	}
	
	$count_sc=0;	
	$data = $pdo->query("SELECT miniscript_id FROM miniscripts_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$mi_id = $r['miniscript_id'];
		if($mi_id!=-1) $miniscripts_row_array[$mi_id] = 1;
		$count_sc+=1;	
	}
	
	$data_ma = $pdo->query("SELECT manag FROM id_stat WHERE id = $current_id");
	while($r = $data_ma->fetch(PDO::FETCH_BOTH)){
		$manag = $r['manag'];
	}

echo '<td><center>'.$count_em.'</center></td>';
echo '<td><center>'.$count_sc.'</center></td>';	
echo '<td><center>'.$manag.'</center></td>';

echo '</tr>';
	//}
}

echo '</table>';
require "end.php";
?>
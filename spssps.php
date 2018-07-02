<?php
require "header.php";
echo '<table class="borders">';
echo '<tr><th>Id</th>';
$domain = array();
$statement1 = $pdo->query("SELECT * FROM domains s, emotions sc WHERE sc.domain_id = s.id ");
while($row = $statement1->fetch(PDO::FETCH_BOTH))
{
	$domain[$row['id']] = $row['domain_id'];
	
}
for($i=0;$i<STATES_NUMBER_3;$i++){
	$statis_data = $pdo->query("select id, bg_name, axis_id, subaxis_id from statusments where id = ". $i . "");
	while($r = $statis_data->fetch(PDO::FETCH_BOTH))
	{
		$ids = $r["id"];
		$axis = $r["axis_id"];
		$subaxis = $r["subaxis_id"];
		$bg_name = $r["bg_name"];
	}

	//echo '<td>'.$i.$name.'</td>';
	echo '<td>i'.$ids.'_a'.$axis.'</td>';
    //echo '<td>i'.$ids.'_a'.$axis.', '.$bg_name.'</td>';
	//echo '<td>a'.$axis.'_s'.$subaxis.'</td>';
}
echo '<td><b>all_Families</b></td>';
echo '<td><b>posi_Families</b></td>';
echo '<td><b>neg_Families</b></td>';
echo '<td><center><b>Scripts</b></center></td>';
echo '<td><center><b>Management</b></center></td>';
echo '<td><center><b>Time</b></center></td>';
echo '</tr>';
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
	$stati_row_array = array();
	$domain_row_array = array();
	for($i = 0; $i<STATES_NUMBER_3; $i++)
	{
		$stati_row_array[] = 0;
	}
$data = $pdo->query("SELECT * FROM status_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
if(!isset($id)) continue;

if(!isset($id)) {
				continue;
			}else{
			$data = $pdo->query("SELECT state_id FROM status_stat WHERE id = $current_id");
			while($r = $data->fetch(PDO::FETCH_BOTH)) {
				$s_id = $r['state_id'];
				if($s_id!=-1) $stati_row_array[$s_id] = 1;
			}
			echo '<tr><td><center>'.$current_id.'</center></td>';
			for($i=0;$i<STATES_NUMBER_3;$i++)
				if($stati_row_array[$i] != 1)
					echo '<td><center>0</center></td>';
				else echo '<td><center><b>1<b/></center></td>';			
			}	
$count_em=0;
	$domains_category_array ['pos'] = array();
	$domains_category_array ['neg'] = array();	
	$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {	
		$e_id = $r['emotion_id'];
			//if($e_id!=-1) $emotion_row_array[$e_id] = 1;
		if($e_id!=-1) $emotion_row_array[$domain[$e_id]] = 1;
		if($e_id != -1)$domain_row_array[$domain[$e_id]] = 1;	
		$count_em+=1;
		{
			$emotion = $pdo->query("SELECT * FROM emotions WHERE id = $e_id")->fetch(PDO::FETCH_BOTH);
			if ($emotion['valence_id'] == 0)
				$domains_category_array ['pos'][$domain[$e_id]] = 1;
			else
				$domains_category_array ['neg'][$domain[$e_id]] = 1;
		}
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
echo '<td><center>'.array_sum($domain_row_array).'</center></td>';
echo '<td><center>'.array_sum($domains_category_array['pos']).'</center></td>';
echo '<td><center>'.array_sum($domains_category_array['neg']).'</center></td>';
echo '<td><center>'.$count_sc.'</center></td>';	
echo '<td><center>'.$manag.'</center></td>';
echo '<td>'.$interval->format('%H:%i:%s').'</td>';		
echo '</tr>';
	}
echo '</table>';
require "end.php";
?>
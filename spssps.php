<?php
require "header.php";

echo '<table class="borders">';
echo '<tr><th>Id</th>';
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
	
	
	echo '</tr>';
	}
echo '</table>';
require "end.php";
?>
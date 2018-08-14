<?php
require "headerbg.php";
echo '<table class="borders">';
echo '<tr><th>Id</th>';
$domain = array();
//------------------>
for($i=0;$i<STATES_NUMBER;$i++){
	$script_data = $pdo->query("select en_name, bg_name, axis_id from gros where id = ". $i . "");
		
	$name = "WTF";
	while($r = $script_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
		$axis = $r["axis_id"];
	}

	echo '<td><center>i'.$i.'_a'.$axis.'</center></td>';
}
echo '<td><center><b>Потискане</b></center></td>';
echo '<td><center><b>Преоценка</b></center></td>';
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
	$states_row_array = array();
	$domain_row_array = array();
	
$data = $pdo->query("SELECT * FROM gros_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
if(!isset($id)) continue;
	for($i = 0; $i<STATES_NUMBER; $i++)
	{
		$states_row_array[] = 0;
	}
	
$data_s = $pdo->query("SELECT * FROM gros_stat WHERE id = $current_id");
while($r = $data_s->fetch(PDO::FETCH_BOTH)) {
	$si_id = $r['state_id'];
	if($si_id!=-1) $states_row_array[$si_id] = 1;
			
}
echo '<tr><td><center>'.$current_id.'</center></td>';

for($i=0;$i<STATES_NUMBER;$i++)
		if($states_row_array[$i] != 1)
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
//---------------------------->
$sum_sup=0;
$sum_reap=0;
$selection = $pdo->query("SELECT * FROM gros_stat WHERE id=$current_id");
while($r = $selection->fetch(PDO::FETCH_BOTH)){
	$g_id=$r['state_id'];
	$g_sl=$r['g_slider'];
	
	$data = $pdo->query("SELECT axis_id FROM gros WHERE id = $g_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$axis_id = $r['axis_id'];
			
		if($axis_id == 20){
			$sum_sup+=$g_sl;
		}
		if($axis_id == 19){
			$sum_reap+=$g_sl;
		}
}		

//---------------------------->
echo '<td><center>'.$sum_sup.'</center></td>';
echo '<td><center>'.$sum_reap.'</center></td>';
echo '</tr>';
	//}
}

echo '</table>';
require "end.php";
?>
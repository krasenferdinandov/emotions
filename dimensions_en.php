<?php
require "headerbg.php";
echo '<center>Раздел: "Eмоционален стил"<center/>';
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
echo '<tr>
<th>ID</th>
<th>Dimensions</th>
<th>Significance</th>
</tr>';

for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];
	$sel_states = $pdo->query("SELECT * FROM states_stat WHERE id=$current_id");
	while($rs = $sel_states->fetch(PDO::FETCH_BOTH)){
	$s_id=$rs['state_id'];
	$s_sl=$rs['s_slider'];
	
		$data = $pdo->query("SELECT en_name, bg_name, axis_id FROM statements WHERE id = $s_id LIMIT 1");
		while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$axis_id = intval($r['axis_id']);
		$en_name = $r['en_name'];
		
		$data1 = $pdo->query("SELECT en_name, en_desc FROM axis WHERE id=$axis_id");
		$re = $data1->fetch(PDO::FETCH_BOTH);
		$axis_name = $re['en_name'];
		$axis_desc = $re['en_desc'];
		}
	echo '<tr>
	<td>'.$current_id.'</td>
	<td><a title="'.quot($axis_name).', '.quot($axis_desc).'">'.quot($en_name).'</a></td>
	<td><center>'.$s_sl.'0%<center/></td>
	</tr>';	
	}
}
echo '</table>';
require "end.php";
?>
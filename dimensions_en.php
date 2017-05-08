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
<th>Percents</th>
</tr>';

/*<th><a title=" (S) Брой свързани с емоции изречения за психологически показатели: (J) Брой избрани твърдения за леви или десни убеждения: (D) Сума от плътностите на емоциите, свързани с изречения за психологически показатели.">Покaзатели</a></th>
<th><a title="Type of Magnification">Тип увеличаване<a/></th>
*/

for($k = 0; $k<$count; $k++)
{ 
	$current_id = $id_array[$k];
		
	$axis_stat=array();
	$axis_stat_count=0;
	$axis_list=array();
		
	$sel_states = $pdo->query("SELECT * FROM states_stat WHERE id=$current_id");
	while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
		$state_id = $r['state_id'];
		$data = $pdo->query("SELECT bg_name, axis_id FROM statements WHERE id = $state_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$bg_name = $r['bg_name'];
		$axis = $r['axis_id'];
		
		if(!isset($axis_stat[$axis])){
			$axis_stat[$axis] = 0;
			$axis_list[$axis] = array();
		}

		
		$axis_stat[$axis] += 1;
		$axis_list[$axis][] = $bg_name;
		$axis_stat_count += 1;
	}
	
	$axis_name = "";
	$axis_count_total=0;
	
	$all_axis = $pdo->query("SELECT id, en_name, en_desc FROM axis ORDER BY id");
				
		while($r = $all_axis->fetch(PDO::FETCH_BOTH)) {
			$axis_id = $r['id'];
			$name = $r['en_name'];
			$desc = $r['en_desc'];
						
			if(!isset($axis_stat[$axis_id])) {
				continue;
			}else{
				$axis_name = '<a title="'.quot($desc).'">'.quot($name).'</a>';
			}
						
			$axis_list[$axis_id]=array_unique($axis_list[$axis_id]);
			$data = $pdo->query("SELECT COUNT(stat.id) FROM states_stat stat join statements s on stat.state_id = s.id where s.axis_id = $axis_id and stat.id = $current_id");
			$r = $data->fetch(PDO::FETCH_BOTH);
			$axis_total = $r['COUNT(stat.id)'];
			
			
			echo '<tr>
			<td>'.$current_id.'</td>
			<td>'.$axis_name.'<td>
			'.$axis_total.'0%
			</tr>';	
		}
	}
echo '</table>';
require "end.php";
?>
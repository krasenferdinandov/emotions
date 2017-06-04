<?php
require "header.php";

echo '<table class="borders">';
echo '<tr><th>Id</th>';


for($i=0;$i<TRAITS_NUMBER;$i++){
	$traits_data = $pdo->query("select d.label from traits di 
		join factors d on di.factor_id=d.id
		where di.id = ". $i . "");
		
	$name = "WRONG";
	while($r = $traits_data->fetch(PDO::FETCH_BOTH))
	{
		$name = $r["label"];
	}

	//echo '<td>'.$i.$name.'</td>';
	echo '<td>'.$name.'</td>';
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
	$traits_row_array = array();

	for($i = 0; $i<TRAITS_NUMBER; $i++)
	{
		$traits_row_array[] = 0;
	}
	$data = $pdo->query("SELECT id, trait_id FROM traits_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$s_id = $r['trait_id'];
		if($s_id!=-1) $traits_row_array[$s_id] = 1;
		
	}
$data = $pdo->query("SELECT * FROM traits_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);$id = $r['id'];
if(!isset($id)) continue;	
	echo '<tr><td><center>'.$current_id.'</center></td>';
	for($i=0;$i<TRAITS_NUMBER;$i++)
		if($traits_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
		
	echo '</tr>';
	}
echo '</table>';
require "end.php";
?>
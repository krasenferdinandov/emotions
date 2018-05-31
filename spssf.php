<?php
require "header.php";
echo '<table class="borders">';
echo '<tr><th>Id</th>';

for($i=0;$i<PHOTOES_NUMBER;$i++){
	$photoes_data = $pdo->query("select en_name, bg_name from photoes where id = ". $i . "");
		
	$name = "WTF";
	while($r = $photoes_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}
	echo '<td><center>P'.$i.', '.$en_name.''.$bg_name.'</center></td>';
}
for($i=0;$i<PHOTOES_NUMBER;$i++){
	$photoes_data = $pdo->query("select en_alt, bg_alt from photoes where id = ". $i . "");
		
	$name = "WTF";
	while($r = $photoes_data->fetch(PDO::FETCH_BOTH))
	{
		$e_name = $r["en_alt"];
		$b_name = $r["bg_alt"];
	}
	echo '<td><center>P'.$i.', '.$e_name.''.$b_name.'</center></td>';
}
echo '</tr>';
$count_data = $pdo->query("SELECT id FROM photoes_stat ORDER BY id");
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
	$photoes_row_array = array();

	$data = $pdo->query("SELECT * FROM  photoes_stat WHERE id = $current_id");
	for($i = 0; $i<PHOTOES_NUMBER; $i++)
	{
		$photoes_row_array[] = 0;
	}
	while($r = $data->fetch(PDO::FETCH_BOTH))
	{
		$photoes_row_array[$r['state_id']] = $r['label'];
	}

	echo '<tr><td><center>'.$current_id.'</center></td>';

	for($i=0;$i<PHOTOES_NUMBER;$i++)
		if($photoes_row_array[$i] != "1")
			echo '<td><center>0</center></td>';
		else {
			echo '<td><center><b>'.$photoes_row_array[$i].'<b/></center></td>';
		}
	for($i=0;$i<PHOTOES_NUMBER;$i++)
		if($photoes_row_array[$i] != "0")
			echo '<td><center>0</center></td>';
		else {
			echo '<td><center><b>1<b/></center></td>';
		}
	echo '</tr>';
}

echo '</table>';
require "end.php";
?>
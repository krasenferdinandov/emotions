<?php
	require "header.php";
	require "js/blockback.js";
	if(array_key_exists('id', $_GET)){
		echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
		//echo '<br>ID: ' . $_GET['id'];
		$id = $_GET['id'];
	}
	validateInt($id);
	if(array_key_exists('choice', $_GET)){
		echo '<input type="hidden" name="choice" value="'.$_GET['choice'].'">';
		//echo '<br>Choice: ' . $_GET['choice'];
		$c = $_GET['choice'];
	}
	validateInt($c);
	echo'<center><b>'.ID.'</b>'.TIP3.'<b>'.$id.'&choice='.$c.'</b></center><br>';
	echo '<center><b>TEST RESULTS:</b></center>';
	$table_result = '<center><table style="border: 1px solid #c0c0c0;">';
	$axis_stat=array();
	$axis_stat_count=0;
	$axis_list=array();
	$axis_list_subaxis=array();

	$dbs = array ("statoments", "statiments", "statyments", "statusments");
	$dbstats = array ("statos_stat", "statis_stat", "statys_stat", "status_stat");
	$db_id = intval ($c) - 1;

	$sel_states = $pdo->query("SELECT * FROM " . $dbstats[$db_id] . " WHERE id=$id");
	while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
		$state_id = $r['state_id'];
	
		$data = $pdo->query("SELECT en_name, axis_id, subaxis_id FROM " . $dbs [$db_id] . " WHERE id = $state_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$bg_name = $r['en_name'];
		$axis = $r['axis_id'];
		$subaxis = $r['subaxis_id'];

		if(!isset($axis_stat[$axis])){
			$axis_stat[$axis] = 0;
			$axis_list[$axis] = array();
			$axis_subaxis[$axis] = array();
			$axis_list_subaxis[$axis] = array();
		}
		
		$axis_stat[$axis] += 1;
		$axis_list[$axis][] = $bg_name;
		if(!isset ($axis_list_subaxis[$axis][$subaxis]))
		{
			$axis_list_subaxis[$axis][$subaxis] = array ();
		}
		$axis_list_subaxis[$axis][$subaxis][] = $bg_name;
		if($subaxis!=-1){
			if(!isset($axis_subaxis[$axis][$subaxis])){
				$axis_subaxis[$axis][$subaxis]=0;
			}
			$axis_subaxis[$axis][$subaxis]+=1;
		}
		$axis_stat_count += 1;
	}
	//Показва процентите
	$axis_count_total=0;
	$sel_axis = $pdo->query("SELECT id,en_name,en_desc FROM axis ORDER BY id");

	while($r = $sel_axis->fetch(PDO::FETCH_BOTH)) {
		$axis_id = $r['id'];
		$bg_name = $r['en_name'];
		$bg_desc = $r['en_desc'];
		
		if(!isset($axis_stat[$axis_id])) {
			continue;
		}
		
		$axis_list[$axis_id]=array_unique($axis_list[$axis_id]);
		$data = $pdo->query("SELECT COUNT(id) FROM " . $dbs [$db_id] . " WHERE axis_id=$axis_id");
		$r = $data->fetch(PDO::FETCH_BOTH);
		
		$axis_total = $r['COUNT(id)'];
		//Показва избраните изречения за всеки "axis"
		
		$chosen_states = '';
		$substates = array ();
		foreach($axis_list[$axis_id] as $axis){
			$chosen_states .= $axis . "\n";
			$substates[] = $axis;
		}
		
		$level_axis = percent(count($axis_list[$axis_id]), $axis_total);
			
		$count_axis = count($axis_list[$axis_id]);
		$table_result.= '<tr><td><a title="'.$chosen_states.'"><b> #'.quot($bg_name).'</b></a>; '.$count_axis.' from '. $axis_total.' sentances ('.$level_axis.'%);</a><br></td><td class="top"><input type="button" data-id="axis' . $axis_id . '" class="show" value="read"></td>'."</tr>";
		$table_result.='<tr><td colspan="2" style="border: 1px solid #c0c0c0;"><label class="desc-res4" style="display: none;" id="axis' . $axis_id . '">'. $bg_desc .'</br></label></td></tr>';
			
		$index = 0;
		//Показва избраните изречения за дадения показател
		if($c == '1' or $c == '4') {
			foreach($axis_subaxis[$axis_id] as $subaxis => $count){
				$data = $pdo->query("SELECT COUNT(subaxis_id) FROM " . $dbs[$db_id] . " WHERE subaxis_id=$subaxis AND axis_id=$axis_id");
				$r = $data->fetch(PDO::FETCH_BOTH);
				$subaxis_total = $r['COUNT(subaxis_id)'];
				$data = $pdo->query("SELECT * FROM subaxis WHERE id=$subaxis");
				$r = $data->fetch(PDO::FETCH_BOTH);
				$bg_name = $r['en_name'];
				$bg_desc = $r['en_desc'];
				
				$table_result.= '<tr><td><a title="';
				
				for ($i = 0 ; $i < $count ; $i ++) {
					$table_result .= $axis_list_subaxis[$axis_id][$subaxis][$i] . "\n";
				}
				
				$table_result.='"> *'.quot($bg_name).'</a>; '.$count.' от '. $subaxis_total.' sentances;</a><br></td>'.'<td class="top"><input type="button" data-id="subaxis' . $subaxis . '" class="show" value="read"></td>'."</tr>";
				$table_result.='<tr><td colspan="2"><label class="desc-res4" style="display: none;" id="subaxis' . $subaxis . '">'. $bg_desc .'</label></td></tr>';
			}
		}
	}
	$table_result .= '<center/></table>';
	echo $table_result;
	echo '<br><center><div><b>Tests left:</b><br><a href="tests.php?id=' . $id . '"><input type="button" value="Choose"></a></div></center></br>';
	echo '</br>'.CONTRIBUTION.'</br>';
	require ("js/showText.js");
	require "end.php";
?>
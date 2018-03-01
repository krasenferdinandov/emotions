<?php
	require "headerbg.php";
	require "js/blockback.js";
	if(array_key_exists('id', $_GET)){
		
		//echo '<br>ID: ' . $_GET['id'];
		$id = $_GET['id'];
	}
	else
	{
		redirect ('photoesbg.php');
	}
	echo'<center><b>'.ID.'</b>'.TIP4.'<b>'.$id.'</b><center/><br>';
	echo '<center><b>ALL TESTS RESULTS:</b></center>';
	$table_result = '<center><table style="border: 1px solid #c0c0c0;">';
	$axis_stat=array();
	$axis_stat_count=0;
	$axis_list=array();

	$sel_states = $pdo->query("SELECT * FROM statos_stat WHERE id=$id");
	while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
		$state_id = $r['state_id'];
		$data = $pdo->query("SELECT en_name, axis_id, subaxis_id FROM statoments WHERE id = $state_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$bg_name = $r['en_name'];
		$axis = $r['axis_id'];
		$subaxis = $r['subaxis_id'];

		if(!isset($axis_stat[$axis])){
			$axis_stat[$axis] = 0;
			$axis_list[$axis] = array();
			$axis_subaxis[$axis] = array();
		}
	
		$axis_stat[$axis] += 1;
		$axis_list[$axis][] = $bg_name;
		if($subaxis!=-1){
			if(!isset($axis_subaxis[$axis][$subaxis])){
				$axis_subaxis[$axis][$subaxis]=0;
			}
			$axis_subaxis[$axis][$subaxis]+=1;
		}
		$axis_stat_count += 1;
	}

	$sel_states = $pdo->query("SELECT * FROM statis_stat WHERE id=$id");
	while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
		$state_id = $r['state_id'];
		$data = $pdo->query("SELECT en_name, axis_id FROM statiments WHERE id = $state_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$bg_name = $r['en_name'];
		$axis = $r['axis_id'];

		if(!isset($axis_stat[$axis])){
			$axis_stat[$axis] = 0;
			$axis_list[$axis] = array();
			$axis_subaxis[$axis] = array();
		}
		$axis_stat[$axis] += 1;
		$axis_list[$axis][] = $bg_name;
		$axis_stat_count += 1;
	}

	$sel_states = $pdo->query("SELECT * FROM statys_stat WHERE id=$id");
	while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
		$state_id = $r['state_id'];
		$data = $pdo->query("SELECT en_name, axis_id FROM statyments WHERE id = $state_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$bg_name = $r['en_name'];
		$axis = $r['axis_id'];

		if(!isset($axis_stat[$axis])){
			$axis_stat[$axis] = 0;
			$axis_list[$axis] = array();
			$axis_subaxis[$axis] = array();
		}
		$axis_stat[$axis] += 1;
		$axis_list[$axis][] = $bg_name;
		$axis_stat_count += 1;
	}

	$sel_states = $pdo->query("SELECT * FROM status_stat WHERE id=$id");
	while($r = $sel_states->fetch(PDO::FETCH_BOTH)){
		$state_id = $r['state_id'];
		$data = $pdo->query("SELECT en_name, axis_id FROM statusments WHERE id = $state_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$bg_name = $r['en_name'];
		$axis = $r['axis_id'];

		if(!isset($axis_stat[$axis])){
			$axis_stat[$axis] = 0;
			$axis_list[$axis] = array();
			$axis_subaxis[$axis] = array();
		}
		$axis_stat[$axis] += 1;
		$axis_list[$axis][] = $bg_name;
		$axis_stat_count += 1;
	}
	//Показва процентите
	$axis_count_total=0;
	$sel_axis = $pdo->query("SELECT id, en_name, en_desc FROM axis ORDER BY id");
	//$table_result.='<tr><td style="border-right: none; border: 0px solid #c0c0c0;" colspan="1">';
	while($r = $sel_axis->fetch(PDO::FETCH_BOTH)) {
		$axis_id = $r['id'];
		$bg_name = $r['en_name'];
		$bg_desc = $r['en_desc'];
		
		if(!isset($axis_stat[$axis_id])) {
			continue;
		}
		
		$data = $pdo->query("SELECT id FROM statoments WHERE axis_id=$axis_id");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$axis_total = $data->rowCount ();
		
		$data = $pdo->query("SELECT id FROM statiments WHERE axis_id=$axis_id");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$axis_total += $data->rowCount ();
		
		$data = $pdo->query("SELECT id FROM statyments WHERE axis_id=$axis_id");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$axis_total += $data->rowCount ();
		
		$data = $pdo->query("SELECT id FROM statusments WHERE axis_id=$axis_id");
		$r = $data->fetch(PDO::FETCH_BOTH);
		
		$axis_list[$axis_id]=array_unique($axis_list[$axis_id]);
		$axis_total += $data->rowCount ();
		
		//Показва избраните изречения за всеки "axis"
		$chosen_states = '';
		$substates = array ();
		foreach($axis_list[$axis_id] as $axis){
			$chosen_states .= $axis . "\n";
			$substates[] = $axis;
		}	
				
		$level_axis = percent(count($axis_list[$axis_id]), $axis_total);
		
		$count_axis = count($axis_list[$axis_id]);
		$table_result.= '<tr><td><a title="'.$chosen_states.'"><b> #'.quot($bg_name).'</b></a>; Избра '.$count_axis.' от '. $axis_total.' sentances ('.$level_axis.'%);</a><br></td><td class="top"><input type="button" data-id="axis' . $axis_id . '" class="show" value="read"></td>'."</tr>";
		$table_result.='<tr><td style="border: 1px solid #c0c0c0;" colspan="2"><label class="desc-res2" style="display: none;" id="axis' . $axis_id . '">'. $bg_desc .'</br></label></td></tr>';
		
		$index = 0;
		//Показва избраните изречения за дадения показател
		foreach($axis_subaxis[$axis_id] as $subaxis => $count){
			$data = $pdo->query("SELECT COUNT(subaxis_id) FROM statoments WHERE subaxis_id=$subaxis AND axis_id=$axis_id");
			$r = $data->fetch(PDO::FETCH_BOTH);
			$subaxis_total = $r['COUNT(subaxis_id)'];
			$data = $pdo->query("SELECT * FROM subaxis WHERE id=$subaxis");
			$r = $data->fetch(PDO::FETCH_BOTH);
			$bg_name = $r['en_name'];
			$bg_desc = $r['en_desc'];
			
			$table_result.= '<tr><td><a title="';
			
			for ($i = 0 ; $i < $count ; $i ++) {
				$table_result .= $substates [$index] . "\n";
				$index ++;
			}
			
			$table_result.='"> +'.quot($bg_name).'</a>; '.$count.' от '. $subaxis_total.' sentances;</a><br></td>'.'<td class="top"><input type="button" data-id="subaxis' . $subaxis . '" class="show" value="read"></td>'."</tr>";
			$table_result.='<tr><td colspan="2"><label class="desc-res2" style="display: none;" id="subaxis' . $subaxis . '">'. $bg_desc .'"</label></td></tr>';
		}
	}
	$table_result .= '<center/></table>';
	echo $table_result;
	echo '</br>'.CONTRIBUTION.'</br>';
	require ("js/showText.js");
	echo '<script src="js/refreshBack.js"></script>';
	echo '<script>refreshBack("photoes.php")</script>';
	require "end.php";
?>
<?php
require "header.php";
echo '<table class="borders">';
echo '<tr><th>Id</th>';
function ed ($category, $total)
{
	if($category>0 && $total > 0)
		return -1*($category/$total)*log($category/$total);
	else
		return 0;
}
function isInDomain($emotion_search){
	return (floor($emotion_search));
}
$string = array();
$domain = array();
$emotions = array();

$label = $pdo->query("SELECT id, en_name, bg_name FROM emotions");
while($row = $label->fetch(PDO::FETCH_BOTH))
{
	$bg_name = $row['en_name'];
	$emotions[$row['id']] ='<a title="'.quot($row['bg_name']).'">'. $bg_name.'</a>';
}

$statement = $pdo->query("SELECT id, string_id FROM emotions");
while($row = $statement->fetch(PDO::FETCH_BOTH))
{
	$string[$row['id']] = $row['string_id'];
		
}

$statement1 = $pdo->query("SELECT * FROM domains s, emotions sc WHERE sc.domain_id = s.id ");
while($row = $statement1->fetch(PDO::FETCH_BOTH))
{
	$domain[$row['id']] = $row['domain_id'];
	
}
for($i=0;$i<DOMAINS_NUMBER;$i++){
	$domain_data = $pdo->query("select en_name, bg_name from domains where id = ". $i . "");
	
	$name = "WRONG";
	while($r = $domain_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}
	//echo '<td><center>D'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
	//echo '<td><center>F'.$i.'_'.$en_name.'</center></td>';
	//echo '<td><center>F'.$i.'</center></td>';
}
//------------------>
for($i=0;$i<THEMES_NUMBER;$i++){
	$script_data = $pdo->query("select en_name, bg_name from statements where id = ". $i . "");
		
	$name = "WTF";
	while($r = $script_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}
    //echo '<td><center>T'.$i.'_'.$en_name.'</center></td>';
	//echo '<td><center>T'.$i.'</center></td>';
}
for($i=0;$i<MINISCRIPTS_NUMBER;$i++){
	$miniscript_data = $pdo->query("select en_name, bg_name from miniscripts where id = ". $i . "");
		
	$name = "WTF";
	while($r = $miniscript_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
	}
	//echo '<td><center>S'.$i.', '.$en_name.'</center></td>';
	//echo '<td><center>S'.$i.', '.$en_name.', '.$bg_name.'</center></td>';
	//echo '<td><center>S'.$i.'</center></td>';
}
for($i=0;$i<STATES_NUMBER;$i++){
	$script_data = $pdo->query("select en_name, bg_name, axis_id from gros where id = ". $i . "");
		
	$name = "WTF";
	while($r = $script_data->fetch(PDO::FETCH_BOTH))
	{
		$en_name = $r["en_name"];
		$bg_name = $r["bg_name"];
		$axis = $r["axis_id"];
		
		if ($axis == 19){			
		$label= "S";
		}
		else 
		{
		$label= "R";
		}
	}
	//echo '<td><center>'.$label.''.$i.'</center></td>';
}
echo '<td><center><b>1. Успешно разпознати емоции (Ekman & Friesen 1975)</b></center></td>';
echo '<td><center><b>2. Общ брой избрани семейства (Фердинандов 2018)</b></center></td>';
echo '<td><center><b>2.1 Брой положителни семейства (Фердинандов 2018)</b></center></td>';
echo '<td><center><b>2.2 Брой отрицателни семейства (Фердинандов 2018)</b></center></td>';
echo '<td><center><b>3. Брой свързани теми (Demorest 2008)</b></center></td>';
echo '<td><center><b>4. Брой припознати сценарии (Tomkins 1978)</b></center></td>';
echo '<td><center><b>5. Ниво на потискане (Gross 2001)</b></center></td>';
echo '<td><center><b>6. Ниво на преоценка (Gross 2001)</b></center></td>';
echo '<td><center><b>7. Ниво на импулсивността (Tomkins 1978)</b></center></td>';
//echo '<td><center><b>Начало</b><center></td>';
//echo '<td><center><b>Край</b><center></td>';
//echo '<td><center><b>Общо време (H:i:s)</b><center></td>';
echo '<td><center><b>8. Общо време за участие, в минути (Bassili 1996)</b><center></td>';
echo '<td><center><b>9. Достъпност на идентификациите (Bousfield & Sedgwick 1944)</b><center></td>';
echo '<td><center><b>10. Ниво на фрустрация (Brown & Farber 1951)</b><center></td>';
echo '<td><center><b>11. Разграничаване на емоции (Scott 1966)</b><center></td>';
echo '<td><center><b>12. Обективно двусмислие (Scott 1966)</b><center></td>';
echo '<td><center><b>13. Размер на емоционалните загуби (Kahneman & Tversky 1972)</b><center></td>';
echo '<td><center><b>14. Ниво на конфликтите (Kaplan 1972)</b><center></td>';
echo '<td><center><b>15. Контрасти в амбивалентността (Katz 1986)</b><center></td>';
echo '<td><center><b>16. Потенциално противоречие (Thompson et al. 1995)</b><center></td>';
//echo '<td><center><b>15.0 Потенциално противоречие 2 (Thompson et al. 1995)</b><center></td>';
echo '<td><center><b>16.1 Подобие между противоположни състояния (Thompson et al. 1995)</b><center></td>';
echo '<td><center><b>16.2 Изразеност на противоречията (Thompson et al. 1995)</b><center></td>';
echo '<td><center><b>17. Ниво на  преживяна фрустрация, с градиращ праг (Priester & Petty 1996)</b><center></td>';
echo '<td><center><b>18. Ниво на  преживяна фрустрация, с рязък праг (Priester & Petty 1996)</b><center></td>';
echo '<td><center><b>19. Амбивалентна реакция (Choi & Choi 2002)</b><center></td>';
echo '<td><center><b>20. Пропорционалност в преценките (Schwartz 2002)</b><center></td>';
//echo '<td><center><b>19.0 Емоционално благополучие, с pi (Larsen 2008)</b><center></td>';
echo '<td><center><b>21. Емоционално благополучие (Larsen 2009)</b><center></td>';
echo '<td><center><b>22. Общо емоционално разнообразие (Quoidbach et al. 2014)</b><center></td>';
echo '<td><center><b>22.1 Разнообразие в положителните състояния (Quoidbach et al. 2014)</b><center></td>';
echo '<td><center><b>22.2 Разнообразие в отрицателните състояния (Quoidbach et al. 2014)</b><center></td>';
echo '<td><center><b>23. Общ емоционален шанс (Tversky & Kahneman 1981)</b><center></td>';
echo '<td><center><b>23.1 Емоционален боншанс (Tversky & Kahneman 1981)</b><center></td>';
echo '<td><center><b>23.2 Емоционален малшанс (Tversky & Kahneman 1981)</b><center></td>';
echo '</tr>';

$count_data = $pdo->query("SELECT id FROM states_stat ORDER BY id");

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
	$emotion_row_array = array();
	$domain_row_array = array();
	$miniscripts_row_array = array();
	$scripts_row_array = array();
	
//$data = $pdo->query("SELECT * FROM emotions_stat WHERE id = $current_id LIMIT 1");
//$data = $pdo->query("SELECT * FROM id_stat WHERE id = $current_id LIMIT 1");
//$data = $pdo->query("SELECT * FROM states_stat WHERE id = $current_id LIMIT 1");
$data = $pdo->query("SELECT * FROM gros_stat WHERE id = $current_id LIMIT 1");
//$data = $pdo->query("SELECT * FROM status_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
if(!isset($id)) continue;
	for($i = 0; $i<EMOTIONS_NUMBER; $i++)
	{
		$emotion_row_array[] = 0;
	}
	$domains_category_array ['pos'] = array();
	$domains_category_array ['neg'] = array();
	for($i = 0; $i<DOMAINS_NUMBER; $i++)
	{
		$domain_row_array[] = 0;
		$domains_category_array ['pos'][] = 0;
		$domains_category_array ['neg'][] = 0;
	}
	for($i = 0; $i<THEMES_NUMBER; $i++)
	{
		$scripts_row_array[] = 0;
	}
	for($i = 0; $i<MINISCRIPTS_NUMBER; $i++)
	{
		$miniscripts_row_array[] = 0;
	}
	$count_e=0;	
	$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
			
		$e_id = $r['emotion_id'];
		if($e_id!=-1) $emotion_row_array[$e_id] = 1;
		if($e_id != -1)$domain_row_array[$domain[$e_id]] = 1;
		
		$count_e+=1;
	}
	$data = $pdo->query("SELECT * FROM gros_stat WHERE id = $current_id LIMIT 1");
$r = $data->fetch(PDO::FETCH_BOTH);
$id = $r['id'];
if(!isset($id)) continue;
	for($i = 0; $i<STATES_NUMBER; $i++)
	{
		$scripts_row_array[] = 0;
	}	
	
	$count_s=0;	
	$data_s = $pdo->query("SELECT * FROM states_stat WHERE id = $current_id");
	while($r = $data_s->fetch(PDO::FETCH_BOTH)) {
		$si_id = $r['state_id'];
				
		if($si_id!=-1) $scripts_row_array[$si_id] = 1;
		$count_s+=1;
	}
	
	$count_m=0;	
	$data = $pdo->query("SELECT miniscript_id FROM miniscripts_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$mi_id = $r['miniscript_id'];
		if($mi_id!=-1) $miniscripts_row_array[$mi_id] = 1;
		$count_m+=1;
	}
//------------------------>
$posi = '';
$nega = '';
$manag = 0;
$sum_pos=0;$count_pos=0;
$sum_neg=0;$count_neg=0;
$sel_emotions = $pdo->query("SELECT * FROM emotions_stat WHERE id=$current_id");
while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
	$e_id=$r['emotion_id'];
	$e_sl=$r['e_slider'];
	
	$data = $pdo->query("SELECT domain_id, valence_id, string_id, tension_id FROM emotions WHERE id = $e_id LIMIT 1");
	$r = $data->fetch(PDO::FETCH_BOTH);
	$domain_id = intval($r['domain_id']);
	$dimension_id = $r['valence_id'];
	$e_string = $r['string_id'];
	$e_tension = $r['tension_id'];
	
		if ($e_string == 0){			
		$density= (($e_sl*0.4)+$e_tension);
		}
		else if($e_string == 1){
		$density=(($e_sl*0.6)+$e_tension);
		}
		else if($e_string == 2){
		$density=(($e_sl*0.8)+$e_tension);
		}
		
		/*if($dimension_id == 0){
			$sum_pos+=$density;
			$count_pos+=1;
		}
		if($dimension_id == 1){
			$sum_neg+=$density;
			$count_neg+=1;
		}*/
		if($dimension_id == 0){
			$sum_pos+=$e_sl;
			$count_pos+=1;
		}
		if($dimension_id == 1){
			$sum_neg+=$e_sl;
			$count_neg+=1;
		}
}		
$score_neg=scores_level($sum_neg, $count_neg);
$score_pos=scores_level($sum_pos, $count_pos);
$score_group=$score_neg.$score_pos;

$data = $pdo->query("SELECT id,bg_name,bg_desc FROM management WHERE score_group LIKE '%$score_group%'");
$r = $data->fetch(PDO::FETCH_BOTH);
$id_manag = 99;

if ($r){
	$id_manag = $r['id'];
	$bg_name = $r['bg_name'];
	$bg_desc = $r['bg_desc'];
}else{
	$bg_name='';
	$bg_desc='';
}
$posi = percent($sum_pos, $sum_pos+$sum_neg);
$nega = percent($sum_neg, $sum_pos+$sum_neg);
//---------------------------->
echo '<tr><td><center>'.$current_id.'</center></td>';

/*for($i=0;$i<DOMAINS_NUMBER;$i++)
		if($domain_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
for($i=0;$i<THEMES_NUMBER;$i++)
		if($scripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
		
for($i=0;$i<MINISCRIPTS_NUMBER;$i++)
		if($miniscripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		else echo '<td><center><b>1<b/></center></td>';
for($i=0;$i<STATES_NUMBER;$i++)
		if($scripts_row_array[$i] != 1)
			echo '<td><center>0</center></td>';
		/*else {
			$data_t = $pdo->query("SELECT * FROM gros_stat WHERE id = " . $current_id . "");
			while($rs = $data_t->fetch(PDO::FETCH_BOTH)) {
			$s_id = $rs['state_id'];
			if($s_id!=$i)continue;
			$s_sl = $rs['g_slider'];
			}
			echo '<td><center><b>'.$s_sl.'<b/></center></td>';
		}*/
		//else echo '<td><center><b>1<b/></center></td>';
//---------------------------->
$data = $pdo->query("SELECT emotion_id FROM emotions_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
			
		$e_id = $r['emotion_id'];
		if($e_id!=-1) $emotion_row_array[$e_id] = 1;
		if($e_id != -1)$domain_row_array[$domain[$e_id]] = 1;
		
		{
			$emotion = $pdo->query("SELECT * FROM emotions WHERE id = $e_id")->fetch(PDO::FETCH_BOTH);
			if ($emotion['valence_id'] == 0)
				$domains_category_array ['pos'][$domain[$e_id]] = 1;
			else
				$domains_category_array ['neg'][$domain[$e_id]] = 1;
		}
	}
	$positives = array_sum($domains_category_array['pos']); 
	$negatives = array_sum($domains_category_array['neg']); 
	$count_e = array_sum($domain_row_array);
//---------------------------->
$count_p=0;	
	$data = $pdo->query("SELECT label FROM photoes_stat WHERE id = $current_id");
	while($r = $data->fetch(PDO::FETCH_BOTH)) {
		$p_id = $r['label'];
		if($p_id != "0") $count_p+=1;

	}
//---------------------------->
$sel_emotions = $pdo->query("SELECT * FROM choice_stat WHERE id=$current_id LIMIT 1");
	while($r = $sel_emotions->fetch(PDO::FETCH_BOTH)){
		$start=$r['end'];
		
		$data = $pdo->query("SELECT time FROM miniscripts_stat WHERE id = $current_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$stress = $r['time'];	
		
		$data = $pdo->query("SELECT timing FROM gros_stat WHERE id = $current_id LIMIT 1");
		$r = $data->fetch(PDO::FETCH_BOTH);
		$end = $r['timing'];
		
		
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
	$duration = ($interval->h*60 + $interval->i + (floatval($interval->s) / 100));
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
			
		if($axis_id == 19){
			$sum_sup+=$g_sl;
		}
		if($axis_id == 20){
			$sum_reap+=$g_sl;
		}
}		
//---------------------------->

$ed_pos = 0;
$ed_neg = 0;
$ed_tot = 0;
for($J = 0; $J<DOMAINS_NUMBER; $J++)
{
	$ed_pos += ed ($domains_category_array ['pos'][$J], $positives);
	$ed_neg += ed ($domains_category_array ['neg'][$J], $negatives);
}
$ed_tot = $ed_pos + $ed_neg;

//---------------------------->
echo '<td><center>'.$count_p.'</center></td>';
echo '<td><center>'.$count_e.'</center></td>';
echo '<td><center>'.$positives.'</center></td>';
echo '<td><center>'.$negatives.'</center></td>';
echo '<td><center>'.$count_s.'</center></td>';
echo '<td><center>'.$count_m.'</center></td>';
echo '<td><center>'.$sum_sup.'</center></td>';
echo '<td><center>'.$sum_reap.'</center></td>';
echo '<td><center>'.$id_manag.'</center></td>';

//echo '<td><center>'.$start.'</center></td>';
//echo '<td><center>'.$end.'</center></td>';
//echo '<td><center>'.$interval->format('%H:%i:%s').'</center></td>';

$string1 = $duration; 
$string1 = str_replace(".", ",", $string1); 
echo '<td><center>'.$string1.'</center></td>';// Време за участие, в минути.

$string2 = round ((1-exp(-1*$duration))/($count_p + $count_e + $count_s + $count_m), 2);
$string2 = str_replace(".", ",", $string2);
echo '<td><center>'.$string2.'</center></td>';// Достъпност на идентификациите (Bousfield & Sedgwick 1944)

$string3 = round ((($negatives > 0) ? (floatval ($positives*$positives) / $negatives) : 0), 1); 
$string3 = str_replace(".", ",", $string3);
echo '<td><center>'.$string3.'</center></td>';// Ниво на фрустрация (Brown & Farber 1951)

$string4 = round ((($count_e * log (1/$count_e, 2))/log (10, 2)), 1); 
$string4 = str_replace(".", ",", $string4);
echo '<td><center>'.$string4.'</center></td>';// Разграничаване на емоции (Scott 1966)

$string5 = round ((2*$positives + 1) / ($positives + $negatives + 2), 1); 
$string5 = str_replace(".", ",", $string5);
echo '<td><center>'.$string5.'</center></td>';// Обективно двусмислие (Scott 1966)


echo '<td><center>'.round (($positives + $negatives) - ($positives - $negatives), 0).'</center></td>'; // Ниво на конфликтите (Kaplan 1972) --> '.round ((2*$negatives), 0).'

echo '<td><center>'.round ((($positives/10)/(1-($positives/10)))*((($positives/10)/(1-($positives/10)))*($positives - $negatives)), 0).'</center></td>'; // Размер на емоционалните загуби (Kahneman & Tversky 1972)

echo '<td><center>'.round (($positives * $negatives), 0).'</center></td>'; // Контрасти в амбивалентността (Katz 1986)

echo '<td><center>'.round ((-$positives + 3 * $negatives) / 2, 0).'</center></td>'; // Потенциално противоречие 1( Thompson et al. 1995)
//echo '<td><center>'.round ((-$positives + 3 * $negatives), 0).'</center></td>'; // Потенциално противоречие 2( Thompson et al. 1995)

echo '<td><center>'.round ((5-$positives+$negatives), 0).'</center></td>'; // а. Подобие между противоположни състояния (Thompson et al. 1995)

$string6 = round (floatval($positives+$negatives)/2, 1); // б. Изразеност на противоречията(Thompson et al. 1995)
$string6 = str_replace(".", ",", $string6);
echo '<td><center>'.$string6.'</center></td>';

$string7 = round ((5*($negatives/2))/10, 1); 
$string7 = str_replace(".", ",", $string7);
echo '<td><center>'.$string7.'</center></td>';// Ниво на преживяна фрустрация, с градиращ праг (Priester & Petty 1996)

$string8 = round (($negatives > 0) ? (5 * ($negatives * (0.5 * $negatives)) - ($positives * $positives * 1.0 / $negatives)) / 10 : 0, 1); 
$string8 = str_replace(".", ",", $string8);
echo '<td><center>'.$string8.'</center></td>'; // Ниво на преживяна фрустрация, с рязък праг (Priester & Petty 1996)


$string9 = round ((($positives-$negatives)), 1); 
$string9 = str_replace(".", ",", $string9);
echo '<td><center>'.$string9.'</center></td>';// Амбивалентна реакция (Choi & Choi 2002)

$string10 = round (($positives / ($negatives+$positives)), 1); 
$string10 = str_replace(".", ",", $string10);
echo '<td><center>'.$string10.'</center></td>';// Пропорционалност в преценките (Schwartz 2002)

/*$string10 = round (($negatives > 0) ? ($positives / (pi () * $negatives)) : 0, 1); 
$string10 = str_replace(".", ",", $string10);
echo '<td><center>'.$string10.'</center></td>';// Емоционално благополучие, с pi (Larsen 2008)*/

$string11 = round (($negatives > 0) ? ($positives / ($negatives)) : 0, 1); 
$string11 = str_replace(".", ",", $string11);
echo '<td><center>'.$string11.'</center></td>';// Емоционално благополучие, без pi (Larsen 2008)

$string12 = round (($ed_tot), 1); 
$string12 = str_replace(".", ",", $string12);
echo '<td><center>'.$string12.'</center></td>';// Общо емоционално разнообразие (Quoidbach et al. 2014)

$string13 = round (($ed_pos), 1); 
$string13 = str_replace(".", ",", $string13);
echo '<td><center>'.$string13.'</center></td>';// а. Разнообразие в положителните състояния (Quoidbach et al. 2014)

$string14 = round (($ed_neg), 1); 
$string14 = str_replace(".", ",", $string14);
echo '<td><center>'.$string14.'</center></td>';// б. Разнообразие в отрицателните състояния (Quoidbach et al. 2014)

$string15 = round (1-(($positives/($positives+$negatives+1))*($sum_pos/($positives*10+1)))-(($negatives/($positives+$negatives+1))*($sum_neg/($negatives*10+1))), 1); 
$string15 = str_replace(".", ",", $string15);
echo '<td><center>'.$string15.'</center></td>';// Емоционален шанс, Bayes' rule of odds (Ferdinandov 2018)*/

$string16 = round (($positives > 0) ?($positives/($positives+$negatives))*($sum_pos/($positives*10)) :0 ,1);
$string16 = str_replace(".", ",", ""+$string16);
echo '<td><center>'.$string16.'</center></td>';// Емоционален боншанс(Tversky & Kahneman 1981, Ferdinandov 2018)*/

$string17 = round (($negatives > 0) ?($negatives/($positives+$negatives+1))*($sum_neg/($negatives*10)) :0 ,1);
$string17 = str_replace(".", ",", ""+$string17);
echo '<td><center>'.$string17.'</center></td>';// Емоционален малшанс(Tversky & Kahneman 1981, Ferdinandov 2018)*/

//echo '<td><center>'. round (($positives > 0) ?($positives/($positives+$negatives))*($sum_pos/($positives*10)) :0 ,1).'</center></td>';// Емоционален боншанс(Tversky & Kahneman 1981, Ferdinandov 2018)*/

//echo '<td><center>'. round (($negatives > 0) ?($negatives/($positives+$negatives))*($sum_neg/($negatives*10)) :0 ,1).'</center></td>';// Емоционален малшанс(Tversky & Kahneman 1981, Ferdinandov 2018)*/

echo '</tr>';
}
echo '</table>';
require "end.php";
?>
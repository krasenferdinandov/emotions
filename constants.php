<?php
	$a=5;
	define ("NOTE", '<b>NOTE!</b> If you want to read the meaning of any following </br>instruction, word or translation of sentence, take the cursor<br/>of the mouse at any of them and additional title will appear.');
	define ("CHOOSE_EMOTIONS", '<b><center><a title="Most common feelings means that you have to choose the most frequent feelings which happen again and again despite the circumstances. You can select them from all 90 words grouped in 10 categories."> Choose AT LEAST 2 THE MOST COMMON expirienced feelings (e.g. for the last month) from all 10 groups shown below.</b><center/><br/></a>');
	define ("NEXT", 'Go Forward');
	define ("NOT_ENOUGH", '<center><a title="It means that you have not chosen any of choices. Please, go back and choose at least 1 of the three versions to proceed "> Choose at least 1 choice.<center/></a>');
	define ("NOT_ENOUGH_OR_TOO_MANY", '<center><a title="It means that you have not chosen the exact number of states. Please, go back and choose at least 2.">Choose at least 2 emotional state.</center></a>');	
	define ("HOW_FAST", '<a title="It is about enduring of your own feelings or emotional conditions?">How long these chosen states are passing by?</a>');
	define ("FASTEST", '<a title="It means that your condition is very easy to overcome and lasts very short time.">Very Quickly</a>');
	define ("SLOWEST", '<a title="It means that your condition is difficult to overcome and lasts long time.">Very Slowly</a>');
	define ("CHOOSE_STATES", '<b><a title="These words reflect what are the properties of celebratory, ambivalent and harmatic emotion related types of scenes.">Choose only these words, that relate<br/> MOST PRECISELY to selected emotions.</b></a>');
	define ("HOW_LONG", '<a title="It is about enduring of your own feelings or emotional conditions?">How meaningful are these words for you?</a>');
	define ("VERY", '<a title="Focus or Strength of will is at stake.">A lot of meaning</a>');
	define ("LITTLE", '<a title="No focus or strength of will is at stake.">Meaningless</a>');
	define ("SIGNIFICANCE", '<a title="Quality of meaning of selected themes depends on evaluation of its significance. Theme is a term defined as a abstract word or phrase for emotional scene with at least one emotion and and evoking event.: 1-3 is weak; 4-6 moderate; 7-10 strong.">Quale:</a>');
	define ("CONFIRMED", '<a title="You just have confirmed that all of your results are valid.">Confirmed distribution and choosen scripts:</a>');
	define ("RESULTS", '<a title=" Qualities And Properties Of Some Scientific Categories: The percent, shown below means different aspects of personal emotional style, e.g. basic affective scripts, proportion in personal sentimentality and expectations, emotional amplification and magnification of personal life choices and habits: what is the role of emotions and proportion in and their influence over your decision-making everyday not only about very important life issues, but also about insignificant at first glance behavioral and interpersonal matters, enlightened by different psychological dimensions."><b>Primary Results:<b/></a>');		
	define ("DENSITY", '<a title="Maximum density points are 10. Density points of an emotion means how long one emotion would sustain over time without any backing-up and would frame our own mental album and those of the others by emotional expressions in a great deal or by the manner with which one affective state is experienced every-time when it is appeared again and again in a similar circumstances. The probability to sustain with firmness or to happen once again depends on the way one social scene or life situation is set up. If probability if high this rigid state may influence the affective ambiance to be delayed and distributed over time. This is the core meaning of density - to influence significantly interpersonal impact when the emotions are communicated when the same scene is appeared or set up again."> Density: </a>');
	define ("POSITIVE", '<a title="Belongs to a dimension of a rewarding emotional responses, which are primary oriented to experience pleasure and satisfaction states, the general biological feedback of a well-being.">Rewarding states</a>');	
	define ("NEGATIVE", '<a title="Belongs to a family of a punishing emotional responses, which are primary oriented to experience displeasure and dissatisfaction states, the general biological feedback of a stress or disturbance.">Punishing states</a>');
	define ("AMBIVALENT", '<a title="Belongs to a family of contradictive emotional responces, which prepare for the next line of emotions, positive or begative. They are source of stress, but transient and not disturbant. ">Ambivalent states</a>');
	define ("RATIO", '<a title="The general proportion between negative and positive emotional experience that shape your level of awareness.">Emotional pay-off:</a>');		
	define ("CONTROL", '<a title="Control over proportion between negative and positive emotional experience and emotional contemplation about overall state and perspectives.">Affective management:</a>');
	define ("SECONDARY", '<a title=" Shows your performance in percentage concerning some of your emotional attitudes and levels of affective management."><b>Secondary properties:</b></a>');	
	define ("ATTITUDES", '<a title="Preference significance to certain types of  emotion related scenes that reflect your profit, risks and costs."><b>Types of emotion related scenes:</b></a>');
	define ("MEANING", 'The botton "BACK" is inactive here <br/>to prevent damage on database.');
	define ("CONTRIBUTION", '<a title="All members of programming team have right to change the code in order to improve or contribute to further development of testing model only with agreement of the author."><b>PHP & JS programming: Hristo Venev, Hristo Minkov,</br>Anton Denev, Valyo Yolovski and Kristian Cuklev.<br/>Created by Krasen Ferdinandov, psychologist.</br></a>');	
	define ("ID", 'Thank you for the confirmation and your participation!');
	define ("TIP2", 'If you want to check your results again, remember this<br>internet adress: <b>www.testrain.info/results.php?id=</b>');
	define ("TIP", '<p class="desc-res3" align="right"><b><a title="In the following three rows there are three types of emotional choices which group each emotional striving in a class of subscripts - a different kind of perpetual and recurrent expectations and emotional habits. Selected emotions have an individual meaning and variety of life perspectives. When emotions are blended in pairs this could be a suggestion of various emotional orientations (scripts). They may organize your bahavior or be part of your life-style and here they are explained briefly in abstract manner. To read the content of the concepts take the cursor of the mouse close to the word and title will appear.">Read the following concepts and choose only these which fit best to selected emotions. After choosing the appropriate scripts from the list shown below, please, confirm the results at the end of the table.</b></a></p>');
	define ("CHOICE_NUMBER", 4);
	define ("EMOTIONS_NUMBER", 90);
	define ("DOMAINS_NUMBER", 10);
	define ("STATES_NUMBER", 24);
	define ("STATIS_NUMBER", 60);
	define ("MINISCRIPTS_NUMBER", 45);
	define ("TRAITS_NUMBER", 106);
		
	function validateInt($a){
		if(!is_numeric($a)){
			header("HTTP/1.1 400 Bad Request");
			exit();
		}
	}
	function percent($a, $b){
		if($b==0){
			return '';
		}else{
			return round($a*100/$b, 0);
		}
	}
	function scores_level($scores, $n){
		if($n==0) return 0;
		$scores/=$n;
		if($scores>6.5) return 2;
		if($scores>3.5 && $scores<=6.8) return 1;
		if($scores<=3.5) return 0;
	}
	function quot($text){
		return htmlspecialchars($text);
	}	
?>
﻿<?php
	$a=5;
	define ("NOTE", '<b>ЗАБЕЛЕЖКА!</b> За да прочетеш разяснение на инструкция, значение </br> на понятиe или превода на изречение от тестовете, постави курсора <br/>на мишката точно върху тях и ще се появи допълнително пояснение.');
	define ("CHOOSE_EMOTIONS", '<b><center><a title="Най-честото чувство означава това състояние, което се повтаря отново и отново, независимо от обстоятелствата. Подредбата по сила важи от центъра към периферията - от най-слабата към най-силната според въздействието им върху нервната дейност.">Избери ПОНЕ 2 НАЙ-ЧЕСТO изпитвани чувства (напр. за последния месец) от 10-те групи, изобразени по-долу.</b><center/></a>');
	define ("NEXT", 'Продължи');
	define ("NOT_ENOUGH_OR_TOO_MANY", '<center><a title="Върни се и подбери тези състояния, които най-често изживяваш, така че да бъдат поне 2 емоции.">Избери поне 2 състояния</center></a>');
	define ("FASTEST", '<a title="Отминава без каквито и да е усилия.">Много бързо</a>');
	define ("SLOWEST", '<a title="Въздействието на състоянието не отминава дори и с усилия на волята.">Много бавно</a>');
	define ("HOW_FAST", '<a title="Отнася се за продължителността на твоите състояния - степенувай от 1 до 10 продължителността на всяко състояние поотделно.">Как отминават избраните състояния?</a>');
	define ("CHOOSE_STATES", '<b><a title="Тези изречения ще послужат за оценка на пропорциите между представените в теста психологически ситуации, които да пресъздадат реалната ти представата за емоционално отношение.">Отбележи тези квадратчета пред изреченията, които НАЙ-ТОЧНО описват действително емоционално поведение.</b></a>');
	define ("RESULTS", '<a title="По-долу са описани oсновни категории в изследването  като най-вече резултатите се фокусират върху преобладаващите съотношения и предполагаеми сценарии на емоционално преживяване и акценти в чувствителността. Процентите и пропорциите са приблизителни за това каква е ролята на емоциите и влиянието им върху личните психологични вложения – увеличението на старанието и емоционалните вложения, както и предимството на направените избори на емоционални сценарии."><b>Първични показатели:<b/></a>');
	define ("TIP", '<a title="Eмоционалните пориви се комбинират и групират около три отделни типа житейски избори - благоприятни, обвързващи или ощетяващи. Избраните емоционални състояния могат да се свързват в двойки и така да послужат като насока за типични житейски ситуации,които най-общо описват как се чувстваш и какво те мотивира. Настроенията се групират около заучени положения (сценарии, ситуации) - повтарящи се емоционални склонности или очаквания, които под въздействие на личните убеждения оформят личния житейски опит. Тези типични емоционални ориентации ангажират по характерен начин различните емоции и ги използват за източник на енергия и мотивация. Различните ситуиации (сценарии) могат да се появят в списъка като по-общо формулирани описания на поведение и намерения. Te могат да са сценарии, които описват отношението ти спрямо другите, но може да са сценарии, отразяващи въздействието на другите върху теб. За да прочетеш описанието им насочи курсора на мишката върху думата, която те интересува.">Избери от изредените по-долу предложения само тези от тях,<br> за които прецениш, че имат връзка с избраните емоции, след<br> което потвърди избора и резултатите с бутона под таблицата.</a>');
	define ("DENSITY", '<a title="Максималните точки, до които  може да достигне емоционалната плътност в теста, са 10. Стойността на емоционалната плътност (съчетанието от силата, честотата и продължителността на емоцията) насочва какво е количестово нервното напрежение, което се задържа и остава в автобиографичната емоционална памет, за да се превърне в готовност до следващия път, когато ще се задейства вследствие на предизвикване на вече изживяна емоция и ще пресъздаде отново емоционалната атмосфера преживяна и преди в живота. Стойността на плътността показва с относителна приблизителност вероятността за повторение в подобни обстоятелства - доколко емоцията продължава да служи на общата цел да въздейства отново и отново върху значението на дадена повтаряща се житейска сцена."> Плътност: </a>');
	define ("POSITIVE", '<a title="Принадлежи на благотворното положително измерение на емоционалните състояния, по начало ориентирани към телесно и душевно изживяване на „удоволствие и задоволеност”, като цяло представялва обратна връзка от самия организма, че са преодоляни напрягащи и подлагащи го на изпитание житейски обстоятелства или че общото му състояние е добро.">Положителни състояния</a>');	
	define ("NEGATIVE", '<a title="Принадлежи на зловредното отрицателно измерение на емоционалните състояния, по начало ориентирани към телесно и душевно преживяване на увреждащо напрежение и неблагоприятен стрес”. Като цяло представялва обратна връзка от самия организма, че се е срещнал с непреодолими и напрягащи, подлагащи го на изпитание обстоятелства или влияния и че общото му състояние е разстоено и предразположено към страдание.">Отрицателни състояния</a>');
	define ("AMBIVALENT", '<a title="Принадлежи на измерение със двузначни емоционални стойности. Като цяло представялва обратна връзка от самия организма, че се е срещнал с едновременно напрягащи, но и стимулиращи преживявания, които създават усещане за стрес, но също така дават начален старт за положителни  или отрицателни чувства.">Противоречиви състояния</a>');	
	define ("RATIO", '<a title="Общото съотношение между положителните и отрицателните емоционални преживявания.">Емоционален баланс:</a>');
	define ("CONTROL", '<a title="Степента на контрол върху въздействието на положителните и отрицателните емоции, както и степента на осъзнаване на цялостното емоционално състояние и перспективи.">Емоционален самоконтрол:</a>');
	define ("SECONDARY", '<a title="Вторични показатели, които изясняват някои съотношения в личните емоционални нагласи и нивото на самоконтрол."><b>Вторични показатели:</b></a>');
	define ("ATTITUDES", '<a title="Личностовите психологически показатели представят в проценти степента на важност и изразеност  според пропорцията между избраните твърдения и общия брой твърдения принадлежащи към определеното измерение или под-измерение."><b>Специфични личностови показатели:</b></a>');
	define ("MEANING", 'Натискането на бутона `Назад` е отменено тук, <br/>защото би навредило на базата от данни.');
	define ("CONTRIBUTION", '<b><a title="Всеки един от програмистите, участвали в осъществяването на компютърния вариант на тестовия модел запазва правото си да прави промени в кода с цел подобряване или усъвършенстване само със съгласието на автора."><b>PHP & JS програмиране: Христо Венев, Вальо Йоловски,<br>Христо Минков, Антон Денев и Кристиян Цъклев. </br> По идея на: Красен Фердинандов, психолог.</b><br/></a>');
	define ("ID", 'Благодаря за участието и потвърждението!');
	define ("TIP2", 'Ако искаш да прегледаш резултите отново,<br>впиши в браузъра следния интернет адрес: </br><b>www.testrain.info/results.php?id=</b>');
	define ("CONFIRMED", '<a title="Потвърдените очаквания и избори имат своя стойност на подсилване която представлява разпределение на общите избори на житейски ситуации, представени под формата на изречения в тестовете и са един от определящите показатели при изчисляването на психологическото преувеличение на значението и важността на даден емоционален стереотип.">Потвърден избор на сценарии:</a>');
	
	define ("CHOICE_NUMBER", 4);
	define ("EMOTIONS_NUMBER", 90);
	define ("DOMAINS_NUMBER", 10);
	define ("STATES_NUMBER", 60);
	define ("MINISCRIPTS_NUMBER", 45);
	
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
		if($scores>3.5 && $scores<=6.5) return 1;
		if($scores<=3.5) return 0;
	}
	function quot($text){
		return htmlspecialchars($text);
	}	
?>
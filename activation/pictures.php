<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="./bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="./bootstrap-theme.min.css">

		<script src="./jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="./bootstrap.min.js"></script>
		<?php
			date_default_timezone_set("Europe/Sofia");
			require ("../headerbg.php");
			$timeNow = time();
			$dt = new DateTime();
			$dt->setTimestamp($timeNow);
		?>
		
		<style>
			.circle {
				width: 200px;
				height: 200px;
				border-radius: 50%;
				font-size: 20px;
				color: #000;
				line-height: 50px;
				text-align: center;
				background: #fff;
				border: 1px solid #aaa;
			}
			.small.circle {
				width: 40px !important;
				height: 40px !important;
				font-size: 20px !important;
				line-height: 12.5px !important;
			}
			.inline {
				display: inline-block;
			}
			a.category:hover {
				text-shadow: 1px 0px #aaa;
			}
			a.category:visited, a.category:link, a.category:active, a.category:hover {
				text-decoration: none;
			}
			.fixthis {
				position: static;
			}
			.counter, .image, .choice {
				display: none;
			}
		</style>
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<center>
					<h1 class="hidden">БЪРЗО ОЦЕНИ ВЪЗДЕЙСТВИЕТО НА СНИМКАТА:</h1>
				</center>
			</div>
			
			<div class="row">
				<form id="the_form" method="POST" action="indb.php" enctype="multipart/form-data" onSubmit="return checkboxesOkay(this);">
					<input type="hidden" id="startTime" name="timeStarted" value="<?php echo $dt->format("Y-m-d H:i:s"); ?>">
			</div>

		<?php
			$data = $pdo->query("SELECT * FROM pictures");
			$photoes = $data->rowCount();
			$id_current_photo = 0;
			while($row = $data->fetch(PDO::FETCH_BOTH)){
				$id=$row["id"];
				$url=$row["url"];
		?>
				<div class="row image">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<center>
							<img src="../<?php echo $url; ?>">
						</center>
					</div>
					<div class="col-md-2"></div>
				</div>
				<div class="row counter">
					<div class="col-md-5">
					</div>
					<div class="col-md-2">
						<center>
							<center class="inline"><div class="small circle"><br>3</div></center>
						<center>
					</div>
					<div class="col-md-5">
					</div>
				</div>
				<div class="row choice">
					<div class="col-md-12">
						<center>
							<center class="inline"><a class="category" href="#"><div class="circle"><br>НАПРЯГАЩО И НЕПРИЯТНО</div></a></center>
							<center class="inline"><a class="category" href="#"><div class="circle"><br>ВЪЛНУВАЩО И ПРИЯТНО</div></a></center>
						</center>
					</div>
					<div class="col-md-12">
						<center>
							<center class="inline"><a class="category" href="#"><div class="circle"><br>ПОТИСКАЩО И НЕПРИЯТНО</div></a></center>
							<center class="inline"><a class="category" href="#"><div class="circle"><br>ОТПУСКАЩО И ПРИЯТНО</div></a></center>
						</center>
					</div>
				</div>
		<?php
				$id_current_photo ++;
			}
		?>
		</div>
		
		<form style="display: none;"></form>
		
		<script src="../js/show_slide.js"></script>
		<script src="../js/collectTiming.js"></script>
		<script src="img_show.js"></script>
		<script src="choose_time.js"></script>
		
		<script type="text/javascript">
			function show_image (i) {
				$($(".image")[i]).show ();
			}
			function hide_image_and_show_counter_and_choices (i) {
				$($(".image")[i]).hide ();
				$($(".counter")[i]).show ();
				$($(".choice")[i]).show ();
			}
			function hide_counter_and_choices (i) {
				$($(".counter")[i]).hide ();
				$($(".choice")[i]).hide ();
			}
			function change_counter (i, s) {
				$($(".counter")[i]).show ();
				$($(".counter .circle")[i]).html ('<br>' + s);
			}
			function change_submit_counter (s) {
				$("#submit_counter").html ('<br>' + s);
			}
			function enable_submit () {
				$("#submit_counter").hide ();
				
				$("input#ready").prop('disabled', false);
				$("input#ready").show();
			}
			function save_value (val, img_num) { // value + timing
				console.log ("set value to:", val, img_num);
				
				$($("form")[0]).append ('<input type="hidden" name="" value="' + 
										$('input[name="s_slider"]:checked').val() + '">');
			}
			function after_timer () {
				save_value (0);
				$("#slider").modal ("hide");
			}
			function setup () {
				$(".image").hide ();
				$(".counter").hide ();
				$(".choice").hide ();
			}
			function reset_modal () {
				$('input#check').val(0);
				$("input#ready").prop('disabled', true);
				$("input#ready").hide();
				
				$("#submit_counter").show ();
				
				$('input[name="s_slider"]').prop('checked', false);
				$("#submit_counter").html ('<br>5');
			}
			
			//                                        radio time
			//                                          counter step
			//                                                       image time
			var show = new CoreImageShow ($(".image").length, 3, -1, 1.5, show_image, hide_image_and_show_counter_and_choices, hide_counter_and_choices, change_counter, reset_modal);
			var submit_timer = new CoreChoiceTimer (5, change_submit_counter, after_timer);
			
			$(document).ready (function() {
				show.start_next_image_show (0);
			
				$(".category").click (function () {
					
					// TODO: get time and write it as <<<<<category time>>>>>
					
					$("#slider").modal ("show");
					show.pause_state ();
					
					console.log ("event CLICK():", window.event);
				});
				$('input[name="s_slider"]').click (function () {
					enable_submit();
				});
				$("#ready").click (function () {
					if ($('input[name="s_slider"]:checked').length > 0) {
						save_value ($('input[name="s_slider"]:checked').val()/*, number_of_image*/);
						$("#slider").modal ("hide");
					}
					else {
						// TODO: notify that the client must choose one of the options before submitting (option if client re-write HTML with F12)
					}
				});
				
				$('#slider').on('hidden.bs.modal', function () {
					console.log ('modal has been hidden');
					show.reset_step ();
					show.skip_image ();
				});
				
				$('#slider').on('shown.bs.modal', function () {
					console.log ('modal has been shown');
					submit_timer.counter_start ();
				});
			});
		</script>
		
		<?php
			require_once('../js/numbers.js');
			require "../end.php";	
		?>
		
		<div id="slider" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Оцени колко:</h4> <!-- v kakva stepen -->
					</div>
					<div style="text-align: justify;" class="modal-body">
					<?php
						for ($i = 1 ; $i < 10 ; $i ++) {
					?>
						<label><input class="timed" type="radio" name="s_slider" class="e_slider" 
						value="<?php echo $i; ?>"/>
							<?php echo $i; ?>
						</label>
					<?php
						}
					?>
					</div>
					<div class="modal-footer">
						<div style="text-align: left;" class="form-check has-success">
							<center class="inline"><div id="submit_counter" class="small circle"><br>5</div></center>
							<input style="display: none;" type="button" class="form-check-input" id="ready" value="Готово" disabled>
							<input type="hidden" id="check" value="0">
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>

<!-- define #the_form for class=timed -->
<!-- DISABLE REFRESH!!!!!!!!!!!!!!!! --->
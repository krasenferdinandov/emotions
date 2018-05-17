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
			.counter .circle {
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
			function setup () {
				$(".image").hide ();
				$(".counter").hide ();
				$(".choice").hide ();
			}
			function reset_modal () {
				$('input#check').val(0);
				$("input#ready").prop('disabled', true);
			}
			
			//                                        radio time
			//                                          counter step
			//                                                       image time
			var show = new CoreImageShow ($(".image").length, 3, -1, 1.5, show_image, hide_image_and_show_counter_and_choices, hide_counter_and_choices, change_counter, reset_modal);
			
			$(document).ready (function() {
				//setup ();
				show.start_next_image_show (0);
			
				$(".category").click (function () {
					$("#slider").modal ("show");
					show.pause_state ();
					
					console.log ("event CLICK():", window.event);
				});
				$('input[name="s_slider"]').click (function () {
					$("#ready").prop('disabled', false);
				});
				$("#ready").click (function () {
					if ($('input[name="s_slider"]:checked').length > 0) {
						$($("form")[0]).append ('<input type="hidden" name="" value="' + 
												$('input[name="s_slider"]:checked').val() + '">');
						$("#slider").modal ("hide");
					}
					else {
						// notify that the client must choose one of the options before submitting
					}
				});
				
				$('#slider').on('hidden.bs.modal', function () {
					console.log ('modal has been hidden');
					show.reset_step ();
					show.skip_image ();
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
						<h4 class="modal-title">Оцени степента:</h4>
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
							<input type="button" class="form-check-input" id="ready" value="Готово" disabled>
							<input type="hidden" id="check" value="0">
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>

<!-- DISABLE REFRESH!!!!!!!!!!!!!!!! --->
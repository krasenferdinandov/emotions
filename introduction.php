<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="activation/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="activation/bootstrap-theme.min.css">

		<script src="activation/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="activation/bootstrap.min.js"></script>
	</head>

	<body>
		<h1 class="center"></h1>
		<div class="container">
			<div class="row">
				<div id="intro" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Добре дошли!</h4>
							</div>
							<div style="text-align: justify;" class="modal-body">
								<p>Ще участвате в кратък тест за концентрация. Ще се показват снимки за определено време.</p>
								<p>Задачата е бързо да оцените въздействието им върху емоциите Ви, също за определено време.</p>
							</div>
							<div class="modal-footer">
								<div style="text-align: left;" class="form-check has-success">
									<label class="form-check-label">
										<input type="checkbox" class="form-check-input" id="iagree">
										Разбрах.
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			$("#intro").modal("show");
			$("#iagree").change(function() {
				if(this.checked) {
					// similar behavior as an HTTP redirect
					window.location.replace("./activation/pictures.php");

					// similar behavior as clicking on a link
					window.location.href = "./activation/pictures.php";
				}
			});
			$('#intro').on('hidden.bs.modal', function () {
				if ($('input#iagree:checked').length == 0)
					$("#intro").modal("show");
			});
		</script>
	</body>
</html>
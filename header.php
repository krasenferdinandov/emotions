<!DOCTYPE html><html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<?php
		require_once "constants.php";
		require_once "db_pass.php";
	?>
	<style>
	table.borders{
		border-collapse: collapse;
		text-align: justify;
	}
	table.borders tr th{
		border: 0px solid #c0c0c0;
		/* dotted - с точки; solid - с черта; dashed - с пунктир;*/
		padding-bottom:20px;
	}
	table.borders tr td{
		border: 0px solid #c0c0c0;
	}
	#explain{
		text-align: justify;
		position: absolute;
		font-size:18px;
		color:#c0c0c0;
	}
	#credits{
		font-size:18px;
		color:#c0c0c0;
	}
	.desc-res{
		width:150px;
		text-align: justify;
		text-justify: inter-word;
		font-size:18px;
		font-style: normal;
		font-weight: normal;
	}
	.desc-res2{
		width:300px;
		text-align: justify;
		text-justify: inter-word;
		font-size:14px;
		font-style: normal;
		font-weight: normal;
	}
	.desc-res3{
		width:450px;
		text-align: justify;
		text-justify: inter-word;
		font-size:16px;
		font-style: normal;
		font-weight: normal;
	}
	.desc-res4{
		width:370px;
		text-align: justify;
		text-justify: inter-word;
		font-size:15px;
		font-style: normal;
		font-weight: normal;
	}
	.desc-res5{
		width:300px;
		text-align: justify;
		text-justify: inter-word;
		font-size:14px;
		font-style: normal;
		font-weight: normal;
	}
	.top {
		vertical-align: top;
	}
	</style>
</head>
<body>
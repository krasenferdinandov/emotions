<?php
	define("URL", "http://testrain.info/");
	define("DB", "anydb");
	define("USERNAME", "anyuser");
	define("PASSWORD", "anypass");
	define("HOST", "localhost");
	$pdo = new PDO('mysql:host=localhost;dbname='.DB.';charset=utf8', USERNAME, PASSWORD);
	$pdo->exec("set names utf8");
?>

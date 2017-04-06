<?php
	define("URL", "http://testrain.info/");
	define("DB", "ybmklsfy_krasen");
	define("USERNAME", "ybmklsfy");
	define("PASSWORD", "tryanypass");
	define("HOST", "localhost");
	$pdo = new PDO('mysql:host=localhost;dbname='.DB.';charset=utf8', USERNAME, PASSWORD);
	$pdo->exec("set names utf8");
?>

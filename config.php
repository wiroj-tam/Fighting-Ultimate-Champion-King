<?php
date_default_timezone_set('Asia/Bangkok');
	define("server", "localhost");
	define("username", "root");
	define("password", "");
	define("db", "pokemon_fighting");
	$con = mysqli_connect(server,username,password,db)or die("error");
mysqli_set_charset($con,"utf8");
?>

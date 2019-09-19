<?php
   	define('DB_SERVER', 'localhost:3306');
   	define('DB_USERNAME', 'root');
   	define('DB_PASSWORD', '');
   	define('DB_DATABASE', 'servicestation');
   	$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}
?>
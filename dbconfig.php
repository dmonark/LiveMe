<?php

function establish_connections()
{
	global $con;
	define('DB_HOST', 'localhost'); 
	define('DB_NAME','liveme_data'); 
	define('DB_USER','root'); 
	define('DB_PASSWORD',''); 
	$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die("Failed to connect to MySQL: " . mysql_error()); 
}

?>
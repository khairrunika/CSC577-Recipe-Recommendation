<?php
	session_start();
	
	$hostname = "localhost";
	$user = "root";
	$password = "";
	$dbname = "recipe_rocket";
		
	//create a connection with MySQL
	$connect = mysqli_connect($hostname, $user, $password, $dbname) 
			   OR DIE ("Connection failed");
				   //If cannot connect to MySQL, error is displayed

?>
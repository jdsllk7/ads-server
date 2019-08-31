<?php
	$error_msg = 'Sorry could not connect to server...';
	$servername = 'localhost';
	$username = 'root';
	$password = '';

	// CREATE CONNECTION
	$conn = mysqli_connect($servername, $username, $password);
	
	// CHECK CONNECTION
	if (!$conn) {
		die($error_msg);
	}

	// CREATE THE DATABASE
	// $sql = "drop database if exists central_server";
	$sql = "CREATE DATABASE IF NOT EXISTS central_server";
	if (mysqli_query($conn, $sql)) {
		$dbname = "central_server";
		$conn = mysqli_connect($servername, $username, $password, $dbname);
	} else {
		die($error_msg);
	}
					
	
	$sql = "CREATE TABLE IF NOT EXISTS accident_sites (
			id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			center_id BIGINT(19),
			latitude DECIMAL(15,10) NOT NULL,
			longitude DECIMAL(15,10) NOT NULL,
			attended_to BOOL DEFAULT 0 NOT NULL
			)";
			// $sql = "DROP TABLE IF EXISTS accident_sites";
			mysqli_query($conn, $sql);
			
			
	
?> 
 
 
 
 
 
 
 
 
 
 
 
 
 

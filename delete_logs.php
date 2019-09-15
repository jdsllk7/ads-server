<?php
session_start();

	include 'connect.php';
	$sql = "DELETE FROM log";
	if (mysqli_query($conn, $sql)) {
		$_SESSION["info"] = "log";
        header("Location: index.php");
	}
?>
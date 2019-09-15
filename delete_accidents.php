<?php
session_start();

	include 'connect.php';
	$sql = "DELETE FROM accident_sites";
	if (mysqli_query($conn, $sql)) {
		$_SESSION["info"] = "accident";
        header("Location: index.php");
	}
?>
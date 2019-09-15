<?php
session_start();

    include 'connect.php';
	$sql = "DELETE FROM active_centers";
	if (mysqli_query($conn, $sql)) {
        $_SESSION["info"] = "center";
        header("Location: index.php");
	}
?>
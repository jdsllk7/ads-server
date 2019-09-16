<?php

    include 'connect.php';

    if(isset($_GET['center_id'])){
        $center_id = $_GET['center_id'];
        $sql = "DELETE FROM active_centers WHERE center_id = $center_id";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
        }
    }
?>
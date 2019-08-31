<?php

		include 'connect.php';

		$center_id = $_POST["center_id"];

		$q = "SELECT * FROM accident_sites WHERE center_id='$center_id'";
		
		$result = mysqli_query($conn, $q);
		
		if (mysqli_num_rows($result) > 0) {
			
			while($row = mysqli_fetch_assoc($result)) {
				
				//echo $row["center_id"];
				echo $row["latitude"]."&".$row["longitude"];
				break;
				
			}			
		}else{
			echo "No health response required!!!!";
		}
		
?>










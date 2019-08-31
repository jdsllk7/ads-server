<?php
	include 'connect.php';
	
	//validation variables
	$province = $town_or_city = $neighborhood = $latitude = $longitude = "";
	
	
	//VALIDATION INPUT
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$name = $_POST["name"];
		$province = $_POST["province"];
		$town_or_city = $_POST["town_or_city"];
		$neighborhood = $_POST["neighborhood"];
		$latitude = $_POST["latitude"];
		$longitude = $_POST["longitude"];
		
		//make sure fields are not empty
		if (!empty($_POST["name"]) && !empty($_POST["province"]) && !empty($_POST["town_or_city"]) && !empty($_POST["neighborhood"]) && !empty($_POST["latitude"]) && !empty($_POST["longitude"])) {
			
			$sql = "INSERT INTO active_centers (center_name, province, town_or_city, neighborhood, latitude, longitude) VALUES ('$name', '$province', '$town_or_city', '$neighborhood', '$latitude', '$longitude')";

			if (mysqli_query($conn, $sql)) {
				echo "<div id='center_added' class='center_added'>New center added successfully";
					echo"<span class='closebtn' onclick=' document.getElementById(\"center_added\").style.display=\"none\";'>&times;</span>";
				echo"</div>";
			}
	
		}//end if()	
		
	}//end if()
?>
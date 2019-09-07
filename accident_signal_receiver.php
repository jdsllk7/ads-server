<!DOCTYPE html>
<html>
<?php
	if(!isset($_COOKIE["username"]) || !isset($_COOKIE["password"])){
		header("Location: index.php");
	}
?>
	<head>
		<title>Control Log</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body style="text-align:center;">
	<a href="controlPanel.php" style="position: absolute;right:110px;margin:0%;"><span href="accident_signal_receiver.php" class="openbtn">Control Panel</span> </a>
	<br>
	<p class="map_header"><b>SADAR</b><br>Smart Automatic Accident Detection & Ambulance Rescue<br><br><b>Logs</b></p><br><br><br><br><br><br>
	
		<section id="main" style="text-align:left; font-size:1.2em; padding: 2%; border: 3px solid #4d4d4d;">
			
			
		
		
		<p><h2>Accident Sites Responses</h2></p>
		
		<table class="logTable">
			<tr style="background: #404040;">
				<th>No.</th>
				<th>Center Name</th>
				<th>Accident Site ID</th>
				<th>Responsed</th>
			</tr>

			<?php
				include 'connect.php';

				$sql = "SELECT * FROM log ORDER BY id DESC";
				$result = mysqli_query($conn, $sql);
				$count = 1;
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						
						echo "<tr>";
								echo "<td>".$count."</td>";
								echo "<td>".$row["center_name"]."</td>";
								echo "<td>".$row["accident_sites_id"]."</td>";
								echo "<td>".timeLog($row["datez"])."</td>";
						echo "</tr>";

						$count++;
					}
						
				} else {
					echo "<tr>";
						echo "<td>No Records logged yet!</td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
					echo "</tr>";
				}

		echo"</table>";
	










	
	
	$shortest_distance = 0; 
	$shortest_distance_name = ""; 
	$lat_site = "";
	$lng_site = "";
	

	if(isset($_GET['lat']) && !empty($_GET['lat']) && isset($_GET['lng']) && !empty($_GET['lng']) && isset($_GET['accident']) && !empty($_GET['accident']) && $_GET['accident']==911){
		
		//Accident Coordinates
		$lat_site = $lat1 = $_GET['lat'];
		$lng_site = $lng1 = $_GET['lng'];
		
		
		$sql = "SELECT * FROM active_centers WHERE active='1'";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			
			$count = 1;
			
			echo "<br><br><h4>Current Response</h4>";

			// Output Active First Responders
			while($row = mysqli_fetch_assoc($result)) {
				
				//First Responders Coordinates
				$lat2 = $row["latitude"];
				$lng2 = $row["longitude"];
				
				//Calculating distance between 2 points
				echo $count.". From [" . $row["center_name"] . " Center] to Accident site = ". round(calculate_distance($lat1,$lng1,$lat2,$lng2)) . " km";
				echo "<br>";
				
				
				//Calculating shortest_distance
				$distance = calculate_distance($lat1,$lng1,$lat2,$lng2);
				
				if($count == 1){
					$shortest_distance = $distance;
					$shortest_distance_name = $row["center_name"];
					
					$center_id = $row["center_id"];
					$province = $row["province"];
					$town_or_city = $row["town_or_city"];
					$neighborhood = $row["neighborhood"];
					$latitude = $row["latitude"];
					$longitude = $row["longitude"];
					$player_id = $row["player_id"];
					$app_id = $row["app_id"];
				}else{
					if($distance < $shortest_distance){
						$shortest_distance = $distance;
						$shortest_distance_name = $row["center_name"];
						
						$center_id = $row["center_id"];
						$province = $row["province"];
						$town_or_city = $row["town_or_city"];
						$neighborhood = $row["neighborhood"];
						$latitude = $row["latitude"];
						$longitude = $row["longitude"];
						$player_id = $row["player_id"];
						$app_id = $row["app_id"];
					}
				}
				
				$count++;
			}//end while()
			
		}//end if()
			
		
		
		$data = mysqli_query($conn, "SELECT * FROM accident_sites WHERE latitude='$lat_site' and longitude='$lng_site'");
		if(mysqli_num_rows($data)==0 && isset($center_id)){
			$sql = "INSERT INTO `accident_sites`(`center_id`,`latitude`, `longitude`) VALUES ('$center_id','$lat_site','$lng_site')";
			mysqli_query($conn, $sql);

			if(isset($app_id)){
				$heading = 'Emergency Alert!';
				$message = 'Are you available to respond?';
				sendNotificationByUserId($app_id, $player_id, $heading, $message);
			}
		}

		if(round($shortest_distance) <= 0){
			echo "<br><strong>Shortest Distance </strong>[" . $shortest_distance_name ." Center] =  <b>Within a Kilometer of your location</b>";	
		}else {
			echo "<br><strong>Shortest Distance </strong>[" . $shortest_distance_name ." Center] = ". round($shortest_distance) . " km";
		}
		
		

		
	
		
	}//end main if()

	
	
	
	function calculate_distance($lat1, $lon1, $lat2, $lon2) {
	
		// distance between latitudes 
		// and longitudes 
		$dLat = ($lat2 - $lat1) * 
					M_PI / 180.0; 
		$dLon = ($lon2 - $lon1) *  
					M_PI / 180.0; 
	  
		// convert to radians 
		$lat1 = ($lat1) * M_PI / 180.0; 
		$lat2 = ($lat2) * M_PI / 180.0; 
	  
		// apply formulae 
		$a = pow(sin($dLat / 2), 2) + pow(sin($dLon / 2), 2) * cos($lat1) * cos($lat2); 
		$rad = 6371; 
		$c = 2 * asin(sqrt($a)); 
		return $rad * $c; 
	}//end haversine()
	






	function sendNotificationByUserId($app_id, $user_id, $heading, $message){
        $content = array(
            "en" => $message
        );
		
		$hashes_array = array();
		array_push($hashes_array, array(
			"id" => "like-button",
			"text" => "Yes",
			"icon" => "http://i.imgur.com/N8SN8ZS.png",
			"url" => "http://localhost:3000/waiting"
		));

        $headings = array(
            'en' => $heading
        );
        
		// echo $user_id;
		
		$fields = array(
            'app_id' => $app_id,
            'include_player_ids' => array($user_id),
            'data' => array("foo" => "bar"),
            'contents' => $content,
            'headings' => $headings
		);
        
        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
	}//end sendNotificationByUserId()
	



	//GET TIME AGO
	date_default_timezone_set('Africa/Lusaka');
	function timeLog($timestamp){
		$time_ago = strtotime($timestamp);
		$current_time = time();
		$time_difference = $current_time - $time_ago;
		$seconds = $time_difference;
		$minutes = round($seconds / 60);
		$hours = round($seconds / 3600);
		$days = round($seconds / 86400);
		$weeks = round($seconds / 604800);
		$months = round($seconds / 2629440);
		$years = round($seconds / 31553280);
		
		if($seconds<=60){	//seconds
			return "Just Now";
		}else if($minutes<=60){
			if($minutes==1){
				return "1 min ago";
			}else{
				return $minutes." min ago";
			}
		}else if($hours<=24){	//hours
			if($hours==1){
				return "An hour ago";
			}else{
				return $hours." hours ago";
			}
		}else if($days<=7){	//days
			if($days==1){
				return "A day ago";
			}else{
				return $days." days ago";
			}
		}else if($weeks<=4.3){	//weeks
			if($weeks==1){
				return "A week ago";
			}else{
				return $weeks." weeks ago";
			}
		}else if($months<=12){	//months
			if($months==1){
				return "A month ago";
			}else{
				return $months." months ago";
			}
		}else {	//years
			if($years==1){
				return "A year ago";
			}else{
				return $years." years ago";
			}
		}//end main elseif()
		
	}//end time_ago_uploaded()
	





	
	
?>
</section>

</body>
</html>




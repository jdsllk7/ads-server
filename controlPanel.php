
<?php include 'connect.php';?>
<?php include 'validate.php';?>

<!DOCTYPE html>
<html>
<?php
	if(!isset($_COOKIE["username"]) || !isset($_COOKIE["password"])){
		header("Location: index.php");
	}
?>
	<head>
		<title>SADAR</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<!-- <script src="http://maps.googleapis.com/maps/api/js"></script> -->
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4bSJTKEB7naiqu0LSYp27SQmglUyZ-Jo&callback=initMap" async defer></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="javaScript.js"></script>
	</head>

	<body>
		
		<button class="openbtn" onclick="openNav()">☰ Menu</button>
		<a href="controlPanel.php" class="openbtn refresh">Refresh<br>data</a><br><br><br><br>
		<a href="accident_signal_receiver.php" class="openbtn refresh">Logs</a> 
		
		<div id="floating-panel">
			<button id="drop" onclick="drop()">View Centers</button>
		</div>
		
		<section id="main">
			<p class="map_header"><b>Welcome To SADAR</b><br>Smart Automatic Accident Detection & Ambulance Rescue<br><b>Control Panel</b></p>
			<div id="map" class="map">
				<i>Loading map... <span id="loaderMe" class="loader"><span class="loader-inner"></span></span>
					<br><br>Add atleast one(1) health center in order to view map.
				</i>
			</div>
		</section>
		<i style="text-decoration:none;font-size:1em;">(Displaying Active Health Centers)</i>
		
		
		<!--Sidebar-->
		<div id="mySidebar" class="mySidebar">
			<span class="closebtn" onclick="closeNav()">&larr;</span>
			
			<!--Main Menu-->
			<div id="inner_mySidebar" class="inner_mySidebar">
				<br><br>
				<p class="mySidebar_header">Menu</p>
				<button class="button" onclick="view_centers()">View Centers</button><br>
				<button class="button" onclick="add_center()">Add New Center</button><br>
				<form action="logout_db.php">
					<button class="button" type="submit">Log Out</button><br>
				</form>
			</div>
			
			<!--Add Center-->
			<div class="form-popup" id="myForm">
				<form class="form-container" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="on">
					<h3>Add New Center</h3>

					<label for="name"><b>Center Name</b></label><br>
					<input type="text" placeholder="Enter Center Name" name="name" required>
					
					<label for="email"><b>Province</b></label><br>
					<input type="text" placeholder="Enter province" name="province" required>

					<label for="psw"><b>Town / City</b></label><br>
					<input type="text" placeholder="Enter Town / City" name="town_or_city" required>
					
					<label for="psw"><b>Neighborhood</b></label><br>
					<input type="text" placeholder="Enter Neighborhood" name="neighborhood" required>
					
					<label for="psw"><b>Latitude</b></label><br>
					<input type="text" placeholder="Enter Latitude" name="latitude" required>
					
					<label for="psw"><b>Longitude</b></label><br>
					<input type="text" placeholder="Enter Longitude" name="longitude" required>

					<button type="submit" class="btn">Add</button>
				</form>
				<br><span class="back_btn" onclick="main_menu()">Back to menu</span>
			</div>
			
			
			
			<!--View Centers-->
			<div class="display_centers" id="display_centers">
				<p class="mySidebar_header">Active Health Centers</p>
				
				<?php
				
					$sql = "SELECT * FROM active_centers";
					$result = mysqli_query($conn, $sql);

					if (mysqli_num_rows($result) > 0) {
						
						echo'<table>
						  <tr class="header">
							<th>ID</th>
							<th>Name</th>
							<th>Province</th>
							<th>Town/City</th>
							<th>Neighborhood</th>
							<th>Latitude</th>
							<th>Longitude</th>
							<th>Active</th>
						  </tr>';
						
						// output data from database
						while($row = mysqli_fetch_assoc($result)) {

							$latlong[] = $row['latitude'].",".$row["longitude"]."";
							$center[] = $row["center_name"]." Health Center, ".$row["province"].", ". $row["town_or_city"].", ".$row["neighborhood"];
						
						echo'<tr>
								<td class="rows">'.$row["center_id"].'</td>
								<td class="rows">'.$row["center_name"].'</td>
								<td class="rows">'.$row["province"].'</td>
								<td class="rows">'.$row["town_or_city"].'</td>
								<td class="rows">'.$row["neighborhood"].'</td>
								<td class="rows">'.$row["latitude"].'</td>
								<td class="rows">'.$row["longitude"].'</td>
								<td class="rows">'.$row["active"].'</td>
							  </tr>';
							  
							
						}//end while()
						echo'</table>';
						
					} else {
						echo "<div style='color: #f2f2f2;'>No centers in database!</div>";
					}
					
				?>
				
				<br><span class="back_btn" onclick="main_menu()">Back to menu</span>
			</div>
			
		</div>
		<!-- END Sidebar -->
		
	</body>









<script>

	var neighborhoods = <?php if(!empty($latlong)){ echo json_encode($latlong); } ?>;

	console.log(neighborhoods);

		var markers = [];
		var map;

		function initMap() {
			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 6,
				center: {lat: -13.520, lng: 27.510}
			});
		}
		// drop();
		function drop() {
			clearMarkers();
			for (var i = 0; i < neighborhoods.length; i++) {
				var myArr = neighborhoods[i].split(',');
				addMarkerWithTimeout({lat: Number(myArr[0]), lng: Number(myArr[1])}, i * 500);
			}
		}

		function addMarkerWithTimeout(position, timeout) {
			window.setTimeout(function() {
				markers.push(new google.maps.Marker({
				position: position,
				map: map,
				icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
				animation: google.maps.Animation.BOUNCE
				}));
			}, timeout);
		}

		function clearMarkers() {
			for (var i = 0; i < markers.length; i++) {
				markers[i].setMap(null);
			}
			markers = [];
		}
</script>






	</html>
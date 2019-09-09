
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
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4bSJTKEB7naiqu0LSYp27SQmglUyZ-Jo&callback=initMap"
    async defer></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
		<script src="javaScript.js"></script>
	</head>

	<body>
		
		<button class="openbtn" onclick="openNav()">☰ Menu</button>
		<a href="controlPanel.php" class="openbtn refresh">Refresh<br>data</a><br><br><br><br>
		<a href="accident_signal_receiver.php" class="openbtn refresh">Logs</a> 
		
		
		<section id="main">
			<p class="map_header"><b>Welcome To SADAR</b><br>Smart Automatic Accident Detection & Ambulance Rescue<br><b>Control Panel</b></p>
			<div id="map" class="map">
				<i>Loading map... <span id="loaderMe" class="loader"><span class="loader-inner"></span></span>
					<br><br>Add atleast one(1) health center in order to view map.<br><br>Or You may just have bad Internet connection... &#9785;
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

							$latlong[] = $row['latitude'].",".$row["longitude"]." ";
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





<!-- <script>
		

		var contentstring = [];
		var regionlocation = [];
		var markers = [];
		var iterator = 0;
		var areaiterator = 0;
		var map;
		var infowindow = [];
		geocoder = new google.maps.Geocoder();

		$(document).ready(function () {
			setTimeout(function () { initialize(); }, 400);
		});

		function initialize() {
			infowindow = [];
			markers = [];
			GetValues();
			iterator = 0;
			areaiterator = 0;
			region = new google.maps.LatLng(regionlocation[areaiterator].split(',')[0], regionlocation[areaiterator].split(',')[1]);
			map = new google.maps.Map(document.getElementById("map"), {
				zoom: 6,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: region,
			});
			drop();
		}

		function GetValues() {
			contentstring = <?php if(!empty($center)){ echo json_encode($center); } ?>;
			regionlocation = <?php if(!empty($latlong)){ echo json_encode($latlong); } ?>;
		}

		function drop() {
			for (var i = 0; i < contentstring.length; i++) {
				setTimeout(function () {
					addMarker();
				}, 800);
			}
		}

		function addMarker() {
			
			var icons = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
			var templat = regionlocation[areaiterator].split(',')[0];
			var templong = regionlocation[areaiterator].split(',')[1];
			var temp_latLng = new google.maps.LatLng(templat, templong);
			markers.push(new google.maps.Marker(
				{
					position: temp_latLng,
					map: map,
					icon: icons,
					animation: google.maps.Animation.BOUNCE,
					draggable: false
				}));
			iterator++;
			info(iterator);
			areaiterator++;
		}

		function info(i) {
			infowindow[i] = new google.maps.InfoWindow({
				content: contentstring[i - 1]
			});
			infowindow[i].content = contentstring[i - 1];
			google.maps.event.addListener(markers[i - 1], 'click', function () {
				for (var j = 1; j < contentstring.length + 1; j++) {
					infowindow[j].close();
				}
				infowindow[i].open(map, markers[i - 1]);
			});
		}

</script>-->


<script>
      var panorama;

      function initMap() {
        var astorPlace = {lat: -15.729884, lng: 28.990988};

        // Set up the map
        var map = new google.maps.Map(document.getElementById('map'), {
          center: astorPlace,
          zoom: 18,
          streetViewControl: false
        });

        // Set up the markers on the map
        var cafeMarker = new google.maps.Marker({
            position: {lat: 40.730031, lng: -73.991428},
            map: map,
            icon: 'https://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=cafe|FFFF00',
            title: 'Cafe'
        });

        var bankMarker = new google.maps.Marker({
            position: {lat: 40.729681, lng: -73.991138},
            map: map,
            icon: 'https://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=dollar|FFFF00',
            title: 'Bank'
        });

        var busMarker = new google.maps.Marker({
            position: {lat: 40.729559, lng: -73.990741},
            map: map,
            icon: 'https://chart.apis.google.com/chart?chst=d_map_pin_icon&chld=bus|FFFF00',
            title: 'Bus Stop'
        });

        // We get the map's default panorama and set up some defaults.
        // Note that we don't yet set it visible.
        panorama = map.getStreetView();
        panorama.setPosition(astorPlace);
        panorama.setPov(/** @type {google.maps.StreetViewPov} */({
          heading: 265,
          pitch: 0
        }));
      }

      function toggleStreetView() {
        var toggle = panorama.getVisible();
        if (toggle == false) {
          panorama.setVisible(true);
        } else {
          panorama.setVisible(false);
        }
      }
    </script>

	








	</html>
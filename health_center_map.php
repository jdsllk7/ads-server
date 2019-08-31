
<!DOCTYPE html>
<html>
	<head>
		<title>Locater</title>
		<script src="https://maps.googleapis.com/maps/api/js"></script>
	</head>

	<body>
		
		<div id="map" style="width:100%;height:auto;">mapping</div>
	</body>
	
	
	
	
	<script>
	
		var mapCanvas = document.getElementById("map");
		var mapOptions = {
			center: new google.maps.LatLng(51.5, -0.2), zoom: 10
		}
		var map = new google.maps.Map(mapCanvas, mapOptions);
		
	</script>
	

</html>

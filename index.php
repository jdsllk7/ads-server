<!DOCTYPE html>
<html>

	<?php
		if(isset($_COOKIE["username"]) && isset($_COOKIE["password"])){
			header("Location: controlPanel.php");
		}
	?>

	<head>
		<title>Control Log</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body style="text-align:center;">
	<br><br>
	<br><br>
	<br><br>
	<p class="map_header"><b>Accident Detection System<br><br>Login Page</b></p><br><br><br><br>
	
		<section id="main2" style="text-align:left; font-size:1.2em; margin-top:50px; padding: 2%; border: 3px solid #4d4d4d;">
		
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<div class="" id="myForm">
				<form class="form-container" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="on">

					<label for="name"><b>Username</b></label><br>
					<input type="text" placeholder="Enter Username" name="username" required>
					
					<label for="email"><b>Password</b></label><br>
					<input type="password" placeholder="Enter Password" name="password" required>

					<button type="submit" class="btn">Submit</button>
				</form>
			</div>
			<br>
		
		
		</section>

</body>
</html>


<?php

	if(isset($_GET['error'])){
		echo "<div id='center_added' style='background:red;color:white;position:absolute;top:0px;width:96%;' class='center_added'>Login unsuccessfully";
			echo"<span class='closebtn' onclick=' document.getElementById(\"center_added\").style.display=\"none\";'>&times;</span>";
		echo"</div>";
	}

	if(isset($_POST['username']) && isset($_POST['password'])){

		if($_POST['username']=='admin' && $_POST['password']=='1234'){
			setcookie('username', $_POST['username'], time() + (86400 * 30), "/");
			setcookie('password', $_POST['password'], time() + (86400 * 30), "/");
			header("Location: controlPanel.php");
		}else{
			header("Location: index.php?error=\"error\"");
		}
		
	}

?>



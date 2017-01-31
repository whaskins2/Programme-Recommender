<!DOCTYPE HTML>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>Moonslider</title>
			<link rel="stylesheet" type="text/css" href="css/styles.css">
		</head>
		<body>
			<header>
				<div class="mainLogo">
				<img src="img/sky_logo.png" class="mainLogo" alt="sky logo">
				</div>
				<div class="title"><p>Moonslider</p></div>
				<div class = "nav"><a href="index.php">Moonslider</a> | Upload Content</div>
			</header>';
			<div class="fileSelect">
				<form action="index.php" method="POST" enctype="multipart/form-data">
				<br>
				<p class="inputMsg"> Select a data file containing program information </p>
	      <br>
	      <input type="file" name="progData" id="progData"><br><br>
	      <input type="submit" value="Upload Data" name="submit">
				</form>
			</div>
		</body><br>

<?php
session_start();
if (!isset($_SESSION['username'])) {
	header('location:Welcome.php');
}
?>

<!DOCTYPE HTML>
<html>

<head>

	<title>Web Project 2020</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="welcomeuser_style.css">

</head>

<body class="Starters">


	<div id="mySidenav" class="sidenav">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<a href="WelcomeUser.php">Home</a>
		<a href="DataUpload.php">Upload Har</a>
		<a href="heatmap.php">My statistics</a>
		<a href="myprofile.php">My account</a>
		<a href="logout.php">Logout</a>
	</div>

	<div id="main">
		<div class="container">

			<div class="nav-wrapper">

				<div class="left-side">

					<div class="nav-link-wrapper">

						<a><span onclick="openNav()">Menu</span></a>

					</div>

				</div>

			</div>

			<div class="header">
				<span class="text1">Welcome to el Dorado</span>
				<span class="text2">Lets roll</span>
			</div>

		</div>
	</div>

	<div class="footer">
		<h1>How to use</h1>
		<div class="left">
			<h3>Upload HAR</h3>
			<p>Διάλεξε την επιλογή "Upload HAR" για να ανεβάσεις το αρχείο σου στο σύστημα ή να κατεβάσεις τοπικά στον υπολογιστή
				σου το επεξεργασμένο αρχείο. Μην ανησυχείς, όλες οι ευαίσθητες πληροφορίες έχουν απαλειφθεί.</p>
		</div>

		<div class="center">
			<h3>My Stats</h3>
			<p>Διάλεξε την επιλογή "My Statistics" για να δεις σε χάρτη τις τοποθεσίες των IPs στις οποίες
				έχεις αποστείλει HTTP αιτήσεις.</p>
		</div>

		<div class="right">
			<h3>My Account</h3>
			<p>Διάλεξε την επιλογή "My Account" για να επεξεργαστείς τις πληροφορίες του προφίλ σου και να δεις τα
				βασικα στατιστικά για τα δεδομένα που έχεις ανεβάσει.</p>
		</div>
	</div>

</body>


<script src="index_js.js"></script>

</html>
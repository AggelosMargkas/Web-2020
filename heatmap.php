<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header('location:Welcome.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">	
	<link rel="stylesheet" type="text/css" href="stylemap.css">	
	<link rel="stylesheet" href="welcomeuser_style.css">
	
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css">	
	<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/heatmapjs@2.0.2/heatmap.js "></script>
	<script src="https://cdn.rawgit.com/pa7/heatmap.js/develop/plugins/leaflet-heatmap/leaflet-heatmap.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
	<div class="caption">
          <h1>My statistics</h1>
    </div>

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
	
			<div id="mapid"></div>
			<script>
				let mymap = L.map("mapid");
				let osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
				let osmAttrib ='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
				let osm = new L.TileLayer(osmUrl, { attribution: osmAttrib });
				mymap.addLayer(osm);
				mymap.setView([38.246242, 21.7350847],5);
		    	
				let testData = (function () {
				let testData = null;
				$.ajax({
				    'async': true,
				    'global': false,
				    'url': 'heatData.php',
				    'dataType': "json",
				    'success': function(data) {
				        testData = data;
				        
				        var strormzy = {
								max: 8,
								data: testData
						}	

					        let cfg = {
							  "radius": 10,
							  "maxOpacity": 0.4,					  
							  "scaleRadius": true,					  
							  "useLocalExtrema": false,					 
							  latField: 'lat',					  
							  lngField: 'lng',
							};	 
							let heatmapLayer = new HeatmapOverlay(cfg);

							mymap.addLayer(heatmapLayer);
							heatmapLayer.setData(strormzy);       
				    }
				});
				return testData;
				})(); 		
			</script>
		</div>
	</div>

    <!-- footer -->
    <div class="footer1">
      <h2>How to use</h2>
      <p>Σε αυτό το σημείο έχουμε αναλάβει να οπτικοποιήσουμε τα δεδομένα σου, με χρήση heatmap. Εδώ, δηλαδή, μπορείς να δεις σε χάρτη τις τοποθεσίες των IPs στις οποίες έχεις αποστείλει HTTP αιτήσεις. Συγκεκριμένα, στο χάρτη εμφανίζεται ένα heatmap που απεικονίζει την κατανομή του πλήθους των εγγραφών που αφορούν διάφορα ιστοαντικείμενα. </p>
      <p>*Απαραίτητη προϋπόθεση να έχεις ανεβάσει κάποιο αρχείο στην βάση μας.</p>
    </div> 

</body>
<script src="index_js.js"></script>
</html>

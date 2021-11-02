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
	<link rel="stylesheet" type="text/css" href="adminstylemap.css">	
    <link rel="stylesheet" href="admin_style.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css">	
	<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

	<div class="caption">
          <h1>Optimize Data</h1>
    </div>

	<div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="WelcomeAdmin.php">Home</a>
        <a href="ViewStatus.php">View Status</a>
        <a href="RequestTimings.php">Response Times</a>
        <a href="erwtima3.php">HTTP Headers</a>
        <a href="adminHeatmap.php">Optimize Data</a>
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
					//basic tou xarth
					let mymap = L.map("mapid");
					let osmUrl = "https://tile.openstreetmap.org/{z}/{x}/{y}.png";
					let osmAttrib ='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
					let osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});
					mymap.addLayer(osm);
					mymap.setView([38.246242, 21.7350847],4);				
					
					//pairnw dedomena apo th vash
					let markerpositions = [];
					let lines = [];
					$.ajax({
						'async': true,
				    	'global': false,
						'type': "POST",
						'url': "adminHeatData.php",
						'dataType': "json",
						'success': function(data) {

							markerpositions = data[0];
							lines = data[1];
							
							//gia to prasino marker
							var greenIcon = new L.Icon({
							  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
							  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
							  iconSize: [25, 41],
							  iconAnchor: [12, 41],
							  popupAnchor: [1, -34],
							  shadowSize: [41, 41]
							});

							//gia na vrw ta origins
							$.each(lines, function(){

								let orgname = null;
								let orglat = null;
								let orglng = null;
														
								$.each(this, function(index, value){

									if(index == "cname")
									{orgname = value;}

									else if(index == "clat")
									{orglat = value;}

									else {orglng = value;}
									
								});					

								let marker = new L.marker([orglat, orglng], {icon :greenIcon}).addTo(mymap).bindPopup("<b> Location of user: </b>" + orgname);		

								//gia na vrw tis aitiseis
								$.each(markerpositions, function(){

									let templat = null;
									let templng = null;
									let tempname = null;
									
									$.each(this, function(index, value){

										if(index == "lat")
										{templat = value;}

										else if(index == "lng")
										{templng = value;}

										else {tempname = value;}
										
									});

									if (tempname == orgname){
										let marker1 = new L.marker([templat, templng]).addTo(mymap).bindPopup("<b> Location of HTTP Requests of user: </b>" +tempname);						
										let latlngs = Array();
										latlngs.push(marker.getLatLng());		
										latlngs.push(marker1.getLatLng());
										let polyline = L.polyline(latlngs, {color: 'blue'}).addTo(mymap);
									}
								});							
							});
						}
				    });	
			</script>	
		</div>
	</div>

    <!-- footer -->
	<div class="footer2">
      <p> All copyrigths reserved. ©</p>
    </div> 
</body>
<script src="index_js.js"></script>
</html>
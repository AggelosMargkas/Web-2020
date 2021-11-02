<?php
	session_start();
    $username = $_SESSION['username'];

	$con = mysqli_connect('localhost', 'root','') or die (mysqli_conect_errno());  
    mysqli_select_db($con, 'web');

    //$q = "SELECT server_latitude as 'lat', server_longitude as 'lng' FROM `servers_visited` WHERE username = '$username';";
    $q = "SELECT latitude as 'lat', longitude as 'lng' FROM `ip_visited_test` WHERE username = '$username'";
	$res = mysqli_query($con, $q);

	$fetchData = mysqli_fetch_all($res, MYSQLI_ASSOC);

	header('Content-Type: application/json');
	echo json_encode($fetchData);

	mysqli_close($con);
?>

	
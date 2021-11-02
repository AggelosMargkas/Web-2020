<?php
	session_start();

	$con = mysqli_connect('localhost', 'root','') or die (mysqli_conect_errno());  
    mysqli_select_db($con, 'web');

    //$username = $_SESSION['username'];

    $q1 = "SELECT latitude as 'lat', longitude as 'lng', username as 'name' FROM `ip_visited_test` ";
	$res1= mysqli_query($con, $q1);

	$q2 = "SELECT DISTINCT username as 'cname', lat as 'clat', lon as 'clng' FROM `ipuserdata` ";
	$res2 = mysqli_query($con, $q2);

	$fetchData1 = mysqli_fetch_all($res1, MYSQLI_ASSOC);
	$fetchData2 = mysqli_fetch_all($res2, MYSQLI_ASSOC);

	header('Content-Type: application/json');
	echo json_encode(array($fetchData1,$fetchData2));

	mysqli_close($con);
?>

<?php
session_start();

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_conect_errno());

mysqli_select_db($con, 'webproject');

$username = 'Aggelos';

$q = "SELECT latitude as 'lat', longitude as 'lng' FROM `ip_visited_test` WHERE username = 'Aggelos';";
$res = mysqli_query($con, $q);

$fetchData = mysqli_fetch_all($res, MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($fetchData);

mysqli_close($con);

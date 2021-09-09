<?php

session_start();

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());

mysqli_select_db($con, 'web');

$sql = "SELECT SUBSTRING_INDEX(RES_contentType, '/', 1) AS ISTOANTIKEIMENA, ROUND(AVG(RES_age), 2) AS MESIILIKIA FROM responsedata WHERE RES_contentType IS NOT NULL AND RES_age IS NOT NULL GROUP BY ISTOANTIKEIMENA";


$apotelesmata = mysqli_query($con, $sql);

$json_array = array();

while ($row = mysqli_fetch_assoc($apotelesmata)) {

    $json_array[] = $row;
}



echo json_encode($json_array);

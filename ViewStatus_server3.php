<?php

session_start();

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());

mysqli_select_db($con, 'web');

$sql = "SELECT RES_status AS status, count(RES_status) AS plithosKwdikwn   FROM responsedata GROUP BY status";


$apotelesmata = mysqli_query($con, $sql);

$json_array = array();

while ($row = mysqli_fetch_assoc($apotelesmata)) {

    $json_array[] = $row;
}



echo json_encode($json_array);

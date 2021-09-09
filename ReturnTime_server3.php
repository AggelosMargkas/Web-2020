<?php

session_start();

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());

mysqli_select_db($con, 'web');

$sql1 = "SELECT ROUND(AVG(`REQ_timings`)) AS MX, `REQ_method` AS meth, HOUR(DATE_FORMAT(`REQ_startedDateTime`,'%Y-%c-%d %T')) AS h FROM requestdata GROUP BY meth,h";



$apotelesmata1 = mysqli_query($con, $sql1);


$json_array1 = array();


while ($row1 = mysqli_fetch_assoc($apotelesmata1)) {

    $json_array1[] = $row1;
}


header('Content-Type: application/json');
echo json_encode($json_array1);

//echo json_encode($json_array1);
//echo json_encode($json_array2);

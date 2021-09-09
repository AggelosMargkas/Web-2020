<?php

session_start();

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());

mysqli_select_db($con, 'web');

$sql1 = "SELECT ROUND(SUM(`REQ_timings`)) AS MX, SUBSTRING_INDEX(`REQ_contentType`, '/', 1) AS content_type, HOUR(DATE_FORMAT(`REQ_startedDateTime`,'%Y-%c-%d %T')) AS h FROM requestdata WHERE REQ_contentType IS NOT NULL GROUP BY content_type,h";

$sql2 = " SELECT DISTINCT(SUBSTRING_INDEX(`REQ_contentType`, '/', 1)) AS content_type FROM requestdata WHERE REQ_contentType IS NOT NULL
";

$apotelesmata1 = mysqli_query($con, $sql1);
$apotelesmata2 = mysqli_query($con, $sql2);



$json_array1 = array();
$json_array2 = array();


while ($row1 = mysqli_fetch_assoc($apotelesmata1)) {

    $json_array1[] = $row1;
}

while ($row2 = mysqli_fetch_assoc($apotelesmata2)) {

    $json_array2[] = $row2;
}

echo json_encode(array($json_array1, $json_array2));

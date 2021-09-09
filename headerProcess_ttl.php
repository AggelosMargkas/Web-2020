<?php

session_start();

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());

mysqli_select_db($con, 'web');

$sql1 = "SELECT RES_username AS user, SUBSTRING_INDEX(SUBSTRING_INDEX(RES_cacheControl, '=', -1), ',',1) as cacheControl, LEFT(RIGHT(RES_expires, 12),8) AS expires , LEFT(RIGHT(RES_lastModified, 12),8) AS lastModified, SUBSTRING_INDEX(RES_contentType, '/', 1) AS content_type , RES_isp AS isp FROM responsedata WHERE (RES_cacheControl OR (RES_expires AND RES_lastModified)) IS NOT NULL AND RES_contentType IS NOT NULL

";



$apotelesmata1 = mysqli_query($con, $sql1);



$json_array1 = array();


while ($row1 = mysqli_fetch_assoc($apotelesmata1)) {

    $json_array1[] = $row1;
}



echo json_encode(array($json_array1));

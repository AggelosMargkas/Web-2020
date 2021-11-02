<?php
$userAnswer = $_POST['name']; 

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());
mysqli_select_db($con, 'web');

//gia na pairnw ta content types
$q1 = "SELECT DISTINCT SUBSTRING_INDEX(`RES_contentType`, '/', 1) AS contentType FROM `responsedata` WHERE `RES_contentType` IS NOT NULL ";

$q2_a = "SELECT `RES_isp` AS ISP, `RES_cacheControl` as cacheControl, RES_expires AS expires, RES_lastModified AS lastModified,SUBSTRING_INDEX(RES_contentType, '/', 1) AS content_type FROM responsedata WHERE `RES_cacheControl` LIKE '%max-age%' AND `RES_isp` IS NOT NULL AND RES_contentType IS NOT NULL ";
$q2_b = " UNION ALL SELECT `RES_isp` AS ISP, `RES_cacheControl` as cacheControl, RES_expires AS expires, RES_lastModified AS lastModified,SUBSTRING_INDEX(RES_contentType, '/', 1) AS content_type FROM responsedata WHERE `RES_cacheControl` NOT LIKE '%max-age%' AND RES_expires IS NOT NULL AND RES_lastModified IS NOT NULL AND `RES_isp` IS NOT NULL AND RES_contentType IS NOT NULL ";

if (!empty($userAnswer)){
	$q1 = $q1."AND `RES_isp`='$userAnswer'";
	$q2_a = $q2_a."AND `RES_isp`='$userAnswer'";
	$q2_b = $q2_b."AND `RES_isp`='$userAnswer'";
}

$res1 = mysqli_query($con, $q1);
$res2 = mysqli_query($con, $q2_a.$q2_b);

$json_array1 = array();
$json_array2 = array();

while ($row1 = mysqli_fetch_assoc($res1)) {

    $json_array1[] = $row1;
}

while ($row2 = mysqli_fetch_assoc($res2)) {

    $json_array2[] = $row2;
}

echo json_encode(array($json_array1,$json_array2));

mysqli_close($con);
?>
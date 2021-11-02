<?php
$userAnswer = $_POST['name']; 

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());
mysqli_select_db($con, 'web');

//gia na pairnw ta content types
$q1 = "SELECT DISTINCT SUBSTRING_INDEX(`RES_contentType`, '/', 1) AS contentType FROM `responsedata` WHERE `RES_contentType` IS NOT NULL ";

$q_public = "SELECT `RES_isp`, SUBSTRING_INDEX(RES_contentType, '/', 1) AS content_type, `RES_cacheControl`, (Count(`RES_cacheControl`)* 100 / (Select Count(*) From responsedata)) as Score From responsedata WHERE `RES_cacheControl` LIKE '%public%' AND `RES_contentType` IS NOT NULL AND `RES_isp` IS NOT NULL ";

$q_private = "SELECT `RES_isp`, SUBSTRING_INDEX(RES_contentType, '/', 1) AS content_type, `RES_cacheControl`, (Count(`RES_cacheControl`)* 100 / (Select Count(*) From responsedata)) as Score From responsedata WHERE `RES_cacheControl` LIKE '%private%' AND `RES_contentType` IS NOT NULL AND `RES_isp` IS NOT NULL ";

$q_cache = "SELECT `RES_isp`, SUBSTRING_INDEX(RES_contentType, '/', 1) AS content_type, `RES_cacheControl`, (Count(`RES_cacheControl`)* 100 / (Select Count(*) From responsedata)) as Score From responsedata WHERE `RES_cacheControl` LIKE '%no-cache%' AND `RES_contentType` IS NOT NULL AND `RES_isp` IS NOT NULL ";

$q_store = "SELECT `RES_isp`, SUBSTRING_INDEX(RES_contentType, '/', 1) AS content_type, `RES_cacheControl`, (Count(`RES_cacheControl`)* 100 / (Select Count(*) From responsedata)) as Score From responsedata WHERE `RES_cacheControl` LIKE '%no-store%' AND `RES_contentType` IS NOT NULL AND `RES_isp` IS NOT NULL ";

if (!empty($userAnswer)){
	$q1 = $q1."AND `RES_isp`='$userAnswer'";
	$q_public = $q_public."AND `RES_isp`='$userAnswer'";
	$q_private = $q_private."AND `RES_isp`='$userAnswer'";
	$q_cache = $q_cache."AND `RES_isp`='$userAnswer'";
	$q_store = $q_store."AND `RES_isp`='$userAnswer'";
}

$q_public = $q_public." GROUP BY RES_contentType";
$q_private = $q_private." GROUP BY RES_contentType";
$q_cache = $q_cache." GROUP BY RES_contentType";
$q_store = $q_store." GROUP BY RES_contentType";

$res1 = mysqli_query($con, $q1);
$res_public = mysqli_query($con, $q_public);
$res_private = mysqli_query($con, $q_private);
$res_cache = mysqli_query($con, $q_cache);
$res_store = mysqli_query($con, $q_store);


$json_array1 = array();
$json_public = array();
$json_private = array();
$json_cache = array();
$json_store = array();

while ($row1 = mysqli_fetch_assoc($res1)) {

    $json_array1[] = $row1;
}

while ($row_public = mysqli_fetch_assoc($res_public)) {

    $json_public[] = $row_public;
}

while ($row_private = mysqli_fetch_assoc($res_private)) {

    $json_private[] = $row_private;
}

while ($row_cache = mysqli_fetch_assoc($res_cache)) {

    $json_cache[] = $row_cache;
}

while ($row_store = mysqli_fetch_assoc($res_store)) {

    $json_store[] = $row_store;
}

echo json_encode(array($json_array1,$json_public,$json_private,$json_cache,$json_store));

mysqli_close($con);
?>


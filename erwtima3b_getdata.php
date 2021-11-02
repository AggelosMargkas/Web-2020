<?php
$userAnswer = $_POST['name']; 

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());
mysqli_select_db($con, 'web');

//gia na pairnw ta content types
$q1 = "SELECT DISTINCT SUBSTRING_INDEX(`REQ_contentType`, '/', 1) AS contentType FROM `requestdata` WHERE `REQ_contentType` IS NOT NULL ";

$q_stale = "SELECT `REQ_isp`, SUBSTRING_INDEX(REQ_contentType, '/', 1) AS content_type, `REQ_cacheControl`, (Count(`REQ_cacheControl`)* 100 / (Select Count(*) From requestdata)) as Score From requestdata WHERE `REQ_cacheControl` LIKE '%max-stale%' AND `REQ_contentType` IS NOT NULL AND `REQ_isp` IS NOT NULL ";

$q_fresh = "SELECT `REQ_isp`, SUBSTRING_INDEX(REQ_contentType, '/', 1) AS content_type, `REQ_cacheControl`, (Count(`REQ_cacheControl`)* 100 / (Select Count(*) From requestdata)) as Score From requestdata WHERE `REQ_cacheControl` LIKE '%min-fresh%' AND `REQ_contentType` IS NOT NULL AND `REQ_isp` IS NOT NULL ";

if (!empty($userAnswer)){
	$q1 = $q1."AND `REQ_isp`='$userAnswer'";
	$q_stale = $q_stale."AND `REQ_isp`='$userAnswer'";
	$q_fresh = $q_fresh."AND `REQ_isp`='$userAnswer'";
}

$q_stale = $q_stale." GROUP BY REQ_contentType";
$q_fresh = $q_fresh." GROUP BY REQ_contentType";


$res1 = mysqli_query($con, $q1);
$res_stale = mysqli_query($con, $q_stale);
$res_fresh = mysqli_query($con, $q_fresh);

$json_array1 = array();
$json_stale = array();
$json_fresh = array();


while ($row1 = mysqli_fetch_assoc($res1)) {

    $json_array1[] = $row1;
}

while ($row_stale = mysqli_fetch_assoc($res_stale)) {

    $json_stale[] = $row_stale;
}

while ($row_fresh = mysqli_fetch_assoc($res_fresh)) {

    $json_fresh[] = $row_fresh;
}

echo json_encode(array($json_array1, $json_stale, $json_fresh));

mysqli_close($con);
?>


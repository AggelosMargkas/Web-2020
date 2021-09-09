<?php

session_start();

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());

mysqli_select_db($con, 'web');


$sql0 = "SELECT COUNT(REQ_method)  FROM requestdata WHERE REQ_method = 'GET'";
$sql1 = "SELECT COUNT(REQ_method)  FROM requestdata WHERE REQ_method = 'POST'";
$sql2 = "SELECT COUNT(REQ_method)  FROM requestdata WHERE REQ_method = 'HEAD'";
$sql3 = "SELECT COUNT(REQ_method)  FROM requestdata WHERE REQ_method = 'PUT'";
$sql4 = "SELECT COUNT(REQ_method)  FROM requestdata WHERE REQ_method = 'DELETE'";
$sql5 = "SELECT COUNT(REQ_method)  FROM requestdata WHERE REQ_method = 'CONNECT'";
$sql6 = "SELECT COUNT(REQ_method)  FROM requestdata WHERE REQ_method = 'OPTIONS'";
$sql7 = "SELECT COUNT(REQ_method)  FROM requestdata WHERE REQ_method = 'TRACE'";
$sql8 = "SELECT COUNT(REQ_method)  FROM requestdata WHERE REQ_method = 'PATCH'";



$result_get = mysqli_query($con, $sql0);
$result_post = mysqli_query($con, $sql1);
$result_head = mysqli_query($con, $sql2);
$result_put = mysqli_query($con, $sql3);
$result_delete = mysqli_query($con, $sql4);
$result_connect = mysqli_query($con, $sql5);
$result_options = mysqli_query($con, $sql6);
$result_trace = mysqli_query($con, $sql7);
$result_patch = mysqli_query($con, $sql8);




$gets = mysqli_fetch_array($result_get);
$posts = mysqli_fetch_array($result_post);
$heads = mysqli_fetch_array($result_head);
$put = mysqli_fetch_array($result_put);
$delete = mysqli_fetch_array($result_delete);
$connect = mysqli_fetch_array($result_connect);
$options = mysqli_fetch_array($result_options);
$trace = mysqli_fetch_array($result_trace);
$patch = mysqli_fetch_array($result_patch);



$result = array_merge($gets, $posts, $heads, $put, $delete, $connect, $options, $trace, $patch);

echo json_encode($result);

<?php

session_start();

$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());

mysqli_select_db($con, 'web');


$sql = "SELECT COUNT(username)  FROM users";
$result = mysqli_query($con, $sql);

$row = mysqli_fetch_array($result);

echo json_encode($row[0]);

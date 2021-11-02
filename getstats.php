<?php
	session_start();
	
    $con = mysqli_connect('localhost', 'root','') or die (mysqli_conect_errno());
  
    mysqli_select_db($con, 'web');

    $username = $_SESSION['username'];

    $q = "SELECT recordSum, lastUpload FROM `statistics` WHERE name = '$username';";
	$res = mysqli_query($con, $q);

	$fetchData = mysqli_fetch_all($res, MYSQLI_ASSOC);

	$createTable = '<table>';

	$createTable .= '<tr>';
	$createTable .= '<th>Number of records</th>';
	$createTable .= '<th>Date of last upload</th>';

	foreach($fetchData as $userData)
	{
		$createTable .= '<tr>';
		$createTable .= '<td>'.$userData['recordSum'].'</td>';
		$createTable .= '<td>'.$userData['lastUpload'].'</td>';
		$createTable .= '</tr>';	
	}

	$createTable .= '</table>';

	echo $createTable;

	//mysqli_free_result($res);
	mysqli_close($con);
?>
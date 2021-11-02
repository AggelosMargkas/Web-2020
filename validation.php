<?php

	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];

	$con = mysqli_connect('localhost', 'root', '') or die(mysqli_connect_errno());

    mysqli_select_db($con, 'web');
	//mysqli_connect("localhost", "root", "");
	//mysqli_select_db("web");

	$result = mysqli_query($con,"SELECT * from `users` where `username` = '$username' and `password`='$password'") 
			or die("Failed to query database".mysqli_error());
	
	$num = mysqli_num_rows($result);
	
	if($num == 1)
	{
		$_SESSION['username'] = $username;	

		$enum = mysqli_fetch_assoc($result);
		if($enum['type'] == 'admin')
		{
			header('location:WelcomeAdmin.php');
		}
		else
		{
			header('location:WelcomeUser.php');
		}
	}
	else
	{
		echo '<script type="text/javascript">alert("invalid credentials");</script>' ;
		die(header('refresh: 0; url=Welcome.php'));
	}

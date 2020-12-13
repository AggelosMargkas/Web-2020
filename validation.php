<?php

	session_start();

	$username = $_POST['username'];
	$password = $_POST['password'];

	mysql_connect("localhost", "root", "");
	mysql_select_db("webproject");

	$result = mysql_query("SELECT * from `users` where `username` = '$username' and `password`='$password'") 
			or die("Failed to query database".mysql_error());
	
	$num = mysql_num_rows($result);
	
	if($num == 1)
	{
		$_SESSION['username'] = $username;	//cant go back without login

		$enum = mysql_fetch_assoc($result);
		if($enum['type'] == 'admin')
		{
			header('location:WelcomeAdmin.php');
		}
		else
		{
			header('location:WelcomeUser.html');
		}
	}
	else
	{
		//die(header('refresh: 3; url=Welcome.html').'Invalid Credentials, wait 3 seconds or just click <a href="index.php">HERE</a> to check again.');		

		/*echo "login failed";
		header('location:Welcome.html'); //gia na valei ksana stoixeia*/

		echo '<script type="text/javascript">alert("invalid credentials");</script>' ;
		die(header('refresh: 0; url=Welcome.html'));
	}

?>


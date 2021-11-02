<?php
	
    session_start();
    $con = mysqli_connect('localhost', 'root','') or die (mysqli_conect_errno());
  
    mysqli_select_db($con, 'web');

    $email = $_POST['email'];
    $name = $_POST['username'];
    $pass = $_POST['password'];

	$s = "select * from users where username = '$name'";
	$result = mysqli_query($con, $s);
	$num = mysqli_num_rows($result);
	
	if($num == 1)
	{

		echo '<script type="text/javascript">alert("Sorry. Username already exists. Please try again.");</script>' ;
		die(header('refresh: 0; url=register.html'));
	}
	else
	{
		$reg = "INSERT INTO `users` (`email`, `username`, `password`, `type`) VALUES ('$email', '$name', '$pass', 'client')";
		mysqli_query($con, $reg);

		echo '<script type="text/javascript">alert("Sign up succesful!");</script>' ;
		die(header('refresh: 0; url=Welcome.php'));
	}

?>
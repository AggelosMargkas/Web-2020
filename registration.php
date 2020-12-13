<?php
	
    session_start();
    $con = mysqli_connect('localhost', 'root','') or die (mysqli_conect_errno());
  
    mysqli_select_db($con, 'webproject');

    $email = $_POST['email'];
    $name = $_POST['username'];
    $pass = $_POST['password'];

	$s = "select * from users where username = '$name'";
	$result = mysqli_query($con, $s);
	$num = mysqli_num_rows($result);
	
	if($num == 1)
	{
		echo"username already exists";
		header('location:sign_up_form.html');
	}
	else
	{
		$reg = "INSERT INTO `users` (`email`, `username`, `password`, `type`) VALUES ('$email', '$name', '$pass', 'client')";
		mysqli_query($con, $reg);
		//echo "Sign up succesful";
		header('location:WelcomeUser.html');
		//header('location:Welcome.html');
	}

?>
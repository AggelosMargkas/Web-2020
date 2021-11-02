<?php
	session_start();	
	if(!isset($_SESSION['username']))
    {
        header('location:Welcome.php');
    }
?>

<!DOCTYPE html>
<html>

<head>
	<title>My Profile</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="welcomeuser_style.css">
	<link rel="stylesheet" href="stylemyprof.css">
</head>

<body>	

	<div class="caption">
          <h1>My Account</h1>
    </div>

	<div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="WelcomeUser.php">Home</a>
        <a href="DataUpload.php">Upload Har</a>
        <a href="heatmap.php">My statistics</a>
        <a href="myprofile.php">My account</a>
        <a href="logout.php">Logout</a>
    </div>

    <div id="main">
		<div class="container">

			<div class="nav-wrapper">

				<div class="left-side">

					<div class="nav-link-wrapper">

						<a><span onclick="openNav()">Menu</span></a>

					</div>

				</div>
			</div>
		</div>	

		<div class="info">

			<h1>Account information</h1>
			<div id="user-data"></div>

		</div>

		<div class="my-profile">
			<h1>My Profile</h1>
			<form action = "updateinfo.php" method="post">
				<input type="password" name="old_password" class="input-box" placeholder="Enter your current password" required>
				<input type="text" name="old_username" class="input-box" placeholder="Enter your current username" required>

				<input type="text" name="username" class="input-box" placeholder="Enter your new username">
				<button type="submit" class="btn" name="btn1"> Update </button>

				<input type="password" name="password" class="input-box" placeholder="Enter your new password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Must contain at least one number, one uppercase and lowercase letter, one symbol and be at least 8 characters">
				<input type="password" name="cpassword" class="input-box" placeholder= "Confirm your new password">
				<button type="submit" class="btn" name="btn2"> Update </button>

			</form>
		</div>


		<script type="checkpsw.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>

			$(document).ready(function()
			{			
				$.ajax
				({
					url: 'getstats.php',
					success: function(data)
					{					
						$("#user-data").html(data);
					}
				})
			});
		</script>
	</div>

    <!-- footer -->
    <div class="footer1">
      <p> All copyrigths reserved. ©</p>
    </div> 
</body>
<script src="index_js.js"></script>
</html>
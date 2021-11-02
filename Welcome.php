<?php
    session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome page</title>
        <link rel="stylesheet" href="welcome_style.css">
        <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/4/47/Pirate_Flag_of_Jack_Rackham.svg/800px-Pirate_Flag_of_Jack_Rackham.svg.png">
    </head>
       
    <body>
        <!-- header -->
        <div class="header">
          <h1>EL DORADO</h1>
        </div>

        <!-- left side -->
        <div class="left">
            <h1>Your HAR analyzer.</h1>
            <p>The easiest way for tracking information between a web browser and a website.</p>
        </div>

        <!-- sign in right side -->
        <div class="sign-in">
            <h1>Login</h1>
            <form method="post" action="validation.php">
                <div class="txt_field">
                    <input type="text" name="username" required>
                    <span></span>
                    <label>Username</label>
                </div>
                <div class="txt_field">
                    <input type="password" name="password" required>
                    <span></span>
                    <label>Password</label>
                </div>
                <div class="pass">Forgot Password?</div>
                 <input type="submit" value="Login">
                 <div class="signup_link">Not a member? <a href="register.html">Sign up</a></div> 
            </form>
        </div>

        <!-- footer -->
        <div class="footer">
          <p> All copyrigths reserved. ©</p>
        </div> 

    </body>  
</html>
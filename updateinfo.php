<?php

 	session_start();
    $con = mysqli_connect('localhost', 'root','') or die (mysqli_conect_errno());
  
    mysqli_select_db($con, 'web');
    
    $old_password = $_POST['old_password'];
    $old_username = $_POST['old_username'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    //gia na tsekarw an exei dwsei swsta current stoixeia 
    $old = "select * from users where username = '$old_username'";
    $old_result = mysqli_query($con, $old);
    $old_creds = mysqli_fetch_assoc($old_result);

    //gia na tsekarw an uparxei allos xrhsths me to idio username(monadiko)
    $new = "select * from users where username = '$username'";
    $new_result = mysqli_query($con, $new);
    $new_num = mysqli_num_rows($new_result);

    if (isset($_POST['btn1'])) 
    {   //elegxos gia swsta stoixeia
        if($old_creds['password'] == $old_password && $old_creds['username'] == $old_username){
            //elegxos gia monadiko neo username
            if($new_num != 1){
                $upd = "UPDATE `users` SET `username`='$username' WHERE `users`.`username`='$old_username' AND `users`.`password`='$old_password'";
                mysqli_query($con, $upd);
                $_SESSION['username'] = $username;
                echo '<script type="text/javascript">alert("Your username is updated.");</script>' ;
                die(header('refresh: 0; url=myprofile.php'));
            }
            else{
                echo '<script type="text/javascript">alert("Sorry, this username already exists. Try again.");</script>' ;
                die(header('refresh: 0; url=myprofile.php'));                
            }
        }
        else{
            echo '<script type="text/javascript">alert("Wrong credentials. Try again.");</script>' ;
            die(header('refresh: 0; url=myprofile.php'));
        }

    }

    if (isset($_POST['btn2'])) 
    {
        if($old_creds['password'] == $old_password && $old_creds['username'] == $old_password){

        	$upd1 = "UPDATE `users` SET `password`='$password' WHERE `users`.`username`='$old_username' AND `users`.`password`='$old_password'";
    		mysqli_query($con, $upd1);
            echo '<script type="text/javascript">alert("Your password is updated.");</script>' ;
            die(header('refresh: 0; url=myprofile.php'));
        }
        else{
            echo '<script type="text/javascript">alert("Wrong credentials. Try again.");</script>' ;
            die(header('refresh: 0; url=myprofile.php'));
        }
    }
?>

<?php
	
	session_start();
    header('location:Welcome.php');
    session_destroy();
	exit();	
?>
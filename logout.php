<?php
	
	session_start();
	session_destroy();

	header('location: Welcome.html');
	exit();
	
?>
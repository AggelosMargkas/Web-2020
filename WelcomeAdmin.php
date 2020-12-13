<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        header('location:Welcome.html');
    }
?>

<!DOCTYPE HTML>

<html>

<head>

    <title>Web Project 2020</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="styles.css">

</head>



<body class="Starters">

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">View Status</a>
        <a href="#">Response Times</a>
        <a href="#">HTTP Headers</a>
        <a href="#">Optimize Data</a>
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

            <div class="header">

                <span class="text1">Welcome to el Dorado</span>
                <span class="text2">Lets roll</span>

            </div>
        </div>


</body>


<script src="index_js.js"></script>

</html>
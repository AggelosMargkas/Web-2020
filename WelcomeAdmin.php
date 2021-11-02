<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:Welcome.php');
}
?>

<!DOCTYPE HTML>

<html>

<head>

    <title>Web Project 2020</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="admin_style.css">

</head>

<body class="Starters">
    <div id="main">




        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="WelcomeAdmin.php">Home</a>
            <a href="ViewStatus.php">View Status</a>
            <a href="RequestTimings.php">Response Times</a>
            <a href="erwtima3.php">HTTP Headers</a>
            <a href="adminHeatmap.php">Optimize Data</a>
            <a href="logout.php">Logout</a>
        </div>

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
    </div>
    <!-- footer -->
    <div class="footer">
        <p> All copyrigths reserved. ©</p>
    </div>



</body>


<script src="index_js.js"></script>

</html>
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
    <link rel="stylesheet" href="erwtima3_style_new.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>

<body class="Starters">

    <div class="caption">
        <h1>HTTP Headers</h1>
    </div>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="WelcomeAdmin.php">Home</a>
        <a href="ViewStatus.php">View Status</a>
        <a href="RequestTimings.php">Response Times</a>
        <a href="erwtima3.php">HTTP Headers</a>
        <a href="adminHeatmap.php">Optimize Data</a>
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

            <div class="ISPs">

                <h1>Ιστόγραμμα κατανομής των TTL</h1>
                <div id="isps_a"></div>

                <div class="Chart1">
                    <canvas id="Erwtima3a"></canvas>
                </div>

            </div>

            <div class="ISP_b">

                <h1>Ποσοστό max-stales, min-fresh</h1>
                <div id="isps_b"></div>

                <div class="Chart2">
                    <canvas id="Erwtima3b"></canvas>
                </div>

            </div>

            <div class="ISP_g">

                <h1>Ποσοστό cacheability directives</h1>
                <div id="isps_g"></div>

                <div class="Chart3">
                    <canvas id="Erwtima3g"></canvas>
                </div>

            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $.ajax({
                        'async': true,
                        'global': false,
                        'method': "POST",
                        'url': "erwtima3a.php",
                        'success': function(data) {
                            $("#isps_a").html(data);
                        }
                    });
                });
            </script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $.ajax({
                        'async': true,
                        'global': false,
                        'method': "POST",
                        'url': "erwtima3g.php",
                        'success': function(data) {
                            $("#isps_g").html(data);
                        }
                    });
                });
            </script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function() {

                    $.ajax({
                        'async': true,
                        'global': false,
                        'method': "POST",
                        'url': "erwtima3b.php",
                        'success': function(data) {
                            $("#isps_b").html(data);
                        }
                    });
                });
            </script>
        </div>

        <!-- footer -->
        <div class="footer">
            <p> All copyrigths reserved. ©</p>
        </div>

</body>


<script src="index_js.js"></script>
<script src="erwtima3a.js"></script>
<script src="erwtima3b.js"></script>
<script src="erwtima3g.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</html>
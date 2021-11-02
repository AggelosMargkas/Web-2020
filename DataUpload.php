<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:Welcome.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Drag and Drop Har File</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="shortcut icun" href="">
    <link rel="stylesheet" href="DataUpload_style.css">
    <link rel="stylesheet" href="welcomeuser_style.css">

</head>


<body class="Starters">

    <div class="caption">
        <h1>Upload HAR</h1>
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

            <!--<h2> Below you can place your Har File</h2>-->
            <h2>Κάνε κλίκ στο εικονίδιο και ανέβασε το αρχείο.</h2>

            <div class="drop-zone">
                <span class="drop-zone__prompt">Please Drop the file here</span>
                <form class="form" action="./upload" method="POST" enctype="multipart/form-data">
                    <input type="file" id="HarFile" name="MyFile" class="drop-zone__input">
                </form>
            </div>
        </div>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        <button class="locallyDownload" onclick="download(inputFileName, JSON.stringify(MainObject))">

            <i class="fa fa-download"></i>
            Download</button>


        <form action="savetodb_test3.php" method="POST">

            <input type="hidden" name="Filtrarismeno" id="myField1" value="" />
            <input type="hidden" name="Ips" id="myField2" value="" />
            <input type="hidden" name="serverIp_visited" id="myField3" value="" />
            <input type="hidden" name="serverLat_visited" id="myField4" value="" />
            <input type="hidden" name="serverLon_visited" id="myField5" value="" />
            <button class="uploadToSystem">Database</button>

        </form>
    </div>
    <!-- footer -->
    <div class="footer1">
        <p> All copyrigths reserved. ©</p>
    </div>
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="psl.min.js"></script>
    <script src="DataUpload_fuction.js"></script>
    <script src="index_js.js"></script>
    <script src="harProcess.js"></script>
</body>

</html>
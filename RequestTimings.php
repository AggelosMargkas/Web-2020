<!DOCTYPE HTML>

<html>

<head>

    <title>Web Project 2020</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="viewstatus_style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

</head>

<body class="Starters">

    <div class="caption">
          <h1>Response Times</h1>
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

            <form>
                <select name="users" onchange=trigerData(this.value)>
                    <option value="">Επιλογές</option>
                    <option value="1">content</option>
                    <option value="2">Day data</option>
                    <option value="3"> HTTP μέθοδοι</option>
                    <option value="4"> Πάροχοι</option>

                </select>
            </form>

            <div class="Charttt">
                <canvas id="Erwtima2"></canvas>
            </div>
        </div>
    <!-- footer -->
    <div class="footer1">
      <p> All copyrigths reserved. ©</p>
    </div> 

</body>

<script src="index_js.js"></script>
<script src="ReturnTime_function.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

</html>
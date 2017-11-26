<?php
require("incl/checkn.php");
require("incl/logout.php");
require("incl/connection.php");
$admin = "SELECT * FROM users WHERE username = '$login_user' or email = '$login_user'";
$resultadmin = mysqli_query($mysqli, $admin);
$row = mysqli_fetch_array($resultadmin, MYSQLI_ASSOC);
$isadmin = $row['permission'];
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="Here, we give you the most honest/professional car reviews!">
    <meta name="keywords" content="Car review,Cars,Safty of cars">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarTek - Home</title>
    <link rel="stylesheet" href="css/bootstrap-icon.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" href="img/steffgramicon.png">
</head>

<body>
<nav class="normal">
    <ul>
        <li>
            <a href="index.php"><img src="img/steffgramicon.png" alt="CarTek logo"></a>
        </li>
        <li><a class="active" href="#about">About us</a></li>
        <?php if ($login_user == '') : ?>
            <li style="float:right"><a href="login.php"><span class="glyphicon glyphicon-user" style="width: 15px"
                                                              aria-hidden="true"></span> Login</a></li>
        <?php endif; ?>
        <?php if ($login_user != '') : ?>
            <li style="float:right"><a href="javascript:void(0)" class="dropbtn" onclick="setdropdown()"><span
                            class="glyphicon glyphicon-user" style="width: 15px"
                            aria-hidden="true"></span> <?php echo $login_user; ?></a>
                <div class="dropdown-content" id="pmenu">
                    <a href="upload.php"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Upload</a>
                    <a href="accountsettings.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        Settings</a>
                    <a href="?logout=1"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<nav class="mobile">
    <ul>
        <li>
            <?php if ($login_user == '') : ?>
                <a href="javascript:void(0)" class="mdropbtn" onclick="mobiledrop()"><img src="img/steffgramicon.png"
                                                                                          alt="CarTek logo"></a>
            <?php endif; ?>
            <?php if ($login_user != '') : ?>
                <a href="javascript:void(0)" class="mdropbtn" onclick="mobiledrop()"><span
                            class="glyphicon glyphicon-user" style="width: 15px"
                            aria-hidden="true"></span> <?php echo $login_user; ?></a>
            <?php endif; ?>
            <div class="mobile-dropdown-content" id="mmenu">
                <a href="index.php">Home</a>
                <a href="#about">About us</a>
                <?php if ($login_user != '') : ?>
                    <a href="upload.php"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Upload</a>
                    <a href="accountsettings.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        Settings</a>
                    <a href="?logout=1"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
                <?php endif; ?>
                <?php if ($login_user == '') : ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</nav>
<br>
<section class="doblank">
  <section class="note">
    <h1>About us</h1>
    <p>BAP project P1.3 Mediacollage amsterdam. Educational use!</p>
</section>
<script src="script/main.js"></script>
</body>

</html>

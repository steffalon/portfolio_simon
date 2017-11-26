<?php
 require("incl/checkn.php");
 require("incl/logout.php");
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
    <link rel="icon" href="img/Logo_CarTek.png">

</head>

<body>
    <video id="bkv" autoplay="" loop="" muted="">
    <source src="video/movie.mp4" type="video/mp4">
  </video>
    <nav class="normal">
        <ul>
            <li>
                <a class="active" href="index.php"><img src="img/Logo_CarTek.png" alt="CarTek logo"></a>
            </li>
            <li><a id="gonews" href="#news">Latest news</a></li>
            <li><a href="#forum">Forum</a></li>
            <li><a href="#about">About us</a></li>
            <?php if($login_user == '') : ?>
            <li style="float:right"><a href="login.php"><span class="glyphicon glyphicon-user" style="width: 15px" aria-hidden="true"></span> Login</a></li>
            <?php endif; ?>
            <?php if($login_user != '') : ?>
            <li style="float:right"><a href="javascript:void(0)" class="dropbtn" onclick="setdropdown()"><span class="glyphicon glyphicon-user" style="width: 15px" aria-hidden="true"></span> <?php echo $login_user;?></a>
                <div class="dropdown-content" id="pmenu">
                    <a href="profile.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Profile</a>
                    <a href="accountsettings.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings</a>
                    <a href="?logout=1"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
                </div>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <nav class="mobile">
        <ul>
            <li>
                <?php if($login_user == '') : ?>
                <a href="javascript:void(0)" class="mdropbtn" onclick="mobiledrop()"><img src="img/Logo_CarTek.png" alt="CarTek logo"></a>
                <?php endif; ?>
                <?php if($login_user != '') : ?>
                    <a href="javascript:void(0)" class="mdropbtn" onclick="mobiledrop()"><span class="glyphicon glyphicon-user" style="width: 15px" aria-hidden="true"></span> <?php echo $login_user;?></a>
                <?php endif; ?>
                <div class="mobile-dropdown-content" id="mmenu">
                    <a href="index.php">Home</a>
                    <a href="#forum">Forum</a>
                    <a href="#about">About us</a>
                    <?php if($login_user != '') : ?>
                    <a href="profile.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Profile</a>
                    <a href="accountsettings.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings</a>
                    <a href="?logout=1"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
                    <?php endif; ?>
                    <?php if($login_user == '') : ?>
                    <a href="login.php">Login</a>
                    <?php endif; ?>
                </div>
            </li>
        </ul>
    </nav>
    <img class="support" src="img/mainbkv.jpg" alt="Garage full of cars">
    <section class="notebkv">
        <h1>Welcome user!</h1>
        <p>This is a project about the development of this website. I really like cars so why not building a website about cars. This version contain photos and videos from
        other authors creators. I am using this website for educational projects!</p>
    </section>
    <section class="doblank">
        <section class="news">
            <h1>Latest news</h1>
            <table cellspacing="0">
                <tr onclick="window.document.location='#1';">
                    <td><img height="50" src="img/29755a.png" alt="Porsche 718 boxster photo">
                    <td>11/04/2016</td>
                    <td>Porsche 718 Boxster S</td>
                </tr>
                <tr onclick="window.document.location='#2';">
                    <td><img height="50" src="img/bmwm2.png" alt="BMW M2 photo">
                    <td>10/04/2016</td>
                    <td>BMW M4</td>
                </tr>
            </table>
        </section>
    </section>
    <script src="script/home.js"></script>
</body>

</html>

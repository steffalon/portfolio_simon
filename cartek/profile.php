<?php
 require("incl/check.php");
 require("incl/connection.php");
 require("incl/logout.php");
 $admin = "SELECT * FROM users WHERE username = '$login_user' or email = '$login_user'";
 $resultadmin=mysqli_query($mysqli,$admin);
 $row=mysqli_fetch_array($resultadmin,MYSQLI_ASSOC);
 $isadmin = $row['permission'];

?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Here, we give you the most honest/professional car reviews!">
    <meta name="keywords" content="Car review,Cars,Safty of cars">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarTek - Profile</title>
    <link rel="stylesheet" href="css/profile.css">
      <link rel="stylesheet" href="css/bootstrap-icon.css">
    <link rel="icon" href="img/Logo_CarTek.png">
  </head>

  <body>
    <nav class="normal">
        <ul>
            <li>
                <a href="index.php"><img src="img/Logo_CarTek.png" alt="CarTek logo"></a>
            </li>
            <li><a id="gonews" href="index.php#news">Latest news</a></li>
            <li><a href="#forum">Forum</a></li>
            <li><a href="#about">About us</a></li>
            <li style="float:right" class="active"><a href="javascript:void(0)" class="dropbtn" onclick="setdropdown()"><span class="glyphicon glyphicon-user" style="width: 15px" aria-hidden="true"></span> <?php echo $login_user;?></a>
                <div class="dropdown-content" id="pmenu">
                    <a href="profile.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Profile</a>
                    <a href="accountsettings.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Settings</a>
                    <a href="?logout=1"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
                </div>
            </li>
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
    <section class="note">
      <h1 class="hello">Hello, <?php echo $login_user;?>!</h1>
      <br>
        <button class="lbutton" onclick="location.href='accountsettings.php'" type="button"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> settings</button>
        <button class="lbutton" onclick="confirmD()">Delete account</button>
        <br><?php if($isadmin == 'admin') : ?>
            <br>
            <h2>Admin dashboard</h2>
            <br>
            <button class="lbutton" onclick="location.href='publicmessage.php'" type="button">Send news to users</button>
            <button class="lbutton" onclick="location.href='userlist.php'" type="button">List of users</button>
        <?php endif; ?>
    </section>
z
    <script type="text/javascript">
        function confirmD()
        {
            if (confirm("Are you sure to delete your account?"))
                location.href='incl/deleteA.php';
        }
    </script>
  </body>
</html>

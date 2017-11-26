<?php
 require("incl/check.php");
 require("incl/connection.php");
 require("incl/logout.php");
 $email = "SELECT * FROM users WHERE username = '$login_user' or email = '$login_user'";
 $resultemail=mysqli_query($mysqli,$email);
 $row=mysqli_fetch_array($resultemail,MYSQLI_ASSOC);
 $isemail = $row['email'];
 $error = "";
 $news = $row['getnews'];
 if ($news == 1) {
     $doingnews = "checked";
 }
if (isset($_POST['savechanges'])) {
    if (!empty($_POST['changeusername']) && !empty($_POST['changeemail'])) {
        if (!empty($_POST['changeusername'])) {
            $username = $_POST['changeusername'];
            $sql = "SELECT username FROM users WHERE username='$username'";
            $resulting = mysqli_query($mysqli, $sql);
            if(mysqli_num_rows($resulting)>=1 && $username !== $login_user)
            {
                $error = "name already exists";
            } else {
                $username = stripslashes($username);
                $username = mysqli_real_escape_string($mysqli, $username);
                $setusername = "UPDATE users SET username = '$username' WHERE username = '$login_user' OR email = '$login_user'";
                $resultusername = mysqli_query($mysqli, $setusername);
                $_SESSION['username'] = $username;
                $user_check = $_SESSION['username'];
            }
        }
        if (!empty($_POST['changeemail'])) {
            $email1 = $_POST['changeemail'];
            $email1 = stripslashes($email1);
            $email1 = mysqli_real_escape_string($mysqli, $email1);
            $setemail = "UPDATE users SET email = '$email1' WHERE username = '$user_check' OR email = '$login_check'";
            $resultemail = mysqli_query($mysqli, $setemail);
        }
        if (!empty($_POST['changepassword'])) {
            $password = $_POST['changepassword'];
            $password = stripslashes($password);
            $password = mysqli_real_escape_string($mysqli, $password);
            $password = openssl_digest($password, 'sha512');
            $setpassword = "UPDATE users SET password = '$password' WHERE username = '$user_check' OR email = '$login_check'";
            $resultemail = mysqli_query($mysqli, $setpassword);
        }
        if(isset($_POST['changenewsp'])) {
            $setnewsp = "UPDATE users SET getnews = '1' WHERE username = '$user_check' OR email = '$login_check'";
            $resultnewsp = mysqli_query($mysqli, $setnewsp);
        }else{
            $setnewsp = "UPDATE users SET getnews = '0' WHERE username = '$user_check' OR email = '$login_check'";
            $resultnewsp = mysqli_query($mysqli, $setnewsp);
        }
        header("location: accountsettings.php");
    } else {
        $error = "Username or/and Email is/are not filled in.";
    }
}

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
        <form method="post">
      <h1 class="hello">Account settings of <?php echo $login_user;?>.</h1>
      <br>
        <label>Change name</label>
            <br>
        <input class="field" type="text" id="changeusername" name="changeusername" autofocus="" value="<?php echo $login_user;?>">
        <br><br>
        <label>Change Email</label>
            <br>
        <input class="field" type="email" id="changeemail" name="changeemail" value="<?php echo $isemail;?>">
        <br><br>
        <label>Change Password</label>
            <br>
        <input class="field" type="password" id="changepassword" name="changepassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
        <br><br>
            <input type="checkbox" id="changenewsp" name="changenewsp" <?php echo $doingnews;?>><label> Get news and updates on my email</label>
            <br><br>
        <button class="lbutton" onclick="location.href='profile.php'" type="button"><span class="glyphicon glyphicon-arrow-left" style="width: 15px" aria-hidden="true"></span></button>
            <button class="lbutton" type="submit" id="savechanges" name="savechanges" value="Save changes"><span class="glyphicon glyphicon-floppy-disk" style="width: 15px" aria-hidden="true"></span></button>
            <br>
            <p><span style="color:red;"><?php echo $error; ?></span></p>
        </form>
    </section>
    <script src="script/profile.js"></script>
  </body>
</html>

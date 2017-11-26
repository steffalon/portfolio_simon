<?php
  require('incl/addaccount.php');
  require('incl/connection.php');
  session_start();
  $user_check=$_SESSION['username'];

  $sql = "SELECT username FROM users WHERE (username = '$username' or email = '$username')='$user_check' ";
  $result=mysqli_query($mysqli,$sql);

  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

  $login_user=$row['username'];

  if(isset($user_check))
  {
  header("Location: profile.php");
  }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="Here, we give you the most honest/professional car reviews!">
    <meta name="keywords" content="Car review,Cars,Safty of cars">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarTek - Register</title>
    <link rel="stylesheet" href="css/login.css">
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
            <li style="float:right"><a class="active" href="login.php"><span class="glyphicon glyphicon-user" style="width: 15px" aria-hidden="true"></span> Login</a></li>
        </ul>
    </nav>
    <nav class="mobile">
        <ul>
            <li>
                <?php if($login_user !== '') : ?>
                    <a href="javascript:void(0)" class="mdropbtn" onclick="mobiledrop()"><img src="img/Logo_CarTek.png" alt="CarTek logo"></a>
                <?php endif; ?>
                <div class="mobile-dropdown-content" id="mmenu">
                    <a href="index.php">Home</a>
                    <a href="#forum">Forum</a>
                    <a href="#about">About us</a>
                    <a href="login.php">Login</a>
                </div>
            </li>
        </ul>
    </nav>
    <img class="support" src="img/Test-Drive.jpg" alt="2 american cars">
    <?php if($setupcmd == '0') : ?>
    <section class="note">
        <form method="post">
            <h1>Register</h1>
            <br>
            <input class="field" type="email" id="email" name="email" autofocus="" autocomplete="on" placeholder="Email">
            <br><br>
            <input class="field" type="text" id="username" name="username" autocomplete="on" placeholder="Username">
            <br><br>
            <input class="field" type="password" id="password" name="password" placeholder="Password">
            <br><br>
            <input type="checkbox" id="newsp" name="newsp"><label>Get news and updates on my email</label>
            <br><br>
            <button class="lbutton" onclick="location.href='login.php'" type="button"><span class="glyphicon glyphicon-arrow-left" style="width: 15px" aria-hidden="true"></span></button>
            <input class="lbutton" type="submit" id="submitting" name="submitting" value="Submit">
            <?php endif; ?>
            <?php if($setupcmd == '1') : ?>
            <section style="background-color: rgba(100, 255, 68, 0.8); border-color: white" class="note">
                <form method="post">
                    <h1>Your request has been accepted and created.</h1>
                    <p>Check your email for the validation code.</p>
                    <button style="width: 79.6%; background-color: rgba(100, 255, 68, 0.8); border-color: white" class="lbutton" onclick="location.href='login.php'" type="button"><span class="glyphicon glyphicon-arrow-left" style="width: 15px" aria-hidden="true"></span></button>
            <?php endif; ?>
            <?php if($setupcmd == '2') : ?>
            <section style="background-color: rgba(100, 255, 68, 0.8); border-color: white" class="note">
                <form method="post">
                 <h1>Thank you <?php echo $username; ?>!</h1>
                    <p>your account is now validated</p>
                    <button style="width: 79.6%; background-color: rgba(100, 255, 68, 0.8); border-color: white" class="lbutton" onclick="location.href='login.php'" type="button"><span class="glyphicon glyphicon-arrow-left" style="width: 15px" aria-hidden="true"></span></button>
            <?php endif; ?>
            <br>
            <br>
            <p><span style="color:red;"><?php echo $error; ?></span></p>
        </form>
    </section>
    <script src="script/login.js"></script>
</body>

</html>

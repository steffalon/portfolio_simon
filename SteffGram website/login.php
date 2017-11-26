<?php
  require('incl/processing.php');
  require('incl/connection.php');
  session_start();
  $user_check=$_SESSION['username'];

  $sql = "SELECT username FROM users WHERE (username = '$username' or email = '$username')='$user_check' ";
  $result=mysqli_query($mysqli,$sql);

  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

  $login_user=$row['username'];

  if(isset($user_check))
  {
  header("Location: index.php");
  }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="Here, we give you the most honest/professional car reviews!">
    <meta name="keywords" content="Car review,Cars,Safty of cars">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarTek - Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/bootstrap-icon.css">
    <link rel="icon" href="img/steffgramicon.png">
</head>

<body>
    <nav class="normal">
        <ul>
            <li>
                <a href="index.php"><img src="img/steffgramicon.png" alt="CarTek logo"></a>
            </li>
            <li><a href="#about">About us</a></li>
            <li style="float:right"><a class="active" href="login.php"><span class="glyphicon glyphicon-user" style="width: 15px" aria-hidden="true"></span> Login</a></li>
        </ul>
    </nav>
    <nav class="mobile">
        <ul>
            <li>
                <?php if($login_user !== '') : ?>
                    <a href="javascript:void(0)" class="mdropbtn" onclick="mobiledrop()"><img src="img/steffgramicon.png" alt="CarTek logo"></a>
                <?php endif; ?>
                <div class="mobile-dropdown-content" id="mmenu">
                    <a href="index.php">Home</a>
                    <a href="login.php">Login</a>
                </div>
            </li>
        </ul>
    </nav>
    <img class="support" src="img/background-login.jpeg" alt="Road">
    <section class="note">
        <form method="post">
            <h1>Login to account</h1>
            <br>
            <input class="field" type="text" id="username" name="username" autofocus="" autocomplete="on" placeholder="Username or email">
            <br><br>
            <input class="field" type="password" id="password" name="password" placeholder="Password">
            <br><br>
            <input class="lbutton" type="submit" id="submitting" name="submitting" value="Login">
            <button class="lbutton" onclick="location.href='register.php'" type="button">Register</button>
            <br>
            <button style="width: 79.6%" class="lbutton" onclick="location.href='recovery.php'" type="button">Forgot password?</button>
            <br>
            <br>
            <p><span style="color:red;"><?php echo $error; ?></span></p>
        </form>
    </section>
    <script src="script/main.js"></script>
</body>

</html>

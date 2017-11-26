<?php
require("incl/check.php");

require("incl/connection.php"); //Establishing connection with database

$admin = "SELECT * FROM users WHERE username = '$login_user' or email = '$login_user'";
$resultadmin=mysqli_query($mysqli,$admin);
$row=mysqli_fetch_array($resultadmin,MYSQLI_ASSOC);
$isadmin = $row['permission'];

if ($isadmin !== 'admin') {
    header("Location: profile.php");
}


$error = ""; //Variable for storing our errors.
if(isset($_POST["submitting"])) {
    if (empty($_POST["subject"]) || empty($_POST["msg"])) {
        $error = "Both fields are required.";
    } else {
        $subject = $_POST['subject'];
        $msg = $_POST['msg'];
        $headers = "CarTek News" . "<News.CarTek@steffalon.com>" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";

        $query = "SELECT * FROM users WHERE getnews='1'";
        $result = mysqli_query($mysqli, $query)
            or $error = "Cannot find users";

        while($resulting = mysqli_fetch_array($result)) {
            $to = $resulting['email'];
            mail($to, $subject, $msg, 'From: ' . $headers)
                or $error = "Failed to send an email";
        }
        if ($error == "") {
            header("location: profile.php");
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="Here, we give you the most honest/professional car reviews!">
    <meta name="keywords" content="Car review,Cars,Safty of cars">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarTek - Message</title>
    <link rel="stylesheet" href="css/sendmessages.css">
    <link rel="stylesheet" href="css/bootstrap-icon.css">
    <link rel="icon" href="img/Logo_CarTek.png">
    <script src="ckeditor/ckeditor.js"></script>
</head>

<body>
<nav>
    <ul>
        <li>
            <a href="index.php"><img src="img/Logo_CarTek.png" alt="CarTek logo"></a>
        </li>
        <li><a id="gonews" href="index.php#news">Latest news</a></li>
        <li><a href="#forum">Forum</a></li>
        <li><a href="#about">About us</a></li>
        <li style="float:right"><a class="active" href="login.php"><span class="glyphicon glyphicon-user" style="width: 15px" aria-hidden="true"></span> <?php echo $login_user;?></a></li>
    </ul>
</nav>
<section class="note">
    <form method="post" action="">
    <h2>Post news to users</h2>
    <br><br>
    <input class="field" type="text" id="subject" name="subject" placeholder="Subject">
    <br>
        <textarea class="field" id="msg" name="msg" rows="5"></textarea>
    <br>
        <button class="lbutton" onclick="location.href='profile.php'" type="button"><span class="glyphicon glyphicon-arrow-left" style="width: 15px" aria-hidden="true"></span></button>
        <button class="lbutton" type="submit" id="submitting" name="submitting"><span class="glyphicon glyphicon-envelope" style="width: 15px" aria-hidden="true"></span></button>
    <br>
    <p><span style="color:red;"><?php echo $error; ?></span></p>
    </form>
</section>
    <script src="script/home.js"></script>
    <script>
        CKEDITOR.replace( 'msg' );
    </script>
</body>
<!-- https://designschool.canva.com/blog/website-color-schemes/ -->

</html>

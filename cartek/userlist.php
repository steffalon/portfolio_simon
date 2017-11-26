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

$query = "SELECT * FROM users ORDER BY uid ASC";
$result = mysqli_query($mysqli, $query);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="Here, we give you the most honest/professional car reviews!">
    <meta name="keywords" content="Car review,Cars,Safty of cars">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarTek - List of users</title>
    <link rel="stylesheet" href="css/sendmessages.css">
    <link rel="stylesheet" href="css/bootstrap-icon.css">
    <link rel="icon" href="img/Logo_CarTek.png">
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
    <form method="post">
    <h2>List of users</h2>
    <br><br>
        <table class='userlist' cellspacing='0' border="1">
            <tr style="text-align: center">
                <th>ID</th>
                <th>Email</th>
                <th>Username</th>
                <th>Permission</th>
                <th>Delete user</th>
            </tr>
            <?php
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }

            while($row = mysqli_fetch_array($result))
            {
                echo "<tr>";
                echo "<td>" . $row['uid'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                $getperm = $row['uid'];
                $getname = $row['uid'] . "p";
                $setpermission= $row['permission'];
                echo "<td><select name='$getname' id='$getname' class='lbutton' onchange='this.form.submit()' style='width: 100%'>
                        <option value=\"$setpermission\">" . $setpermission . "</option>
                        <option value=\"user\">user</option>
                        <option value=\"admin\">admin</option>
                        <option value=\"banned\">banned</option>
                        </select></td>";
                $getdelete = $row['uid'];
                echo "<td><input class='lbutton' style='width: 100%' type='submit' name='$getdelete' id='$getdelete' value='DELETE'></td>";
                echo "</tr>";
                if (isset($_POST["$getdelete"])) {
                    $dquery = "DELETE FROM users WHERE uid = '$getdelete' limit 1";
                    $dresult = mysqli_query($mysqli, $dquery);
                    header("location: userlist.php");
                }
                if (isset($_POST["$getname"])) {
                    $settingperm = $_POST["$getname"];
                    $pquery = "UPDATE users SET permission = '$settingperm' WHERE uid = '$getperm'";
                    $presult = mysqli_query($mysqli, $pquery);
                    header("location: userlist.php");
                }
            }
            ?>
        </table>
        <br><br>
        <button class="lbutton" onclick="location.href='profile.php'" type="button"><span class="glyphicon glyphicon-arrow-left" style="width: 15px" aria-hidden="true"></span></button>
        <br>
    <p><span style="color:red;"><?php echo $error; ?></span></p>
    </form>
</section>
    <script src="script/home.js"></script>
</body>
<!-- https://designschool.canva.com/blog/website-color-schemes/ -->

</html>

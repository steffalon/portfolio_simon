<?php
require("incl/checkn.php");
require("incl/logout.php");
require("incl/connection.php");
$admin = "SELECT * FROM users WHERE username = '$login_user' or email = '$login_user'";
$resultadmin = mysqli_query($mysqli, $admin);
$row = mysqli_fetch_array($resultadmin, MYSQLI_ASSOC);
$isadmin = $row['permission'];

$getImages = "SELECT * FROM image_location ORDER BY settime DESC";
$resultImage = mysqli_query($mysqli, $getImages);
if (isset($_POST['foto_sorteren'])) {
  unset($setsearch);
  $sorteer_op = $_POST['foto_sorteren'];
  if ($sorteer_op == 'recently') {
    $getImages = "SELECT * FROM image_location ORDER BY settime DESC";
    $resultImage = mysqli_query($mysqli, $getImages);
  }
  elseif ($sorteer_op == 'last_time') {
    $getImages = "SELECT * FROM image_location ORDER BY settime ASC";
    $resultImage = mysqli_query($mysqli, $getImages);
  }
  elseif ($sorteer_op == 'random') {
    $getImages = "SELECT * FROM image_location ORDER BY RAND()";
    $resultImage = mysqli_query($mysqli, $getImages);
  }
  unset($_POST['foto_sorteren']);
}

if ($_POST['findterm']) {
  $setsearch = $_POST['findterm'];
  stripslashes($mysqli, $setsearch);
  mysqli_real_escape_string($mysqli, $setsearch);
  $getImages = "SELECT * FROM image_location WHERE username LIKE '%$setsearch%'
   OR description LIKE '%$setsearch%'";
  $resultImage = mysqli_query($mysqli, $getImages);
}
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
            <a class="active" href="index.php"><img src="img/steffgramicon.png" alt="CarTek logo"></a>
        </li>
        <li><a href="about.php">About us</a></li>
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
                <a href="about.php">About us</a>
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
  <form method="post">
    <section class="sorteren">
        <select name="foto_sorteren" onchange="this.form.submit()">
            <option>Sort on..</option>
            <option value="time">Time</option>
            <option value="last_time">Descending</option>
            <option value="random">Random</option>
        </select>
        <input type="search" name="findterm" onchange="this.form.submit()" placeholder="Search here">
    </section>
  </form>
    <?php
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    while ($rowImage = mysqli_fetch_array($resultImage)) {
        echo "<section class=\"photoholder\">";
        echo "<h1>" . $rowImage['username'] . "</h1>";
        echo "<img src='userimage/" . $rowImage['dir'] . "' class=\"image\" alt=\"Steffgram photo by " .  $rowImage['username'] ."\">";
        echo "<article>";
        echo "<h3>" . $rowImage['title'] . "</h3>";
        echo "<p>" . $rowImage['description'] . "</p>";
        echo "<p style=\"font-size: small\">Time: " . $rowImage['settime'] . "</p>";
        echo "</article>";
        echo "</section>";
    }
    ?>
</section>
<script src="script/main.js"></script>
</body>

</html>

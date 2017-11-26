<?php
require('incl/connection.php');
require('incl/logout.php');
require("incl/check.php");
session_start();

$error = ""; //Variable for storing our errors.
if (isset($_POST["submitting"])) {
    if (empty($_POST["title"]) || empty($_POST["msg"]) || empty($_FILES['upload-file'])) {
        $error = "All fields are required.";
    } else {
        // Define $username and $password.
        $title = $_POST['title'];
        $msg = $_POST['msg'];
        if ($_FILES['upload-file']) {
            function generateRandomString($length = 50) { // function that creates a random string.
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }
            $setcode = generateRandomString(); //apply random string to variable.

            $file_name = $_FILES['upload-file']['name'];
            $file_size = $_FILES['upload-file']['size'];
            $file_tmp = $_FILES['upload-file']['tmp_name'];
            $file_type = $_FILES['upload-file']['type'];
            $file_ext = strtolower(end(explode('.', $_FILES['upload-file']['name'])));

            $expensions = array("jpeg", "jpg", "png", "gif");

            if (in_array($file_ext, $expensions) === false) {
                $error = "File format not allowed, please choose a JPEG, PNG, GIF file.";
            }

            if ($file_size > 2097152) {
                $error = 'File size must be excately 2 MB';
            }

            if (empty($error) == true) {
                $get_details = "SELECT * FROM users WHERE username = '$user_check'";
                $result2 = mysqli_query($mysqli, $get_details);
                $row2=mysqli_fetch_array($result2,MYSQLI_ASSOC);

                $uid = $row2['uid'];
                $username = $row2['username'];
                $setcode = $setcode . '.' . $file_ext;

                $existvalue = "SELECT dir FROM image_location WHERE dir='$setcode'"; //check if the key already exist
                $resultexistvalue = mysqli_query($mysqli, $existvalue);
                while (mysqli_num_rows($resultexistvalue) > 0) { //exist? keep making new keys until its a unique key.
                    $setcode = generateRandomString();
                    $setcode = $setcode . '.' . $file_ext;
                    $existvalue = "SELECT dir FROM image_location WHERE dir='$setcode'";
                    $resultexistvalue = mysqli_query($mysqli, $existvalue);
                }
                move_uploaded_file($file_tmp, "userimage/" . $setcode);
                $sql2 = "INSERT INTO image_location (uid, username, title, description, dir)
                VALUES ('$uid', '$username', '$title', '$msg', '$setcode')";
                $complete = mysqli_query($mysqli, $sql2);
                header('location: index.php');
            }
        }
    }
    unset($_POST);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="Here, we give you the most honest/professional car reviews!">
    <meta name="keywords" content="Car review,Cars,Safty of cars">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstaSteff - upload</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/bootstrap-icon.css">
    <link rel="icon" href="img/steffgramicon.png">
</head>

<body>
<nav class="normal">
    <ul>
        <li>
            <a class="active" href="index.php"><img src="img/steffgramicon.png" alt="CarTek logo"></a>
        </li>
        <li><a href="#about">About us</a></li>
        <?php if ($user_check == '') : ?>
            <li style="float:right"><a href="login.php"><span class="glyphicon glyphicon-user" style="width: 15px"
                                                              aria-hidden="true"></span> Login</a></li>
        <?php endif; ?>
        <?php if ($user_check != '') : ?>
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
            <?php if ($user_check == '') : ?>
                <a href="javascript:void(0)" class="mdropbtn" onclick="mobiledrop()"><img src="img/steffgramicon.png"
                                                                                          alt="CarTek logo"></a>
            <?php endif; ?>
            <?php if ($user_check != '') : ?>
                <a href="javascript:void(0)" class="mdropbtn" onclick="mobiledrop()"><span
                            class="glyphicon glyphicon-user" style="width: 15px"
                            aria-hidden="true"></span> <?php echo $login_user; ?></a>
            <?php endif; ?>
            <div class="mobile-dropdown-content" id="mmenu">
                <a href="index.php">Home</a>
                <a href="#about">About us</a>
                <?php if ($user_check != '') : ?>
                    <a href="upload.php"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Upload</a>
                    <a href="accountsettings.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        Settings</a>
                    <a href="?logout=1"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
                <?php endif; ?>
                <?php if ($user_check == '') : ?>
                    <a href="login.php">Login</a>
                <?php endif; ?>
            </div>
        </li>
    </ul>
</nav>
<section class="doblank">
    <form enctype="multipart/form-data" method="post">
        <section class="note">
            <input type="file" style="width: 100%" class="lbutton" VALUE="test" name="upload-file" accept="image/*"/>
            <br>
            <input type="text" class="field" name="title" placeholder="Title" style="width: 100%;" maxlength="50">
            <br>
            <textarea class="field" id="msg" name="msg" style="width: 100%" placeholder="Description" rows="5" maxlength="100"></textarea>
            <br>
            <input type="submit" name="submitting" class="lbutton" style="width: 100%">
            <br>
            <br>
            <p><span style="color:red;"><?php echo $error; ?></span></p>
        </section>
    </form>
</section>
<script src="script/main.js"></script>

</body>

</html>

<?php
session_start();
require("connection.php"); //Establishing connection with database

$error = ""; //Variable for storing our errors.
$setupcmd = "0";
if(!empty($_GET['rcode']) && !empty($_GET['id'])) {
    $rcode = $_GET['rcode'];
    $userid = $_GET['id'];
    $validatecode = "SELECT uid FROM validation_redeem WHERE gcode='$rcode'";
    $resultvalidatecode = mysqli_query($mysqli, $validatecode);
    $validateid = "SELECT * FROM users WHERE uid='$userid'";
    $resultvalidateid = mysqli_query($mysqli, $validateid);
    $rowid=mysqli_fetch_array($resultvalidateid,MYSQLI_ASSOC);
    $matchid = $rowid['uid'];
    $username = $rowid['username'];
    if(mysqli_num_rows($resultvalidatecode) > 0 && $matchid == $userid) {
        $activatevalidation = "UPDATE users SET validate_time = '0' WHERE uid = '$matchid'";
        $resultactivation = mysqli_query($mysqli, $activatevalidation);
        $deletevalidationcode = "DELETE FROM validation_redeem WHERE uid = '$matchid' limit 1";
        $resultdeletevalidation = mysqli_query($mysqli, $deletevalidationcode);
        $setupcmd = "2";
    }else{
        header("location: register.php");
    }
}
if(isset($_POST["submitting"]))
    {
    if(empty($_POST["email"]) || empty($_POST["username"]) || empty($_POST["password"]))
        {
            $error = "All fields are required.";
        } else {
            // Define $username, $email and $password.
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];
            $newsp=$_POST['newsp'];

            if(isset($_POST['newsp'])) {
                $newsp = "1";
            }else{
                $newsp = "0";
            }
            // MySQL injection protection.
            $username = stripslashes($username);
            $password = stripslashes($password);
            $email = stripslashes($email);
            $username = mysqli_real_escape_string($mysqli, $username);
            $password = mysqli_real_escape_string($mysqli, $password);
            $email = mysqli_real_escape_string($mysqli, $email);

            $password = openssl_digest($password, 'sha512');

        // Create account.
            $sql = "INSERT INTO users(email, username, password, getnews)
            VALUES ('$email', '$username', '$password', $newsp)";

            // created?
            if (mysqli_query($mysqli, $sql)) {
                $getid = "SELECT * FROM users WHERE email='$email' and username='$username'";
                $makeid = mysqli_query($mysqli, $getid);
                $setid=mysqli_fetch_array($makeid,MYSQLI_ASSOC);
                $id = $setid['uid'];
                function generateRandomString($length = 50) { // function that creates a random string.
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                }
                $setcode = generateRandomString();
                $existvalue = "SELECT gcode FROM validation_redeem WHERE gcode='$setcode'"; //check if the key already exist
                $resultexistvalue = mysqli_query($mysqli, $existvalue);
                while (mysqli_num_rows($resultexistvalue) > 0) { //exist? keep making new keys until its a unique key.
                    $setcode = generateRandomString();
                    $resultexistvalue = mysqli_query($mysqli, $existvalue);
                }
                $insertcode = "INSERT INTO validation_redeem (uid, gcode)
                VALUES ('$id', '$setcode')";
                $resultcode = mysqli_query($mysqli, $insertcode);
                $to = $email;
                $subject = "CarTek account validator";
                $msg = '<html><body>';
                $msg .= "<p>Hello " . $username . ",<br>We have received your account request. Here is your account validation link: <a href='https://steffalon.com/bewijzenmap/bap/cartek/register.php?rcode=" . $setcode . "&id=" . $id ."'>https://steffalon.com/bewijzenmap/bap/cartek/register.php</a><br><br>
                Please activate your account before 2 weeks or your account will be removed.<br><br>- CarTek Team</p>";
                $msg .= '</html></body>';
                $headers = "From: " . "CarTek.validator@steffalon.com" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=utf-8\r\n";
                mail($to, $subject, $msg, $headers);
                $setupcmd = "1";
            } else {
                $error = "Email or username already in use!"; // Or database not reconized!
            }
            mysqli_close($mysqli);
        }
    }
?>

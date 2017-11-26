<?php
session_start();
require("connection.php"); //Establishing connection with database

$error = ""; //Variable for storing our errors.
$setupcmd = "0";

if(!empty($_GET['rcode']) && !empty($_GET['id'])) {
  $rcode = $_GET['rcode'];
  $userid = $_GET['id'];

  $validatecode = "SELECT uid FROM recovery WHERE gcode='$rcode'";
  $resultvalidatecode = mysqli_query($mysqli, $validatecode);
  $validateid = "SELECT * FROM users WHERE uid='$userid'";
  $resultvalidateid = mysqli_query($mysqli, $validateid);
  $rowid=mysqli_fetch_array($resultvalidateid,MYSQLI_ASSOC);
  $matchid = $rowid['uid'];
  $username = $rowid['username'];
  if(mysqli_num_rows($resultvalidatecode) > 0 && $matchid == $userid) {
    $setupcmd = "2";
    if (isset($_POST['setpassword'])) {
      if (!empty($_POST['changepassword']) && !empty($_POST['changepassword2'])) {
        $password = $_POST['changepassword'];
        $password2 = $_POST['changepassword2'];
        if ($password == $password2) {
          $password = stripslashes($password);
          $password = mysqli_real_escape_string($mysqli, $password);
          $password = openssl_digest($password, 'sha512');
          $rowpassword=mysqli_fetch_array($resultvalidatecode,MYSQLI_ASSOC);
          $selectp = $rowpassword['uid'];
          $makepassword = "UPDATE users SET password = '$password' WHERE uid = '$selectp'";
          $resultpassword = mysqli_query($mysqli, $makepassword);
          $deleterequest = "DELETE FROM recovery WHERE uid = '$selectp' limit 1";
          $resultdeleterequest = mysqli_query($mysqli, $deleterequest);
          $setupcmd = "3";
        } else {
          $error = "password doesn't match.";
        }
      } else {
          $error = "both fields are required!";
      }
    }
  } else {
      header("location: recovery.php");
  }
}
if(isset($_POST["submitting"]))
  {
    if(empty($_POST["username"]))
    {
      $error = "Please fill your username or email.";
    } else {
      // Define $username and $password.
      $username=$_POST['username'];

      // Check username/email from database and see if it exist.

      $sql = "SELECT * FROM users WHERE (username = '$username' or email = '$username')";
      $result=mysqli_query($mysqli,$sql);
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

      // If username exist in our database then send message.
      // Otherwise recovery request error created.

      if(mysqli_num_rows($result) > 0)
      {
        $ban = "SELECT permission FROM users WHERE (username = '$username' or email = '$username')";
        $resultban=mysqli_query($mysqli,$ban);
        $isbanned = $row['permission'];
        if ($isbanned == 'banned') {
          $error = "Recovery is not possible. This account is banned from the steffgram website!";
        } else {
          $uid = $row['uid'];
          $check = "SELECT gcode FROM recovery WHERE uid = '$uid'";
          $resultcheck = mysqli_query($mysqli, $check);
          if (mysqli_num_rows($resultcheck) > 0) { //if you already have a unused key, make a new one.
              $setdelete = "DELETE FROM recovery WHERE uid = '$uid' limit 1";
              $resultdelete = mysqli_query($mysqli,$setdelete);
          }
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

          $existvalue = "SELECT gcode FROM recovery WHERE gcode='$setcode'"; //check if the key already exist
          $resultexistvalue = mysqli_query($mysqli, $existvalue);
          while (mysqli_num_rows($resultexistvalue) > 0) { //exist? keep making new keys until its a unique key.
            $setcode = generateRandomString();
            $resultexistvalue = mysqli_query($mysqli, $existvalue);
            }
          $setrecovery = "INSERT INTO recovery (uid, gcode)
          VALUES ('$uid','$setcode')";
          $resultrecovery = mysqli_query($mysqli, $setrecovery);
          $to = $row['email'];
          $subject = "SteffGram password recovery";
          $msg = '<html><body>';
          $msg .= "<p>Hello " . $row['username'] . ",<br>We have received your password recovery request. Here is your password recovery request link: <a href='https://steffalon.com/bewijzenmap/bap/p1.3/bap%20project/recovery.php?rcode=" . $setcode . "&id=" . $row['uid'] ."'>https://steffalon.com/bewijzenmap/bap/p1.3/bap%20project/recovery.php</a><br><br>
          This recovery code will be invalid after around 24 hours if its not been used. We do this for safety reasons.<br><br>- SteffGram Team</p>";
          $msg .= '</html></body>';
          $headers = "From: " . "Recovery-SteffGram@steffalon.com" . "\r\n";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "Content-Type: text/html; charset=utf-8\r\n";
          mail($to, $subject, $msg, $headers)
            or $error = "Failed to send an email";
          if ($error == ""){
            $setupcmd = "1";
          }
        }
      } else {
        $error = "Incorrect username/email.";
      }
    }
  }
?>

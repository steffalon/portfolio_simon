<?php
session_start();
require("connection.php"); //Establishing connection with database

$error = ""; //Variable for storing our errors.
if(isset($_POST["submitting"]))
  {
    if(empty($_POST["username"]) || empty($_POST["password"]))
    {
      $error = "Both fields are required.";
    } else {
      // Define $username and $password.
      $username=$_POST['username'];
      $password=$_POST['password'];

      // MySQL injection protection.
      $username = stripslashes($username);
      $password = stripslashes($password);
      $username = mysqli_real_escape_string($mysqli, $username);
      $password = mysqli_real_escape_string($mysqli, $password);
      $password = openssl_digest($password, 'sha512');

      // Check username/email and password from database and see if it exist.

      $sql = "SELECT * FROM users WHERE (username = '$username' or email = '$username') and password='$password'";
      $result=mysqli_query($mysqli,$sql);
      $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

      // If username and password exist in our database then create a session.
      // Otherwise login error created.

      if(mysqli_num_rows($result) > 0)
      {
        $ban = "SELECT permission FROM users WHERE (username = '$username' or email = '$username')";
        $resultban=mysqli_query($mysqli,$ban);
        $isbanned = $row['permission'];
        if ($isbanned == 'banned') {
          $error = "This account is banned from SteffGram website!";
        } else {
          $_SESSION['username'] = $username; // Initializing Session.
          $user_check=$_SESSION['username'];
          header("location: profile.php");
        }
      } else {
        $error = "Incorrect username/email or password.";
      }
    }
    unset($_POST);
  }

?>

<?php
require('connection.php');
session_start();
$user_check=$_SESSION['username'];

$sql = "SELECT username FROM users WHERE username='$user_check' or email='$user_check' ";
$result=mysqli_query($mysqli,$sql);

$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

$login_user=$row['username'];

$bansql = "SELECT permission FROM users WHERE username ='$login_user'";
$resultbansql = mysqli_query($mysqli, $bansql);

$prow=mysqli_fetch_array($resultbansql,MYSQLI_ASSOC);
$permission = $prow['permission'];

if ($permission == 'banned') {
    header("Location: logout.php");
}
?>

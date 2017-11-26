<?php
require ("check.php");
require ("connection.php");
session_start();

$sql = "DELETE FROM users WHERE username = '$login_user' limit 1";
$result=mysqli_query($mysqli,$sql);
if(session_destroy())
{
  header("Location: ../login.php");
}
?>

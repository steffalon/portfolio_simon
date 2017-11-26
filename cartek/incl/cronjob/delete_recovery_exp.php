<?php
include("../connection.php"); //Establishing connection with database
$set_delete_exp =  "DELETE FROM recovery WHERE request_created < DATE_ADD(NOW(), INTERVAL -24 HOUR)";
$result_delete_exp = mysqli_query($mysqli, $set_delete_exp);
?>
<?php
include("../connection.php"); //Establishing connection with database
$set_delete_validate_time_exp =  "DELETE FROM users WHERE validate_time < DATE_ADD(NOW(), INTERVAL -14 DAY) AND validate_time != 0"; //0 means its already validated
$result_delete_exp = mysqli_query($mysqli, $set_delete_validate_time_exp);

$notify_week = "SELECT * FROM users WHERE validate_time < DATE_ADD(NOW(), INTERVAL -7 DAY) AND validate_time != 0";
$result_notify_week = mysqli_query($mysqli, $notify_week);
while($row = mysqli_fetch_array($result_notify_week)){
    $id = $row['uid'];
    $selectvalidatorlist = "SELECT * FROM validation_redeem WHERE uid = '$id'";
    $resultselectvalidator = mysqli_query($mysqli, $selectvalidatorlist);
    $rowselect = mysqli_fetch_array($resultselectvalidator,MYSQLI_ASSOC);
    $notifystatus = $rowselect['notified'];
    if ($notifystatus == 0){
        $username = $row['username'];
        $to = $row['email'];
        $setcode = $rowselect['gcode'];
        $subject = "CarTek account validator reminder";
        $msg = '<html><body>';
        $msg .= "<p>Hello " . $username . ",<br>We still haven't got a respond from your validation code. Here is your account validation link again: <a href='https://steffalon.com/bewijzenmap/bap/cartek/register.php?rcode=" . $setcode . "&id=" . $id ."'>https://steffalon.com/bewijzenmap/bap/cartek/register.php</a><br><br>
                Please activate your account before 1 week or your account it will be removed.<br><br>- CarTek Team</p>";
        $msg .= '</html></body>';
        $headers = "From: " . "CarTek.validator@steffalon.com" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        mail($to, $subject, $msg, $headers);
        $updatenotify = "UPDATE validation_redeem SET notified = '1' WHERE uid = '$id'";
        $resultupdatenotify = mysqli_query($mysqli, $updatenotify);
    }
}
?>
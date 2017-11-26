<?php
session_start();
require("connection.php"); //Establishing connection with database

$error = ""; //Variable for storing our errors.
if (isset($_POST["submitting"])) {
    if (empty($_POST["title"]) && empty($_POST["msg"]) && empty($_FILES['upload-file'])) {
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
                $error = "extension not allowed, please choose a JPEG, PNG, GIF file.";
            }

            if ($file_size > 2097152) {
                $error = 'File size must be excately 2 MB';
            }

            if (empty($error) == true) {
                $get_details = "SELECT * FROM users WHERE $user_login = username";
                $result = mysqli_query($mysqli, $get_details);
                $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

                $uid = $row['uid'];
                $username = $row['username'];
                $setcode = $setcode . '.' . $file_ext;
                move_uploaded_file($file_tmp, "userimage/" . $setcode);
                $sql = "INSERT INTO image_location (uid, username, title, description, dir)
                VALUES ('$uid', '$username', '$title', '$msg', '$setcode')";
                $complete = mysqli_query($mysqli, $sql);
                header('location: index.php');
            }
        }
    }
    unset($_POST);
}

?>

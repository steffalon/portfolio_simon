<?php
if ($_GET['logout'] == 1) {
    session_start();
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httpsonly"]
        );
    }

    session_destroy();
    header("Location: login.php");
}
?>

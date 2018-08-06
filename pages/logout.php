<?php
session_start();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
$_SESSION['id'] = null;
$_SESSION['login_user'] = null;
session_destroy();
header("Refresh:2; url=../index.php");

?>
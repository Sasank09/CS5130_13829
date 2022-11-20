<?php
require_once "../includes/utility.php";
session_start();
echo "<h3><b>Please wait while we process your request and redirect in 3 seconds...</b></h3>";
if(isset($_SESSION['user_mail']) && $_SESSION['user_mail'] != '') {
    header("refresh:2; url=".ALL_TODO_LIST_PHP_LOCATION);
}
elseif (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['passwd']) && $_POST['email'] && $_POST['passwd']) {
    $mail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $pass = htmlspecialchars($_POST['passwd']);
    if ($mail && $pass) {
        $sql = "SELECT email, fullname from users WHERE email = :mailId AND password = :password";
        $bindParams = array(
            "mailId" => $mail,
            "password" => hash("sha512", $pass)
        );
        if (executeQuery($sql, $bindParams, "ONE")) {
            header("refresh:3; url=".ALL_TODO_LIST_PHP_LOCATION);
            $_SESSION['login_status'] = 'success';
            $_SESSION['user_mail'] = $mail;
        } else {
            $_SESSION['login_status'] = 'error';
            header("refresh:3; url=".INDEX_LOGIN_PAGE_LOCATION);
        }
    }
    else {
        $_SESSION['login_status'] = 'error';
        header("refresh:3; url=".INDEX_LOGIN_PAGE_LOCATION);
    }
}
else {
    header("refresh:3; url=".INDEX_PAGE_LOCATION);
}

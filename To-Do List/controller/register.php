<?php
/**
 * Registers the users and if successful navigate to the application elsewhere back to index page
 */
require_once "../includes/utility.php";
session_start();
$msg = '<h3>Please wait while we process your registration in 3 seconds...</h3>';
if(isset($_SESSION['user_mail']) && $_SESSION['user_mail'] != '') {
    header("refresh:2; url=".ALL_TODO_LIST_PHP_LOCATION);
}
elseif (isset($_POST['register']) && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['fullname'])
    && $_POST['mail']  && $_POST['pass']  && $_POST['fullname']) {
    //Sanitize the inputs read from the registration form filled by user
    $fullname = htmlspecialchars($_POST['fullname']);
    $mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
    $pass = htmlspecialchars($_POST['pass']);
    if($fullname && $mail && $pass) {
        $sql = "SELECT fullname, email, password FROM users WHERE email = :mailId";
        $bindParams = array(
            "mailId" => $mail
        );

        if(!executeQuery($sql, $bindParams,"ONE")) {
            $insertQuery  = "INSERT INTO users (fullname, email, password) VALUES (:name, :mail, :pass)";
            $insertBindParams = array(
                "name" => $fullname,
                "mail" => $mail,
                "pass" => hash("sha512",$pass)
            );
            if(executeQuery($insertQuery,$insertBindParams,"NONE")) {
                $msg = "Registration is Successful, please wait while we log you into application in 3 seconds";
                header("refresh:3; url=".ALL_TODO_LIST_PHP_LOCATION);
            } else{ 
                $msg = "Regsitration is failed due to error, redirecting to home page in 3seconds. Please try again or contact your administrator";
                header("refresh:3; url=".INDEX_LOGIN_PAGE_LOCATION);
            }
        }
        else {
            $msg = "User already exists, Redirecting to login page in 3 seconds. Please login using with same email or use another mail to register";
            header("refresh:3; url=".INDEX_LOGIN_PAGE_LOCATION);
        }
    }
}
else {
    header("refresh:3; url=".INDEX_PAGE_LOCATION);
}

echo $msg;

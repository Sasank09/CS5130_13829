<?php

/**
 * Registers the users and if successful navigate to the application elsewhere back to index page
 */
require_once "../includes/utility.php";
session_start();
$msg = REGISTRATION_PAGE_MSG;
if (isset($_SESSION['user_mail']) && $_SESSION['user_mail'] != '') {
    header("refresh:2; url=" . ALL_TODO_LIST_PHP_LOCATION);
} elseif (isset($_POST['register']) && isset($_POST['mail']) && isset($_POST['pass']) && isset($_POST['fullname']) && $_POST['mail']  && $_POST['pass']  && $_POST['fullname']) {
    //Sanitize the inputs read from the registration form filled by user
    try {
        $fullname = htmlspecialchars($_POST['fullname']);
        $mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
        $pass = htmlspecialchars($_POST['pass']);
        if ($fullname && $mail && $pass) {
            $sql = "SELECT fullname, email, password FROM users WHERE email = :mailId";
            $bindParams = array(
                "mailId" => $mail
            );

            if (!executeQuery($sql, $bindParams, "ONE")) {
                $insertQuery  = "INSERT INTO users (fullname, email, password) VALUES (:name, :mail, :pass)";
                $insertBindParams = array(
                    "name" => $fullname,
                    "mail" => $mail,
                    "pass" => hash("sha512", $pass)
                );
                if (executeQuery($insertQuery, $insertBindParams, "NONE")) {
                    $_SESSION['user_mail'] = $mail;
                    $_SESSION['user_fullname'] = $fullname;
                    $_POST = array();
                    header("refresh:2; url=" . ALL_TODO_LIST_PHP_LOCATION);
                } else {
                    $msg = REGISTRATION_FAIL_REDIRECT_MSG;
                    header("refresh:2; url=" . INDEX_LOGIN_PAGE_LOCATION);
                }
            } else {
                $msg = EMAIL_ALREADY_EXISTS_MSG . REGISTRATION_FAIL_REDIRECT_MSG;
                header("refresh:2; url=" . INDEX_LOGIN_PAGE_LOCATION);
            }
        }
    } catch (Exception $e) {
        $msg = $msg + '\n Exception Thrown:' + $e->getCode();
    }
} else {
    header("refresh:0; url=" . INDEX_PAGE_LOCATION);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body>
    <?php getHeader();
    echo '<div class="fs-4 fw-bold text-white bg-info">' . $msg . '</dv>';
    getFooter();
    ?>
    <script>
        $(document).ready(function() {
            $("#cover-spin").show().delay(1990).fadeOut();
        });
    </script>
</body>

</html>
<?php
$_POST = array();
die();
?>

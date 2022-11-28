<?php
require_once "../includes/utility.php";
/**
 * @file login.php
 * Login conditions for the users, if successful navigate to the application elsewhere back to index page
 * requires utility.php to run database and common code for the application.
 */
session_start();
$msg =  LOGIN_PAGE_MSG;
if (isset($_SESSION['user_mail']) && isset($_SESSION['login_status']) && $_SESSION['user_mail'] != '' && $_SESSION['login_status']== 'SUCCESS') {
    header("refresh:2; url=" . ALL_TODO_LIST_PHP_LOCATION);
} elseif (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['passwd'])) {
    try {
        //sanitize the html inputs from user login form
        $mail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $pass = htmlentities($_POST['passwd']);
        if ($mail && $pass) {
            $sql = "SELECT email, fullname from users WHERE email = :mailId AND password = :password";
            $bindParams = array(
                "mailId" => $mail,
                "password" => hash("sha512", $pass)
            );
            $row = executeQuery($sql, $bindParams, "ONE");
            if ($row) {
                $_SESSION['login_status'] = 'SUCCESS';
                $_SESSION['user_mail'] = $mail;
                $_SESSION['user_fullname'] = $row['fullname'];
                //clearing post variable by reinstialising after successful login
                $_POST = array();
                header("refresh:2; url=" . ALL_TODO_LIST_PHP_LOCATION);
            } else {
                $_SESSION['login_status'] = 'FAIL';
                $msg = LOGIN_FAIL_REDIRECT_MSG;
                header("refresh:2; url=" . INDEX_LOGIN_PAGE_LOCATION);
            }
        } else {
            $msg = LOGIN_FAIL_REDIRECT_MSG;
            $_SESSION['login_status'] = 'FAIL';
            header("refresh:2; url=" . INDEX_LOGIN_PAGE_LOCATION);
        }
    } catch (Exception) {
        $msg = LOGIN_FAIL_REDIRECT_MSG . '\n Something went wrong, Exception Thrown: ' . $e->getMessage();
        header("refresh:2; url=" . INDEX_PAGE_LOCATION);
    }
} else {
    $msg = NEED_TO_LOGIN_MSG;
    header("refresh:0; url=" . INDEX_PAGE_LOCATION);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body>
    <?php getHeader(); ?>
    <div class="bg-warning m-auto w-75 p-3 fw-bold fs-4">
        <?php
        echo $msg;
        ?>
    </div>
    <?php
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
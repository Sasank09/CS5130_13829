<?php
require_once "../includes/utility.php";
session_start();
$msg =  LOGIN_PAGE_MSG;
if (isset($_SESSION['user_mail']) && $_SESSION['user_mail'] != '') {
    header("refresh:2; url=" . ALL_TODO_LIST_PHP_LOCATION);
} elseif (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['passwd']) && $_POST['email'] && $_POST['passwd']) {
    $mail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $pass = htmlspecialchars($_POST['passwd']);
    if ($mail && $pass) {
        $sql = "SELECT email, fullname from users WHERE email = :mailId AND password = :password";
        $bindParams = array(
            "mailId" => $mail,
            "password" => hash("sha512", $pass)
        );
        $row = executeQuery($sql, $bindParams, "ONE");
        if ($row) {
            $_SESSION['login_status'] = 'success';
            $_SESSION['user_mail'] = $mail;
            $_SESSION['user_fullname'] = $row['fullname'];
            $_POST = array();
            header("refresh:2; url=" . ALL_TODO_LIST_PHP_LOCATION);
        } else {
            $_SESSION['login_status'] = 'error';
            header("refresh:2; url=" . INDEX_LOGIN_PAGE_LOCATION);
        }
    } else {
        $_SESSION['login_status'] = 'error';
        header("refresh:2; url=" . INDEX_LOGIN_PAGE_LOCATION);
    }
} else {
    header("refresh:2; url=" . INDEX_PAGE_LOCATION);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body>
    <?php getHeader();
    echo '<div class="fs-4 fw-bold text-white bg-info">' . $msg . '</div>';
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
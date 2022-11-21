<?php
require_once "../includes/utility.php";
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();
$msg= LOGOUT_PAGE_MSG;
Header("Refresh:2;url=".INDEX_PAGE_LOCATION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php getHead(); ?>
    <script>
        $(document).ready(function () {
            $("#cover-spin").show().delay(1900).fadeOut();
        }); 
    </script>
</head>
<body>
    <div id="cover-spin"></div>
    <?php getHeader();
        echo '<div class="fs-4 text-white bg-info">'.$msg.'</div>';
    ?>
</body>
</html>
<?php
$_POST = array();
die();
?>
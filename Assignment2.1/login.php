<?php
require_once "pdo.php";
session_start();

if (isset($_POST['email_id']) && isset($_POST['password'])) {
    $sql = "SELECT names FROM logins WHERE email =:mail AND BINARY password =:pwd";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mail' => $_POST['email_id'],
        ':pwd' => $_POST['password']
    ));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === FALSE) {
        echo "<h1>Login Incorrect.</h1>\n";
    } else {
        $_SESSION['user_loggedIn'] = true;
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classroom Attendance Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <link rel="stylesheet" href="myApplicationStyle.css" />
</head>

<body>
    <p></p>
    <h1>Please Login to the Attendance System</h1>
    <form method="post">
        <div>
            <label for="email_id">Email:</label>
            <input type="email" id="email_id" name="email_id" size="40">
        </div><br>
        <div>
            <label for="pwd">Password:</label>
            <input type="password" id="password" name="password" size="40">
            <!--Referred passwordtoggle visibility@ https://www.csestack.org/hide-show-password-eye-icon-html-javascript/ -->
            <i class="far fa-eye" id="togglePassword"></i>
        </div><br>
        <input type="submit" value="Login" id="submit">
    </form>

    <script>
        "use strict";
        var $ = (id) => document.getElementById(id);

        onload = function() {
            //This is to toggle the password visibility
            $("togglePassword").addEventListener("click", function() {
                // toggle the type attribute
                const type = $("password").getAttribute("type") === "password" ? "text" : "password";
                $("password").setAttribute("type", type);

                // toggle the icon
                this.classList.toggle("fa-eye-slash");
            });
        }
    </script>
</body>

</html>
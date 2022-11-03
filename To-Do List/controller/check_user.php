<?php
require_once "../includes/pdo.php";

if (isset($_POST["email"]) && !empty($_POST["email"])) {
    $mail = $_POST["email"];
     $sql = "SELECT * FROM users WHERE email=:mail";
    $arry = array(
        'mail' => $mail,
    );
    $userAvailable = "<span class='w3-text-green w3-center' style='font-weight:bold'>Email: <i>".$mail."</i> is Available to Use</span>";
    $userNotAvailable = "<span style='color:red; font-weight:bold'>Email: <i>".$mail."</i> Already Exists With Us</span>";
    $invalid = "<span style='color:red; font-weight:bold'> Email: <i>".$mail."</i> is Invalid</span>";
    $filtered_mail_message = filter_var($mail, FILTER_VALIDATE_EMAIL) == FALSE ? $invalid : (checkUserMailAvailability($sql, $arry, "ONE") === FALSE ? $userAvailable : $userNotAvailable) ;
    echo $filtered_mail_message;

}

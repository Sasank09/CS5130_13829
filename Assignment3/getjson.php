<?php
require_once "pdo.php";

if (isset($_GET["username"]) && !empty($_GET["username"])) {
    $username = $_GET["username"];
    $sql = "SELECT email FROM account WHERE email= :uname";
    $bindparams = array(
        'uname' => $username,
    );

    $validMail = filter_var($username, FILTER_VALIDATE_EMAIL) == FALSE ? FALSE : TRUE;

    if ($validMail == TRUE) {
        $pdo = dbConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($bindparams);
        $row = $stmt->fetch();
        if ($row) {
            $result = array(
                "status" => "not available",
                "message" =>  "That username is taken. Try another",
            );
        } else {
            $result = array(
                "status" => "available",
                "message" => "You can use this username",
            );
        }
    }
    echo json_encode($result);
}

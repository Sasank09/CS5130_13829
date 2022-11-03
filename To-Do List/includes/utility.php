<?php
require_once "pdo.php";

const DB_HOST = 'localhost';
const DB_PORT = 3306;
const DB_NAME = 'todo_list';
const DB_USER = 'php';
const DB_PASSWORD = 'phpdb';
const USER_LOGIN_ERROR = "Invalid Username or Passwords";
const INDEX_PAGE_LOCATION = 'Location: http://localhost/To-Do%20List/';
const INDEX_LOGIN_PAGE_LOCATION = 'Location: http://localhost/To-Do%20List/index.php#loginForm';
const ALL_TODO_LIST_PHP_LOCATION = 'Location: http://localhost/To-Do%20List/controller/all_todos.php';
const REGISTRATION_PHP_LOCATION = 'Location: http://localhost/To-Do%20List/controller/register.php';
const LOGIN_PHP_LOCATION = 'Location: http://localhost/To-Do%20List/controller/login.php';


function executeQuery($sql, $binded_params, $fetchMode)
{
    $pdo = dbConnection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($binded_params);

    if ($fetchMode == "NONE") {
        return true;
    } elseif ($fetchMode == "ONE") {
        $row = $stmt->fetch();
        return $row;
    } elseif ($fetchMode == "ALL") {
        $rows = $stmt->fetchAll();
        return $rows;
    }
    else {
        return false;
    }
}

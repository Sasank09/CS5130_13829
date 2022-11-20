<?php

/**
 * Required pdo.php once so that we can access the database.
 * Utility file which contains the common functions and constants used for the application.
 */

require_once "pdo.php";

//All the constants defined here to be accessed across the files
const USER_LOGIN_ERROR = "Invalid Username or Passwords";
const EMAIL_NOTAVAILABLE = "Email already exists with us...";
const EMAIL_AVAILABLE = "Email is available to use.";
const EMAIL_INVALID = "Email is invalid, please use sample@domain.tld format.";
const INDEX_PAGE_LOCATION = 'http://localhost/To-Do%20List/';
const INDEX_LOGIN_PAGE_LOCATION = 'http://localhost/To-Do%20List/index.php#loginForm';
const ALL_TODO_LIST_PHP_LOCATION = 'http://localhost/To-Do%20List/controller/all_todos.php';
const REGISTRATION_PHP_LOCATION = 'http://localhost/To-Do%20List/controller/register.php';
const LOGIN_PHP_LOCATION = 'http://localhost/To-Do%20List/controller/login.php';

//Common method to execute the query
function executeQuery($sql, $binded_params, $fetchMode)
{
    $pdo = dbConnection();
    try {
        $stmt = $pdo->prepare($sql);
        if ($fetchMode == "NONE" && $stmt->execute($binded_params)) {
            return true;
        } elseif ($fetchMode == "ONE" && $stmt->execute($binded_params)) {
            $row = $stmt->fetch();
            return $row;
        } elseif ($fetchMode == "ALL" && $stmt->execute($binded_params)) {
            $rows = $stmt->fetchAll();
            return $rows;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo  $e->getMessage();
    }
}


function getCurrentUser() {
    $getCurrentUser = "SELECT user_id, fullname FROM users WHERE email = :mail";
    $param = array(
        "mail" => $_SESSION['user_mail']
    );
    $currentUser = executeQuery($getCurrentUser, $param, "ONE");
    return $currentUser;
}





/* ====================================================== */
/* Get Head function */
/* ====================================================== */

function getHead()
{
    $pageTitle = dynamicTitle();
    $output = '<!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>' . $pageTitle . '</title>
    <style>
    body {
        min-width: 300px;
        background: linear-gradient(to right, #f37099, #84d3ed);
    }

    /**http://www.menucool.com/9499/CSS-loading-spinner-with-a-semi-transparent-background*/
    #cover-spin {
        position: fixed;
        width: 100%;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.7);
        z-index: 9999;
        display: none;
    }

    @-webkit-keyframes spin {
        from {
            -webkit-transform: rotate(0deg);
        }

        to {
            -webkit-transform: rotate(360deg);
        }
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    #cover-spin::after {
        content: "";
        display: block;
        position: absolute;
        left: 48%;
        top: 40%;
        width: 40px;
        height: 40px;
        border-style: solid;
        border-color: black;
        border-top-color: transparent;
        border-width: 4px;
        border-radius: 50%;
        -webkit-animation: spin .8s linear infinite;
        animation: spin .8s linear infinite;
    }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    ';

    echo $output;
}


/* ====================================================== */
/* Get Header function */
/* ====================================================== */

function getHeader()
{
    $output = '<header class="py-3 mb-4 border-bottom bg-white">
        <div class="d-flex flex-wrap justify-content-center container">
            <a href="all_todos.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-4">Todo List</span>
            </a>
            <div class="nav nav-pills">
                <div class="nav-item"><a href="all_todos.php" class="nav-link btn btn-primary " aria-current="page">Home</a></div> &nbsp;&nbsp;
                <div class="nav-item"><a href="add_todo.php" class="btn btn-primary">Add Todo</a></div> &nbsp;
                <div class="nav-item"><a href="logout.php" class="btn btn-danger text-white">Logout</a></div>
            </div>
        </div>
    </header>';

    echo $output;
}


function getFooter() {
    $output = '        <!-- Footer -->
    <footer class="w3-bottom w3-center w3-black w3-padding-small" style="z-index: 1000;">
        <p>Developed by <a href="" class="w3-hover-text-green">Sasank Tipparaju & Jaya Chandu</a></p>
    </footer>
    ';
    echo $output;
}


/* ====================================================== */
/* Text Limit function */
/* ====================================================== */

function textLimit($string, $limit)
{
    if (strlen($string) > $limit) {
        return substr($string, 0, $limit) . "...";
    } else {
        return $string;
    }
}



/* ====================================================== */
/* Get Todo function */
/* ====================================================== */

function getTodo($todo)
{
    $output = '<div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">' . textLimit($todo['title'], 28) . '</h4>
            <p class="card-text">' . textLimit($todo['description'], 75) . '</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="view-todo.php?id=' . $todo['id'] . '" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="edit-todo.php?id=' . $todo['id'] . '" class="btn btn-sm btn-outline-secondary">Edit</a>
                </div>
                <small class="text-muted">' . $todo['date'] . '</small>
            </div>
        </div>
    </div>';

    echo $output;
}



/* ====================================================== */
/* Dynamic Title function */
/* ====================================================== */

function dynamicTitle()
{
    global $conn;
    $filename = basename($_SERVER["PHP_SELF"]);
    $pageTitle = "";
    switch ($filename) {
        case 'index.php':
            $pageTitle = "Home";
            break;

        case 'todos.php':
            $pageTitle = "Todo List";
            break;

        case 'add_todo.php':
            $pageTitle = "Add Todo List";
            break;

        case 'edit_todo.php':
            $pageTitle = "Edit Todo List";
            break;

        case 'view-todo.php':
            $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
            $sql1 = "SELECT * FROM todos WHERE id='{$todoId}'";
            $res1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($res1) > 0) {
                foreach ($res1 as $todo) {
                    $pageTitle = $todo["title"];
                }
            }
            break;

        default:
            $pageTitle = "Todo List";
            break;
    }

    return $pageTitle;
}

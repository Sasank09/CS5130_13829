<?php

/**
 * Required pdo.php once so that we can access the database.
 * Utility file which contains the common functions and constants used for the application.
 */

require_once "pdo.php";
session_start();
//All the constants defined here to be accessed across the files in application
const USER_LOGIN_ERROR_MSG = "Invalid Username or Password";
const EMAIL_ALREADY_EXISTS_MSG = "Email already exists with us...";
const EMAIL_AVAILABLE_TO_USE_MSG = "Email is available to use.";
const EMAIL_INVALID_MSG = "Email is invalid, please use sample@domain.tld format.";
const TODO_INSERT_SUCCESS_MSG = "Todo is created Successfully.";
const TODO_INSERT_FAIL_MSG = "Todo is not created, please review and try again.";
const TODO_UPDATE_SUCCESS_MSG = "Todo is Updated Successfully.";
const TODO_UPDATE_FAIL_MSG = "Todo is not updated, please review and try again.";
const REGISTRATION_PAGE_MSG = "Please wait while we process your registration in 3 seconds...";
const REGISTRATION_FAIL_REDIRECT_MSG = "Regsitration is failed, redirecting to home page in 3seconds. Please try again...";
const LOGIN_PAGE_MSG = "Please wait while we process your request and redirect in 3 seconds...";
const LOGOUT_PAGE_MSG = "Please wait while we log you out and redirect in 3 seconds";
//All locations stored as constants whilw we navigate through application
const INDEX_PAGE_LOCATION = 'http://localhost/To-Do%20List/';
const INDEX_LOGIN_PAGE_LOCATION = 'http://localhost/To-Do%20List/index.php#loginForm';
const ALL_TODO_LIST_PHP_LOCATION = 'http://localhost/To-Do%20List/controller/all_todos.php';
const VIEW_TODO_PHP_LOCATION = 'http://localhost/To-Do%20List/controller/view_todo.php';
const REGISTRATION_PHP_LOCATION = 'http://localhost/To-Do%20List/controller/register.php';
const LOGIN_PHP_LOCATION = 'http://localhost/To-Do%20List/controller/login.php';

//Common method to execute the query and communication with the database for CRUD operations
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
        echo  "<b>Something went wrong</b>, Please contact admin with the error message as...: " . $e->getMessage();
    }
}

//Method to fetch the current logged in user details
function getUserDetails($user_mail)
{
    $getCurrentUser = "SELECT user_id, fullname, email FROM users WHERE email = :mail";
    $param = array(
        "mail" => $user_mail
    );
    $currentUser = executeQuery($getCurrentUser, $param, "ONE");
    return $currentUser;
}






// Get Head function common head/meta tags/css/js inside todos application, once user logged in
function getHead()
{
    $pageTitle = dynamicTitle();
    $output = '<!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $pageTitle . '</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
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
    <!-- jQuery Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
        integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function convertFormToJSON(form) {
            return $(form)
                .serializeArray()
                .reduce(function(json, {
                    name,
                    value
                }) {
                    json[name] = value;
                    return json;
                }, {});
        }

        function sanitizeHTML(text) {
            return $("<div>").text(text).html();
        }
    </script>
    ';

    echo $output;
}


// Get Header function
function getHeader()
{
    $username = $_SESSION["user_fullname"];
    $output = '<header class="py-2 mb-3 border-bottom bg-white">
        <div class="d-flex flex-wrap justify-content-center container">
            <a href="all_todos.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <span class="fs-5">Todo List, Welcome ' . $username . '!! </span>
            </a>
            <div class="nav nav-pills">
                <div class="nav-item"><a href="all_todos.php" class="nav-link btn btn-primary " aria-current="page">Home</a></div> &nbsp;&nbsp;
                <div class="nav-item"><a href="add_todo.php" class="btn btn-primary" id="add_todo_nav" name="add_todo_nav">Add Todo</a></div> &nbsp;
                <div class="nav-item"><a href="logout.php" class="btn btn-danger text-white">Logout</a></div>
            </div>
        </div>
    </header>';

    echo $output;
}

//Get footer function
function getFooter()
{
    $output = '<!-- Footer -->
    <footer class="fixed-bottom bg-dark text-center text-white">
        <span>Developed by <a href="" class="text-info">Sasank Tipparaju & Jaya Chandu</a></span>
    </footer>
    ';
    echo $output;
}



// TextLimit function to truncate string on todos card with limit
function textLimit($string, $limit)
{
    if (strlen($string) > $limit) {
        return substr($string, 0, $limit) . "...";
    } else {
        return $string;
    }
}



//Get Todo function - to display each todo in form of card
function displayCard($todo)
{
    $output = '<div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">' . textLimit($todo['title'], 28) . '</h4>
            <p class="card-text">' . textLimit($todo['description'], 75) . '</p>
            <small class="text-muted">Complete By: ' . $todo['due_date'] . '</small>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="view_todo.php?id=' . $todo['todo_id'] . '" class="btn btn-sm btn-outline-secondary">View</a>
                    <a href="edit_todo.php?id=' . $todo['todo_id'] . '" class="btn btn-sm btn-outline-secondary">Edit</a>
                </div>
                <small class=" fw-bold mb-1 bg-light text-warning">' . $todo['priority'] . '</small>
                <small class=" fw-bold mb-1 bg-light text-info">' . $todo['category'] . '</small>
            </div>
        </div>
    </div>';

    echo $output;
}



// Dynamic Title function for each webpage
function dynamicTitle()
{
    global $conn;
    $filename = basename($_SERVER["PHP_SELF"]);
    $pageTitle = "";
    switch ($filename) {
        case 'index.php':
            $pageTitle = "Home";
            break;

        case 'all_todos.php':
            $pageTitle = "Todo Dashboard";
            break;

        case 'add_todo.php':
            $pageTitle = "Add Todo List";
            break;

        case 'edit_todo.php':
            $pageTitle = "Edit Todo List";
            break;

        case 'view_todo.php':
            $pageTitle = "View";
            break;

        default:
            $pageTitle = "Todo List";
            break;
    }

    return $pageTitle;
}

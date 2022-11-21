<?php 
require_once "../includes/utility.php";

if (isset($_POST['addTodo']) && $_POST['addTodo']='Add Todo' && isset($_POST['title']) && $_POST['title']) {
    $response = array();
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $priority = $_POST['priority'] == '' ? 'Medium' :  htmlspecialchars($_POST['priority']);
    $status = $_POST['status'] == '' ? 'Not Started' :  htmlspecialchars($_POST['status']);
    $category = $_POST['category'] == '' ? 'Personal' :  htmlspecialchars($_POST['category']);
    $due = htmlspecialchars($_POST['dueDate']);
    $dueDate = date("Y-m-d H:i:s", strtotime($due));
    $currentUserData = getUserDetails($_SESSION['user_mail']);
    if ($currentUserData['user_id'] != '') {
        $insertQuery  = "INSERT INTO todos (title, description, priority, status, category, due_date, user_id) VALUES (:title, :desc, :prior, :stat, :cat, :due, :uid)";
        $insertBindParams = array(
            "title" => $title,
            "desc" => $description,
            "prior" => $priority,
            "stat" => $status,
            "cat" => $category,
            "due" => $dueDate,
            "uid" => $currentUserData['user_id']
        );
        $res = executeQuery($insertQuery, $insertBindParams, "NONE");

        if ($res) {
            $response = array(
                "status" => "Success",
                "message" => TODO_INSERT_SUCCESS_MSG
            );
        } else {
            $response = array(
                "status" => "Fail",
                "message" => TODO_INSERT_FAIL_MSG
            );
        }
    } else {
        $response = array(
            "status" => "alert alert-fail",
            "message" => TODO_INSERT_FAIL_MSG
        );
    }
    echo json_encode($response);
}


elseif (isset($_POST['updateTodo']) && $_POST['updateTodo']='Update Todo' && isset($_POST['todoId']) && isset($_POST['title'])) {
    $response = array();
    $id = htmlspecialchars($_POST['todoId']);
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $priority = $_POST['priority'] == '' ? 'Medium' :  htmlspecialchars($_POST['priority']);
    $status = $_POST['status'] == '' ? 'Not Started' :  htmlspecialchars($_POST['status']);
    $category = $_POST['category'] == '' ? 'Personal' :  htmlspecialchars($_POST['category']);
    $due = htmlspecialchars($_POST['dueDate']);
    $dueDate = date("Y-m-d H:i:s", strtotime($due));
    $currentUserData = getUserDetails($_SESSION['user_mail']);
    if ($currentUserData['user_id'] != '') {
        $updateQuery  = "UPDATE todos SET title=:title, description=:desc, priority=:prior, status=:stat, category=:cat, due_date=:due  WHERE todo_id =:id AND user_id =:uid";
        $updateParams = array(
            "title" => $title,
            "desc" => $description,
            "prior" => $priority,
            "stat" => $status,
            "cat" => $category,
            "due" => $dueDate,
            "id" => $id,
            "uid" => $currentUserData['user_id']
        );
        $res = executeQuery($updateQuery, $updateParams, "NONE");

        if ($res) {
            $response = array(
                "status" => "Success",
                "message" => TODO_UPDATE_SUCCESS_MSG
            );
        } else {
            $response = array(
                "status" => "Fail",
                "message" => TODO_UPDATE_FAIL_MSG
            );
        }
    } else {
        $response = array(
            "status" => "alert alert-fail",
            "message" => TODO_UPDATE_FAIL_MSG
        );
    }
    echo json_encode($response);
}
$_POST = array();
die();

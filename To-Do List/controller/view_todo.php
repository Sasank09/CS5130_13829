<?php
require_once "../includes/utility.php";
session_start();
if (!isset($_SESSION['user_mail']) && $_SESSION['user_mail'] == '') {
    header("refresh:0;url=" . INDEX_PAGE_LOCATION);
} else {
    $todoId =  htmlspecialchars($_GET["id"]);
    $userDetails = getUserDetails($_SESSION['user_mail']);

    $sql = "SELECT * FROM todos WHERE todo_id= :id AND user_id= :uid";
    $param = array(
        "id" => $todoId,
        "uid" => $userDetails['user_id'],
    );
    $result = executeQuery($sql, $param, "ONE");
}
?>
<!doctype html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body>
    <?php getHeader(); ?>
    <div id="viewContainer" class="container m-6">
        <div id="cover-spin"></div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card bg-light rounded border shadow">
                    <div class="card-header bg-info ">
                        <h4 class="card-title">View Todo</h4>
                    </div>
                    <div class="card-body p-4">
                        <div id="insert_status"></div>
                        <form action="add_todo.php" method="POST" id="add_todo_form">
                            <?php echo $msg ?>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Create PPT for Web Applications Project" value="<?php echo $result['Title'] ?>" maxlenght="75" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3 row input-group">
                                <div class="col-6">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select name="priority" id="priority" class="form-control">
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="category" class="form-label">Category</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category" id="personal" value="Personal" checked>
                                        <label class="form-check-label" for="personal">Personal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category" id="work" value="Work">
                                        <label class="form-check-label" for="work">Work</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 row input-group">
                                <div class="col-6">
                                    <label for="dueDate" class="form-label">Due Date</label>
                                    <input type="datetime-local" name="dueDate" id="dueDate" class="form-control" required>
                                </div>
                                <div class="col-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="category" class="form-control">
                                        <option value="Not Started">Not Started</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div id="viewFooter" class="bg-light mt-4 clearfix">
                                <input type="submit" id="addTodo" name="addTodo" class="btn btn-primary" value="Add Todo">
                                <input type="reset" class="btn btn-danger" value="Reset">
                                <button id="cancel" name="cancel" class="btn float-end btn-danger">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="mb-5">
        <a href="<?php echo 'edit_todo.php?id=' . $result['id']; ?>" class="btn btn-primary btn-lg px-4 me-2">Edit</a>
        <a href="<?php echo 'delete_todo.php?id=' . $result['id']; ?>" class="btn btn-danger btn-lg px-4">Delete</a>
    </div> -->

    <script>
        $(document).ready(function() {
            $("#cover-spin").show().delay(500).fadeOut();
        });
    </script>
</body>

</html>
<?php
$_POST = array();
die();
?>
<?php
include "../includes/utility.php";
session_start();
if (isset($_SESSION['user_mail']) && $_SESSION['user_mail'] == '') {
    header("refresh:0;url=" . INDEX_PAGE_LOCATION);
} else {
    $msg = "";
    if (isset($_POST['addTodo']) && isset($_POST['title']) && $_POST['title']) {
        $title = htmlspecialchars($_POST['title']);
        $description = htmlspecialchars($_POST['description']);
        $priority =$_POST['priority'] == ''? 'Medium':  htmlspecialchars($_POST['priority']);
        $due = htmlspecialchars($_POST['dueDate']);
        $dueDate = date('Y-m-d h:i:s', strtotime($due));
        $currentUserData = getCurrentUser();
        echo $dueDate;
        if ($currentUserData['user_id'] != '') {
            $insertQuery  = "INSERT INTO todos (title, description, priority, due_date, user_id) VALUES (:title, :desc, :prior, :due, :uid)";
            $insertBindParams = array(
                "title" => $title,
                "desc" => $description,
                "prior" => $priority,
                "due" => $dueDate,
                "uid" => $currentUserData['user_id']
            );
            $res = executeQuery($insertQuery, $insertBindParams, "NONE");

            if ($res) {
                $msg = "<div class='alert alert-success'>Todo is created Successfully.</div>";
                $_POST["title"] = "";
                $_POST["desc"] = "";
            } else {
                $msg = "<div class='alert alert-danger'>Todo is not created.</div>";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body>
    <?php getHeader(); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card bg-light rounded border shadow">
                    <div class="card-header bg-info px-4 py-3">
                        <h4 class="card-title">Add Todo</h4>
                    </div>
                    <div class="card-body p-4">
                        <span class="result"></span>
                        <form action="" method="POST" id="add_todo">
                        <?php echo $msg ?>
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Create PPT for Web Applications Project" value="" maxlenght="100" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dueDate" class="form-label">Due Date</label>
                                <input type="datetime-local" name="dueDate" id="dueDate" class="form-control" required>
                            </div>
                            <div class="bg-white clearfix">
                                <input type="submit" id="addTodo" name="addTodo" class="btn btn-primary" value="Add Todo">
                                <input type="reset" class="btn btn-danger" value="Reset">
                                <a href="all_todos.php" id="cancel" name="cancel" class="btn float-end btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php getFooter(); ?>
    <script type="text/javascript">
        function toggleSpinner(timeout) {
            $("#cover-spin").show();
            setTimeout(() => {
                $("#cover-spin").hide();
            }, timeout);
        }
    </script>
</body>

</html>
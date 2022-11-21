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
                        <h4 class="card-title">Edit Todo</h4>
                    </div>
                    <div class="card-body p-4">
                        <div id="update_status"></div>
                        <form action="crud_todos.php" method="POST" id="edit_todo_form">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" 
                                    value="<?php echo $result['title'] ?>" maxlenght="75" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"><?php echo $result['description'] ?></textarea>
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
                                    <input type="datetime-local" name="dueDate" id="dueDate" class="form-control" value="<?php echo $result['due_date'] ?>" required>
                                </div>
                                <div class="col-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="Not Started">Not Started</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div id="viewFooter" class="bg-light mt-4 clearfix">
                                <input type="submit" id="updateTodo" name="updateTodo" class="btn btn-primary" value="Update Todo">
                                <a href="delete_todo.php?id=<?php echo $result['todo_id']; ?>" class="btn btn-danger">Delete</a>
                                <a href="all_todos.php" id="cancel" name="cancel" class="btn float-end btn-danger">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php getFooter(); ?>
    <script>
        $(document).ready(function() {
            $("#cover-spin").show().delay(500).fadeOut();
            $('#status').val("<?php echo $result['status']; ?>");
            $('#priority').val("<?php echo $result['priority'] ?>");
            $('input:radio[name="category"]').filter('[value="<?php echo $result['category']; ?>"]').attr('checked', true);

            $("#updateTodo").click(function(event) {
                event.preventDefault();
                $("#cover-spin").show();
                const form = $("#edit_todo_form");
                const json = convertFormToJSON(form);
                console.log(json);
                json["updateTodo"] = "Update Todo";
                json["todoId"] = "<?php echo $result['todo_id'] ?>";
                $.post("crud_todos.php", json, function(response) {
                    data = JSON.parse(response);
                    if (data.status == "Success") {
                        $("#update_status").html(
                            "<div class='alert alert-success'>" + sanitizeHTML(data.message) + "</div>"
                        ).delay(1000).fadeOut();
                        window.location.replace("http://localhost/To-Do%20List/controller/view_todo.php?id="+json["todoId"]);
                    } else {
                        $("#update_status").html(
                            "<div class='alert alert-danger'>" + sanitizeHTML(data.message) + "</div>"
                        ).delay(1000).fadeOut();
                    }
                    $("#cover-spin").delay(800).fadeOut();
                    $("#edit_todo_form")[0].reset();
                }).fail(function() {
                    alert("error");
                });
            });
    
        });
    </script>
</body>
</html>

<?php
$_POST = array();
die();
?>
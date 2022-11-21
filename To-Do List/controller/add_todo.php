<?php
include "../includes/utility.php";
session_start();
if (!isset($_SESSION['user_mail']) && $_SESSION['user_mail'] == '') {
    header("refresh:0;url=" . INDEX_PAGE_LOCATION);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body>
    <div id="cover-spin"></div>
    <?php getHeader(); ?>
    <div id="addContainer" class="container m-6">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card bg-light rounded border shadow">
                    <div class="card-header bg-info input-group">
                        <h4 class="card-title">Add Todo</h4> &emsp; 
                        <span id="insert_status"></span>
                    </div>
                    <div class="card-body p-4">
                        <form action="add_todo.php" method="POST" id="add_todo_form">
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Create PPT for Web Applications Project" value="" maxlenght="75" required>
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
                                    <select name="status" id="status" class="form-control">
                                        <option value="Not Started">Not Started</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="bg-light mt-4 clearfix">
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
    <script>
        $(document).ready(function() {
            $("#cover-spin").show().delay(500).fadeOut();
            $("#add_todo_form").on("submit", function(event) {
                event.preventDefault();
                $("#cover-spin").show();
                const form = $(event.target);
                const json = convertFormToJSON(form);
                console.log(json);
                json["addTodo"] = "Add Todo";
                $.post("crud_todos.php", json, function(response) {
                    data = JSON.parse(response);
                    console.log("HELLO", data)
                    if (data.status == "Success") {
                        $("#insert_status").html(
                            "<div class='alert alert-success'>" + sanitizeHTML(data.message) + "</div>"
                        ).delay(1000).fadeOut();
                    } else {
                        $("#insert_status").html(
                            "<div class='alert alert-danger'>" + sanitizeHTML(data.message) + "</div>"
                        );
                    }
                    $("#cover-spin").delay(800).fadeOut();
                    $("#add_todo_form")[0].reset();
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
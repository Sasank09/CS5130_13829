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
                            <?php
                            $todo  = array();
                            getFormContent($todo);
                            ?>
                            <hr>
                            <div class="bg-light mt-4 clearfix">
                                <input type="submit" id="addTodo" name="addTodo" class="btn btn-primary" value="Add Todo">
                                <input type="reset" class="btn btn-danger" value="Reset">
                                <a href="all_todos.php" id="cancel" name="cancel" class="btn float-end btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php getFooter(); ?>
    <script type="text/javascript">
        "use strict";
        $(document).ready(function() {
            $("#cover-spin").show().delay(500).fadeOut();
            $("#add_todo_form").on("submit", function(event) {
                event.preventDefault();
                $("#cover-spin").show();
                const form = $(event.target);
                const json = convertFormToJSON(form);
                json["addTodo"] = "Add Todo";
                $.post("crud_todos.php", json, function(response) {
                    var data = JSON.parse(response);
                    if (data.status == "Success") {
                        $("#insert_status").html(
                            "<div class='alert alert-success'>" + sanitizeHTML(data.message) + "</div>"
                        ).delay(800).fadeOut();
                        $("#add_todo_form")[0].reset();
                        setTimeout(function() {
                            window.location.replace("all_todos.php");
                        }, 500);
                    } else {
                        $("#insert_status").html(
                            "<div class='alert alert-danger'>" + sanitizeHTML(data.message) + "</div>"
                        );
                    }
                    $("#cover-spin").delay(800).fadeOut();

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
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
    <div id="formContainer" class="container m-6">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card bg-light rounded border shadow">
                    <div class="card-header bg-info ">
                        <h4 class="card-title">Edit Todo</h4>
                    </div>
                    <div class="card-body p-4">
                        <div id="update_status"></div>
                        <form action="crud_todos.php" method="POST" id="edit_todo_form">
                            <?php getFormContent($result); ?>
                            <hr>
                            <div id="viewFooter" class="bg-light mt-4 clearfix">
                                <input type="submit" id="updateTodo" name="updateTodo" class="btn btn-primary" value="Update Todo">
                                 <?php getFormButtons($result["todo_id"]) ?>
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
                    var data = JSON.parse(response);
                    if (data.status == "Success") {
                        $("#update_status").html(
                            "<div class='alert alert-success'>" + sanitizeHTML(data.message) + "</div>"
                        ).delay(1000).fadeOut();
                        window.location.replace("http://localhost/To-Do%20List/controller/view_todo.php?id=" + json["todoId"]);
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
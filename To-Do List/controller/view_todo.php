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
        <div class="card bg-light rounded border shadow">
            <div class="card-header bg-warning text-center">
                <h4 class="card-title text-light">View Todo</h4>
            </div>
            <div class="m-2 row">
                <div class="col-2">
                    <label for="title" class="fs-5 text-seoncdary fw-bold">Title </label>
                </div>
                <div class="col-10">
                    <output name="title" class="fs-6"><?php echo $result['title']; ?></output>
                </div>
            </div>
            <div class="m-2 row bg-white">
                <div class="col-2">
                    <label for="description" class="fs-5 text-seoncdary fw-bold">Description</label>
                </div>
                <div class="col-10">
                    <output name="description" class="fs-6"><?php echo $result['description']; ?></output>
                </div>
            </div>
            <div class="m-2 row">
                <div class="col-2">
                    <label for="priority" class="fs-5 text-seoncdary fw-bold">Priority </label>
                </div>
                <div class="col-10">
                    <output name="priority" class="fs-6"><?php echo $result['priority']; ?></output>
                </div>
            </div>
            <div class="m-2 row bg-white">
                <div class="col-2">
                    <label for="duedate" class="fs-5 text-seoncdary fw-bold">Complete By</label>
                </div>
                <div class="col-10">
                    <output name="duedate" class="fs-6"><?php echo $result['due_date']; ?></output>
                </div>
            </div>
            <div class="m-2 row">
                <div class="col-2">
                    <label for="category" class="fs-5 text-seoncdary fw-bold">Category</label>
                </div>
                <div class="col-10">
                    <output name="category" class="fs-6"><?php echo $result['category']; ?></output>
                </div>
            </div>
            <div class="m-2 row bg-white">
                <div class="col-2">
                    <label for="status" class="fs-5 text-seoncdary fw-bold">Status</label>
                </div>
                <div class="col-10">
                    <output name="status" class="fs-6"><?php echo $result['status']; ?></output>
                </div>
            </div>
            <div class="m-2 row bg-white">
                <div class="col-2">
                    <label for="createdon" class="fs-5 text-seoncdary fw-bold">Created Date</label>
                </div>
                <div class="col-10">
                    <output name="createdon" class="fs-6"><?php echo $result['created_date']; ?></output>
                </div>
            </div>
            <div class="m-2 row bg-white">
                <div class="col-2">
                    <label for="createdon" class="fs-5 text-seoncdary fw-bold">Modified Date</label>
                </div>
                <div class="col-10">
                    <output name="createdon" class="fs-6"><?php echo $result['modified_date']; ?></output>
                </div>
            </div>
            <div class="card-body p-4">
                <hr>
                <div id="viewFooter" class="bg-light mt-3 clearfix">
                    <a href="<?php echo 'edit_todo.php?id=' . $result['todo_id']; ?>" class="btn btn-primary  px-4 me-2">Edit</a>
                    <?php getFormButtons($result['todo_id']);?>
                </div>
            </div>
        </div>
    </div>
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
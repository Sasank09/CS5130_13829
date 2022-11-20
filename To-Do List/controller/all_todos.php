<?php
require_once "../includes/utility.php";
session_start();
if (!isset($_SESSION['user_mail']) && $_SESSION['user_mail'] == '') {
    header("refresh:0;url=" . INDEX_PAGE_LOCATION);
} else {
    $currentUserData = getCurrentUser();
    if ($currentUserData['user_id'] != '') {
        $sql = "SELECT title, description FROM todos WHERE user_id =:uid";
        $param = array(
            "uid" => $currentUserData['user_id'],
        );
        $rows = executeQuery($sql, $param, "ALL");
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <?php getHead(); ?>
</head>

<body>
    <?php getHeader(); ?>
    <div id="cover-spin"></div>
    <div id="viewAllContainer" class="container">
        <h1 class="mb-4 text-center fw-bold">Your Todos</h1>
        <div class="row">
            <?php
            foreach ($rows as $todo) {
            ?>
                <div class="col-lg-3 col-md-6 mb-4">
                    <?php getTodo($todo); ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php getFooter(); ?>
</body>

</html>
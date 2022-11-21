<?php
require_once "../includes/utility.php";
session_start();
if (!isset($_SESSION['user_mail']) && $_SESSION['user_mail'] == '') {
    header("refresh:0;url=" . INDEX_PAGE_LOCATION);
} else {
    $currentUserData = getUserDetails($_SESSION['user_mail']);
    $currDate = date("Y-m-d H:i:s", time());
    if ($currentUserData['user_id'] != '') {
        $sql = "SELECT * FROM todos WHERE user_id =:uid AND due_date >:currdate ORDER BY due_date, priority ASC";
        $param = array(
            "uid" => $currentUserData['user_id'],
            "currdate" => $currDate
        );
        $upComing = executeQuery($sql, $param, "ALL");

        $sql2 = "SELECT * FROM todos WHERE user_id =:uid AND due_date <=:currdate ORDER BY  due_date, priority ASC";

        $today = executeQuery($sql2, $param, "ALL");
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
        <div class="row">
            <?php
            echo "<p class='text-center'><a href='' class='text-danger fw-bold fs-4'>Today's Todos</a></p>";
            foreach ($today as $todo) {
            ?>
                <div class="col-lg-3 col-md-6 mb-5">
                    <?php displayCard($todo); ?> 
                </div>
            <?php
            } 
            echo "<p class='text-center'><a href='' class='text-success fw-bold fs-4'>Upcoming Todos</a></p>";
            foreach ($upComing as $todo) {
            ?>
                <div class="col-lg-3 col-md-6 mb-5">
                    <?php displayCard($todo); ?> 
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <?php getFooter(); ?>
    <script type="text/javascript">
        "use strict;"

        function sanitizeHTML(text) {
            return $('<div>').text(text).html();
        }

        $(document).ready(function() {
            $("#cover-spin").show().delay(500).fadeOut();
        });
    </script>
</body>

</html>
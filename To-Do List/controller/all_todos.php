<?php
require_once "../includes/utility.php";

session_start();
if (!isset($_SESSION['user_mail']) && $_SESSION['user_mail'] == '') {
    header("refresh:0;url=" . INDEX_PAGE_LOCATION);
} else {
    $currentUserData = getUserDetails($_SESSION['user_mail']);
    $currentDate = date("Y-m-d", time());
    $currentTime = date("H:i:s", time());

    if ($currentUserData['user_id'] != '') {
        $sql = "SELECT * FROM todos WHERE user_id =:uid ORDER BY due_date, priority ASC";
        $param = array(
            "uid" => $currentUserData['user_id'],
        );
        $all_todos = executeQuery($sql, $param, "ALL");
        foreach ($all_todos as $todo) {
            $str = strtotime($todo['due_date']);
            $todo_date =  date("Y-m-d", $str);
            $todo_time = date("H:i:s", $str);
            if ($todo_date == $currentDate && $todo_time > $currentTime && $todo['status'] != 'Completed') {
                $today_tasks_count += 1;
                $today_tasks .= '<div class="col-lg-3 col-md-6 mb-5">' . displayCard($todo) . '</div>';
            } elseif ((($todo_date == $currentDate && $todo_time < $currentTime) || $todo_date < $currentDate) && $todo['status'] != 'Completed') {
                $warning_tasks_count += 1;
                $warning_tasks .= '<div class="col-lg-3 col-md-6 mb-5">' . displayCard($todo) . '</div>';
            } elseif ($todo_date > $currentDate && $todo['status'] != 'Completed') {
                $upcoming_tasks_count += 1;
                $upcoming_tasks .= '<div class="col-lg-3 col-md-6 mb-5">' . displayCard($todo) . '</div>';
            } elseif ($todo['status'] == 'Completed') {
                $completed_tasks_count += 1;
                $completed_tasks .= '<div class="col-lg-3 col-md-6 mb-5">' . displayCard($todo) . '</div>';
            }
        }
        $today_tasks = $today_tasks_count <= 0 ? "<div class='text-info fw-bold text-center'>" . NO_TODOS_AVAILABLE . "</div>" : $today_tasks;
        $warning_tasks = $warning_tasks_count <= 0 ? "<div class='text-info fw-bold text-center'>" . NO_TODOS_AVAILABLE . "</div>" : $warning_tasks;
        $upcoming_tasks = $upcoming_tasks_count <= 0 ? "<div class='text-info  fw-boldtext-center'>" . NO_TODOS_AVAILABLE . "</div>" : $upcoming_tasks;
        $completed_tasks = $completed_tasks_count <= 0 ? "<div class='text-info fw-bold text-center'>" . NO_TODOS_COMPLETED . "</div>" : $completed_tasks;
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
    <div id="viewAllContainer" class="container">
        <div id="status_change"></div>
        <p class='text-center'><a href='' class='text-dark fw-bold fs-4'>Your Todos Dashboard</a></p>
        <div class="accordion" id="todosList">
            <div class="accordion-item">
                <h2 class="accordion-header" id="warning_todos">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <p class="text-danger fw-bold fs-6"><span class="badge text-bg-secondary"><?php echo $warning_tasks_count; ?></span>&nbsp;Warning, Due Tasks</p>
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="warning_todos" data-bs-parent="#todosList">
                    <div class="accordion-body">
                        <div class="row">
                            <?php echo $warning_tasks; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="today_todos">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <p class="text-warning fw-bold fs-6"><span class="badge text-bg-secondary"><?php echo $today_tasks_count; ?></span>&nbsp;Today's Tasks</p>
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="today_todos" data-bs-parent="#todosList">
                    <div class="accordion-body">
                        <div class="row">
                            <?php echo $today_tasks; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="upcoming_todos">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <p class="text-primary fw-bold fs-6"><span class="badge text-bg-secondary"><?php echo $upcoming_tasks_count; ?></span>&nbsp;Upcoming Tasks</p>
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="upcoming_todos" data-bs-parent="#todosList">
                    <div class="accordion-body">
                        <div class="row">
                            <?php echo $upcoming_tasks; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="completed_todos">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                        <p class="text-success fw-bold fs-6"><span class="badge text-bg-secondary"><?php echo $completed_tasks_count; ?></span>&nbsp;Completed Tasks</p>
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="completed_todos" data-bs-parent="#todosList">
                    <div class="accordion-body">
                        <div class="row">
                            <?php echo $completed_tasks; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php getFooter(); ?>
    <script type="text/javascript">
        "use strict";

        function updateStatus(id) {
            var todoId = id;
            console.log("todoId: " + todoId);
            $("#cover-spin").show();
            var json = {
                "id": todoId,
                "markComplete": "Clicked"
            }
            console.log(json)
            $.post("crud_todos.php", json, function(response) {
                var data = JSON.parse(response);
                console.log(data);
                if (data.status == "Success") {
                    $("#status_change").html(
                        "<div class='alert alert-success'>" + sanitizeHTML(data.message) + "</div>"
                    ).show().delay(500).fadeOut();
                } else {
                    $("#status_change").html(
                        "<div class='alert alert-danger'>" + sanitizeHTML(data.message) + "</div>"
                    );
                }
                $("#cover-spin").delay(500).fadeOut();
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            }).fail(function() {
                alert("error");
            });
        }
        $(document).ready(function() {
            $("#cover-spin").show().delay(500).fadeOut();
        });
    </script>
</body>

</html>
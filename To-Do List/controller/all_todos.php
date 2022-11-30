<?php
require_once "../includes/utility.php";
/**
 * Location: To-Do List/Controller/all_todos.php
 * @file all_todos.php
 * Display the all todos based on current logged in user_id and todo_id
 * Able to edit the record and view if neeeded. Can mark the completed_tasks. Can we view the recent activities
 * requires utility.php to run database and common code for the application.
 */
session_start();
if (isset($_SESSION['user_mail']) && !empty($_SESSION['user_mail']) && isset($_SESSION['login_status']) && $_SESSION['login_status']  === 'SUCCESS') {
    $currentUserData = getUserDetails(htmlentities($_SESSION['user_mail']));
    $currentDate = date("Y-m-d", time());
    $currentTime = date("H:i:s", time());
    if ($currentUserData['user_id'] != '') {
        $sql = "SELECT * FROM todos WHERE user_id =:uid ORDER BY due_date, priority ASC";
        $param = array(
            "uid" => $currentUserData['user_id'],
        );
        $all_todos = executeQuery($sql, $param, "ALL");
        $pageTitle = dynamicTitle();
        setcookie('LastVisitedPage', $pageTitle, time() + 86400, "/");
    }
} else {
    header("refresh:1;url=" . INDEX_PAGE_LOCATION);
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
        <?php
        if ($_SESSION['login_status'] === 'SUCCESS') {
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
        ?>
            <div class="accordion" id="todosList">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="warning_todos">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <p class="text-danger fw-bold fs-6"><span class="badge text-bg-secondary"><?php echo htmlentities($warning_tasks_count); ?></span>&nbsp;Warning, Due Tasks</p>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="warning_todos" data-bs-parent="#todosList">
                        <div class="accordion-body">
                            <div class="row">
                                <?php
                                $warning_tasks = $warning_tasks_count <= 0 ? "<div class='text-info fw-bold text-center'>" . NO_TODOS_AVAILABLE . "</div>" : $warning_tasks;
                                echo $warning_tasks;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="today_todos">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <p class="text-warning fw-bold fs-6"><span class="badge text-bg-secondary"><?php echo htmlentities($today_tasks_count); ?></span>&nbsp;Today's Tasks</p>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="today_todos" data-bs-parent="#todosList">
                        <div class="accordion-body">
                            <div class="row">
                                <?php
                                $today_tasks = $today_tasks_count <= 0 ? "<div class='text-info fw-bold text-center'>" . NO_TODOS_AVAILABLE . "</div>" : $today_tasks;
                                echo $today_tasks;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="upcoming_todos">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <p class="text-primary fw-bold fs-6"><span class="badge text-bg-secondary"><?php echo htmlentities($upcoming_tasks_count); ?></span>&nbsp;Upcoming Tasks</p>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="upcoming_todos" data-bs-parent="#todosList">
                        <div class="accordion-body">
                            <div class="row">
                                <?php
                                $upcoming_tasks = $upcoming_tasks_count <= 0 ? "<div class='text-info fw-bold text-center'>" . NO_TODOS_AVAILABLE . "</div>" : $upcoming_tasks;
                                echo $upcoming_tasks;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="completed_todos">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                            <p class="text-success fw-bold fs-6"><span class="badge text-bg-secondary"><?php echo htmlentities($completed_tasks_count); ?></span>&nbsp;Completed Tasks</p>
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="completed_todos" data-bs-parent="#todosList">
                        <div class="accordion-body">
                            <div class="row">
                                <?php
                                $completed_tasks = $completed_tasks_count <= 0 ? "<div class='text-info fw-bold text-center'>" . NO_TODOS_COMPLETED . "</div>" : $completed_tasks;
                                echo $completed_tasks;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table caption-top m-auto w-75 p-4 mb-5 table-hover table-light table-striped">
                <caption class="text-danger fs-3 fw-bold">Most Recent Activity in last 24 hours - (Based on Cookies)</caption>
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Last Visited Page</th>
                        <td><?php echo htmlentities($_COOKIE['LastVisitedPage']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Last Created Todo</th>
                        <td><?php echo htmlentities($_COOKIE['RecentlyCreatedTodo']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Last Viewed Todo</th>
                        <td><?php echo htmlentities($_COOKIE['RecentlyViewedPage']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Last Updated Todo</th>
                        <td><?php echo htmlentities($_COOKIE['RecentlyUpdatedTodo']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Last Deleted Todo</th>
                        <td><?php echo htmlentities($_COOKIE['RecentlyDeletedTodo']) ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Last Completed Todo</th>
                        <td><?php echo htmlentities($_COOKIE['RecentlyCompletedTodo']) ?></td>
                    </tr>

                </tbody>
            </table>
        <?php
        } else { ?>
            <div class="bg-danger m-auto w-75 text-center p-3 fw-bold fs-4">
                <?php echo htmlentities(NEED_TO_LOGIN_MSG); ?>
            </div>
        <?php } ?>
    </div>


    <?php getFooter(); ?>
    <script type="text/javascript">
        "use strict";
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        function updateStatus(id) {
            var todoId = sanitizeHTML(id);
            $("#cover-spin").show();
            var json = {
                "id": todoId,
                "markComplete": "Clicked"
            };
            $.post("crud_todos.php", json, function(response) {
                var data = JSON.parse(response);
                if (data.status == "Success") {
                    $("#status_change").html(
                        "<div class='alert alert-success'>" + sanitizeHTML(data.message) + "</div>"
                    ).show().delay(1000).fadeOut();
                } else {
                    $("#status_change").html(
                        "<div class='alert alert-danger'>" + sanitizeHTML(data.message) + "</div>"
                    );
                }
                $("#cover-spin").delay(500).fadeOut();
                setTimeout(function() {
                    window.location.reload();
                }, 900);
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
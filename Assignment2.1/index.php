<?php
require_once "pdo.php";
session_start();

if ($_SESSION['user_loggedIn'] != true) {
    header("Location: login.php");
}
else {
    $sql = "SELECT name, present FROM students WHERE 1";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1" />
    <title>Classroom Attendacne App</title>
    <link rel="stylesheet" href="myApplicationStyle.css" />
</head>

<body>
    <main class="classroomApplication">
        <div class="classroomApplicationBoard">
            <h1 id="heading"><b>Classroom Attendance App</b></h1>
            <div id="screensContainer">
                <div id="whiteboard">
                    <img src="images/whiteboard.jpg" alt="Whiteboard" height="130em" width="225em" />
                </div>
                <div id="tvScreen">
                    <!--Images sliding/rotating is done through JavaScript-->
                    <img id="imagesLoop" src="images/tvSet/img1.png" alt="ParticipantImagesSet" height="175em" width="400em" />
                </div>
                <div id="whiteboard">
                    <img src="images/whiteboard.jpg" alt="Whiteboard" height="130em" width="225em" />
                </div>
            </div>

            <div class="studentCoontainer">
                <div class="left_grid_container" id="left_grid">
                    <!--Inner Elements with Student Name are inserted through JavaScript-->
                </div>
                <div></div>
                <div class="right_grid_container" id="right_grid">
                    <!--Inner Elements with Student Name are inserted through JavaScript-->
                </div>
            </div>
            <div>
                <p class="result" id="absent_count"></p>
            </div>
        </div>

    </main>
    <script type="text/javascript">
        const student_records = <?php echo json_encode($row); ?>;
    </script>
    <script src="classroomAttendance.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment3</title>
    <link rel="stylesheet" href="assets/mystyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="main">
        <form id="register-form" name="register-form" action="">
            <div class="head">
                <img src="assets/googlelogo.png" alt="Google" class="logo">
                <h3>Create your Google Account</h3>
            </div>
            <div class="name">
                <input type="text" id="fname" name="fname" required>
                <label>First name</label>
            </div>
            <div class="name">
                <input type="text" id="lname" name="lname" required>
                <label>Last name</label>
            </div>
            <div class="user-name">
                <input type="text" id="username" name="username" required>
                <label id='uname_label'>Username</label>
                <span class="gmail">@gmail.com</span>
            </div>
            <a class="line1" id="user-availability-status">You can use letters, numbers & periods</a>
        </form>
    </div>

    <script type="text/javascript">
        function htmlentities(str) {
            return $('<div/>').text(str).html();
        }

        $(document).ready(function() {
            $('#username').focusout(function(event) {

                if ($('#username').val() != '') {
                    var jsonData = {
                        "username": $('#username').val() + '@gmail.com',
                    };
                    $.getJSON("getjson.php", jsonData, function(data) {
                        $('#user-availability-status').html(htmlentities(data.message));
                        if (htmlentities(data.status) == 'not available') {
                            $('#user-availability-status').css('color', 'red');
                            $('#username').css('border-color', 'red');
                            $('#uname_label').css('color', 'red');
                        } else {
                            $('#user-availability-status').css('color', 'blue');
                            $('#username').css('border-color', 'blue');
                            $('#uname_label').css('color', 'blue');
                        }
                    });
                } 
                else {
                    $('#user-availability-status').html("You can use letters, numbers & periods");
                    $('#user-availability-status').css('color', '#555');
                    $('#username').css('border-color', '#9c9c9c');
                    $('#uname_label').css('color', '#555');
                }

            });
        });
    </script>
</body>

</html>
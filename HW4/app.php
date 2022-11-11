<?php
    //Q2 uncommnet next two lines for 1st question
    // session_set_cookie_params(120);
    session_start();
    $value = isset($_COOKIE['visits']) ? $_COOKIE['visits']+1 :  0;
    setcookie("visits", $value, time()+120)
    //Q3 uncommnet next lines for 3rd question
    // if(isset($_COOKIE['visits']) ) {
    //     $count= $_COOKIE['visits'] + 1;
    //     setcookie("visits", $count, time()+120);
    // }
    // else {
    //     $count= $_COOKIE['visits'];
    //     setcookie("visits", $count, time()+120);
    // }

?>
<html>
<head>
</head>
<body style="font-family: sans-serif;">
<h1>Cool Application</h1>
<?php 
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
        unset($_SESSION["success"]);
    }  
 
    // Check if we are logged in!
    if ( ! isset($_SESSION["account"]) ) { ?>
       <p>Please <a href="login.php">Log In</a> to start.</p>
    <?php } else { ?>
       <p>This is where a cool application would be.</p>
       <p>Please <a href="logout.php">Log Out</a> when you are done.</p>
    <?php }
    echo "<p>Access Count: ".$_COOKIE['visits']."</p>";
    ?>

   
</body>
</html>
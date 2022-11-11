<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
   <title>Members Only</title>
</head>
<body>
<h1>Members Only</h1>

<?php

// Fill in this section
if(isset($_SESSION['valid_user']) && $_SESSION['valid_user'] != '' && isset($_SESSION['login_status']) && $_SESSION['login_status'] = "SUCCESS") {
  echo "<p>You are logged in as: ".$_SESSION['valid_user']."</p>";
  echo "<p><i>Members-only content goes here</i></p>";
}
else{
    echo "<p>You are not logged in.</p>";
    echo "<p>Only logged in members may see this page</p>";
  }

?>

<p><a href="authmain.php">Back to Home Page</a></p>

</body>
</html>


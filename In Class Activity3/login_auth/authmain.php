<?php
session_start();

if (isset($_POST['userid']) && isset($_POST['password']))
{
  $id = 'testuser';
  $pswd = 'password';

  $userid = $_POST['userid'];
  $password = $_POST['password'];

  if($userid == $id && $password == $pswd)
  {
     $_SESSION['valid_user'] = $userid;
     $_SESSION['login_status'] = "SUCCESS";
  }
  else {
      $_SESSION['login_status'] = "FAIL";
  }

}
?>
<!DOCTYPE html>
<html>
<head>
   <title>Home Page</title>
   <link href="style.css" rel="stylesheet">
</head>
<body>
<h1>Home Page</h1>


<?php // Fill in the php section
    if(isset($_SESSION['valid_user']) && $_SESSION['valid_user'] != '' && isset($_SESSION['login_status']) && $_SESSION['login_status'] = "SUCCESS") {
      echo "<p>You are logged in as: ".$_SESSION['valid_user']."</p>";
      echo "<span><a href='logout.php'>Log out</a></span>";
    }
    else {
      if(isset($_SESSION['login_status']) && $_SESSION['login_status'] = "FAIL") {
         echo "<p>Could not log you in.</p>";
      }
      else {
         echo "<p>You are not logged in.</p>";
      }
      echo '<form action="authmain.php" method="post">';
      echo '<fieldset>';
      echo '<legend>Login Now!</legend>';
      echo '<p><label for="userid">UserID:</label>';
      echo '<input type="text" name="userid" id="userid" size="30"/></p>';
      echo '<p><label for="password">Password:</label>';
      echo '<input type="password" name="password" id="password" size="30"/></p>';    
      echo '</fieldset>';
      echo '<button type="submit" name="login">Login</button>';
      echo '</form>';
    }

?>
<p><a href="members_only.php">Go to Members Section</a></p>

</body>
</html>
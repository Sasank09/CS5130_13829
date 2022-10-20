<?php 
$page_title = 'Welcome to the In-Class Exercise Task!';
include('includes/header.html');
require_once('pdo.php');
?>

<div class="page-header"><h1>Welcome to the Task!</h1></div>
<p>Take time and solve the task!</p>
<p>CS5130.</p><br>

<form action="index.php" method="post">
	<p><input type="hidden" name="check" value="0"></p>
	<p><input type="submit" name="submit" value="Connection Test"></p>
</form>

<?php
if (isset($_POST['check'])&&$pdo) echo "Connection Success!";
	else echo "$msg";
include('includes/footer.html');
?>
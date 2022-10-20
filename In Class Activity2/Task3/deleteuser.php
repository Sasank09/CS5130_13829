<?php
$page_title = 'Delete User';
include('includes/header.html');

require_once('pdo.php');

// echo '<h1>Success!</h1>
// <p>The user was deleted successfully!</p><p><br></p>';
// echo '<h1>Error!</h1>
// <p class="error">The email address and password do not match those on file.</p>';
if (isset($_POST['email']) && isset($_POST['pass'])) {
	$sql = "SELECT user_id,email,pass FROM users WHERE email =:mail AND pass=:pwd";
	$hash_pwd = hash("sha512",$_POST['pass']);
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(
		':mail' => $_POST['email'],
		':pwd' => $hash_pwd
	));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($row === FALSE) {
		echo "<h1>Error!</h1>";
		echo "<p>The email address and password do not match those on file.</p>";
	} else {
		$sql = "DELETE FROM users WHERE email=:mail AND pass=:pwd ";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(
			':mail' => $_POST['email'],
			':pwd' => $hash_pwd
		));

		echo "<h1>Success!</h1>";
		echo "<p>The user was deleted Successfully.</p>";
	}
}



?>

<h1>Delete User</h1>
<form action="deleteuser.php" method="post">
	<p>Email Address: <input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"> </p>
	<p>Current Password: <input type="password" name="pass" size="10" maxlength="20" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>"></p>
	<p><input type="submit" name="submit" value="Delete User"></p>
</form>
<?php include('includes/footer.html'); ?>
<?php
session_start();

//If already logged in, redirect to homepage
if (isset($_SESSION['user_id'])) {
    header("Location: ./homepage.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h1>Chitter Chatter</h1>
		<h2>Sign Up</h2><hr>
		<form action="../app/verifySignup.php" method="post">
			Username: <input type="text" name="username" id="username"><br>
			Password: <input type="password" name="password" id="password"><br>
			<input type="submit" value="Submit">
			<p>Already have an account? Login <a href = "./login.php">here</a></p>
		</form>
	</body>
</html>
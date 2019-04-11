<?php
session_start();

//If already logged in, redirect to homepage
if (isset($_SESSION['user_id'])) {
    header("Location: ./index.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h1>Chitter Chatter</h1>
		<h2>Login</h2><hr>
		<form action="../app/verifyLogin.php" method="post">
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br>
			<input type="submit" value="Submit">
			<p>Don't have an account? Sign up <a href = "./signup.php">here</a></p>
		</form>
	</body>
</html>
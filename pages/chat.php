<?php
session_start();

//If not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<a style="text-decoration:none; color:black" href="./index.php"><h1>Chitter Chatter</h1></a>
		<h2>CHAT WITH _________</h2>
		<form action="../app/logout.php" method="post">
			<input type="submit" value="Logout">
		</form><hr><hr>
		<h3>Jane Doe</h3><hr>
		<h3>John Doe</h3><hr>
	</body>
</html>
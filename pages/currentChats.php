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
		<h2><?php echo $_SESSION['user_id']?>'s Chats</h2>
		<form action="../app/logout.php" method="post">
			<input type="submit" value="Logout">
		</form><hr>
		<ul>
			<li><a href="chat.php">Jane Doe</li>
			<li><a href="chat.php">John Doe</li>
		</ul>
	</body>
</html>
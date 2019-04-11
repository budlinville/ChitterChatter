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
		<h2><?php echo $_SESSION['user_id']?>'s Homepage</h2>
		<form action="./server/logout_script.php" method="post">
			<input type="submit" value="Logout">
		</form><hr>
		<ul>
			<li><a href="currentChats.php">Chats</a></li>
			<li><a href="friends.php">Friends</li>	
		</ul>
	</body>
</html>
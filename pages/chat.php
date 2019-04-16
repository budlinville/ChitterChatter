<?php
session_start();

//If not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
	exit();
//If chat has not been initiated, redirect to homepage
} else if (!isset($_SESSION['chat_id'])) {
	header("Location: ./homepage.php");
	exit();
//If user to chat with has not been selected, redirect to homepage
} else if (!isset($_SESSION['chatter_id'])) {
	header("Location: ./homepage.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<a style="text-decoration:none; color:black" href="./homepage.php"><h1>Chitter Chatter</h1></a>
		<h2><?php echo $_SESSION['user_id']?>'s chat with <?php echo $_SESSION['chatter_id']?></h2>
		<form action="../app/logout.php" method="post">
			<input type="submit" value="Logout">
		</form><hr style="border-top:1px solid black">
		<h3>Jane Doe</h3><hr>
		<h3>John Doe</h3><hr>
	</body>
</html>
<?php
session_start();

if ( !empty( $_POST ) ) {
	if ( isset( $_POST['friend'] )) {
		$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
		
		//check connection
		if ($mysqli->connect_errno) {
			echo "Could not connect to databse.
				<br/>
				<a href='../pages/login.php'>Return</a>";
		}
		
		//fetch friend to chat with from post
		$friend = filter_var($_POST["friend"], FILTER_SANITIZE_STRING);
		$user = $_SESSION['user_id'];
		
		//concatenate string alphanumerically and hash to get unique hash id
		$chatId = (strnatcmp($user,$chatter) < 0) ? sha1($user.$friend) : sha1($friend.$user);
		
		//check if friend's username exists within database
		$query = $mysqli->query("SELECT * FROM User WHERE Username='$friend'");
		if (mysqli_num_rows($query)) {
			//check if chat has already been started with this user.
			$query = $mysqli->query("SELECT * FROM Chat WHERE Chat_id='$chatId'");
			if (!mysqli_num_rows($query)) {
				$query = "INSERT INTO Chat(Chat_id,Newest_Message_id)"."VALUES('$chatId', NULL)";
			}
			$_SESSION['chatter_id'] = $friend;
			$_SESSION['chat_id'] = $chatId;
		}
	
		$mysqli->close();
	}
}

?>
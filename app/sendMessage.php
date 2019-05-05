<?php
session_start();

if ( !empty( $_POST ) ) {
	if ( isset( $_POST['newMsg'] ) ) {
		$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
		
		//check connection
		if ($mysqli->connect_errno) {
			echo "Could not connect to databse.
				<br/>
				<a href='../pages/login.php'>Return</a>";
		}
		
		//fetch message from chat.php, 
		$message = filter_var($_POST["newMsg"], FILTER_SANITIZE_STRING);
		
		$user = $_SESSION['user_id'];
		$friend = $_SESSION['friend_id'];
		
		//obtain chat_id using user and friend session variables
		$chatId = (strnatcmp($user,$friend) < 0) ? sha1($user.$friend) : sha1($friend.$user);
		
		//check if chat is in our database; if not, need to create chat as well
		$query = $mysqli->query("SELECT * FROM Chat WHERE Chat_id='$chatId'");
		if (!mysqli_num_rows($query)) {
			// TODO: This is already implemented in prepareChat.php : Keeping code in here anyways
			//$mysqli->query("INSERT INTO Message(Sender,Contents) VALUES('$user','$message')");
			//get the auto-incremented message id value
			//$msgId = $mysqli->insert_id;
			//$mysqli->query("INSERT INTO Chat(Chat_id,Newest_Message_id) VALUES('$chatId','$msgId')");
			echo "UH OH";
		} else {
			//TODO: NEED TO FIX THIS
			$parentId = mysqli_fetch_object($mysqli->query("Select Newest_Message_id From Chat WHERE Chat_id='$chatId'"));
			$parentId = $parentId->Newest_Message_id;
			
			$mysqli->query("INSERT INTO Message(Parent_id,Sender,Contents) VALUES('$parentId','$user','$message')");
			
			//get the auto-incremented message id value
			$msgId = $mysqli->insert_id;

			//update Newest_Message_id to new message id
			$mysqli->query("UPDATE Chat SET Newest_Message_id='$msgId' WHERE Chat_id='$chatId'");
		}
		
		echo "Message sent.
			<br/>
			<a href='../pages/chat.php'>Return</a>";
				
		$mysqli->close();
	}
}
?>
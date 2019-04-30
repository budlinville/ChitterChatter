<?php
session_start();

$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
	
//check connection
if (!$mysqli->connect_errno) {
	$user = $_SESSION['user_id'];
	$friend = $_SESSION['friend_id'];
	
	//obtain chat_id using user and friend session variables
	$chatId = (strnatcmp($user,$friend) < 0) ? sha1($user.$friend) : sha1($friend.$user);
	
	$newestMsgId = mysqli_fetch_object($mysqli->query("Select Newest_Message_id From Chat WHERE Chat_id='$chatId'"));
	$newestMsgId = $newestMsgId->Newest_Message_id;

	while($row = mysqli_fetch_assoc($friends_obj)) {
		$friends_arr[] = $row;
	}

	$friends_json = json_encode($friends_arr);

	header('Content-type: application/json');
	echo $friends_json;
}

?>
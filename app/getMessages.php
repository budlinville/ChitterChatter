<?php
session_start();

$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
	
//check connection
if (!$mysqli->connect_errno) {
	$user = $_SESSION['user_id'];
	$friend = $_SESSION['friend_id'];
	
	//obtain chat_id using user and friend session variables
	$chatId = (strnatcmp($user,$friend) < 0) ? sha1($user.$friend) : sha1($friend.$user);
	
	$query = $mysqli->query("Select Newest_Message_id From Chat WHERE Chat_id='$chatId'");

	if (!mysqli_num_rows($query)) {
		return false;
	} else {
		$newestMsgId = mysqli_fetch_object($query)->Newest_Message_id;
		$retArr = array();
		
		$iter = $newestMsgId;
		while (1) {
			$message = $mysqli->query("SELECT Message_id,Parent_id,Sender,Contents FROM Message WHERE Message_id='$iter'");
			$message_obj = mysqli_fetch_object($message);
			
			$retObj = clone $message_obj;
			unset($retObj->Message_id);
			unset($retObj->Parent_id);
			if ($user == $retObj->Sender) {
				$retObj = (object) array_merge( (array)$retObj, array( 'user' => 'yes' ) );
			} else {
				$retObj = (object) array_merge( (array)$retObj, array( 'user' => 'no' ) );
			}
			
			//$retArr[] = json_encode($retObj);
			$retArr[] = $retObj;
			
			//iterate using parent id to go up chain of messages
			if (is_null($message_obj->Parent_id)) {
				break;
			} else {
				$iter = $message_obj->Parent_id;
			}
		}
	}


	header('Content-type: application/json');
	echo json_encode($retArr);
}

?>
<?php
session_start();

if ( !empty( $_POST ) ) {
	if ( isset( $_POST['friend'] ) ) {
		$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
		
		//check connection
		if ($mysqli->connect_errno) {
			echo "Could not connect to databse.
				<br/>
				<a href='../login.php'>Return</a>";
		}
		
		//fetch user-submitted username and password from login.php
		$friend = filter_var($_POST["friend"], FILTER_SANITIZE_STRING);
		
		//check if friend's username exists
		$query = $mysqli->query("SELECT * FROM User WHERE Username='$friend'");
		if (!mysqli_num_rows($query)) {
			echo "No user with that name.
				<br/>
				<a href='../friends.php'>Return</a>";
		} else {
			$user = $_SESSION['user_id'];
			
			//concatenate string alphanumerically and hash to get unique hash id
			$hashChatVal = (strnatcmp($user,$friend) < 0) ? sha1($user.$friend) : sha1($friend.$user);
			
			//check if user is already friends with $friend
			$query = $mysqli->query("SELECT * FROM Friends WHERE Username='$user' AND Friend_username='$friend'");
			if (mysqli_num_rows($query)) {
				echo "You are already friends with this person.
					<br/>
					<a href='../friends.php'>Return</a>";
			} else {
				$query = "INSERT INTO Friends(Username,Friend_username,Hashed_chat_value)"."VALUES('$user','$friend','$hashChatVal')";
				
				if (!($mysqli->query($query))) {
					echo "Error: " . $query . "<br>" . $mysqli->error;
					echo "<br/><a href='../friends.php'>Return</a>";
				} else {
					echo "Friend successfully added.
					<br/>
					<a href='../friends.php'>Return</a>";
				}
			}
		}
		
		$mysqli->close();
	}
}
?>
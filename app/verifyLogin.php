<?php
session_start();

if ( !empty( $_POST ) ) {
	if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
		$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
		
		//check connection
		if ($mysqli->connect_errno) {
			echo "Could not connect to databse.
				<br/>
				<a href='../pages/login.php'>Return</a>";
		}
		
		//fetch user-submitted username and password from login.php
		$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
		$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
		
		//check if username exists within database
		$query = $mysqli->query("SELECT * FROM User WHERE Username='$username'");
		if (!mysqli_num_rows($query)) {
			echo "No user with that name.
				<br/>
				<a href='../pages/login.php'>Return</a>";
		} else {
			//check if password is valid
			if (!password_verify($password, $query->fetch_assoc()["Password"])){
				echo "Incorrect password.
					<br/>
					<a href='../pages/login.php'>Return</a>";
			} else {
				//Set session variable 'user_id' to username to signify logged in state
				$_SESSION['user_id'] = $username;
				header("Location: ../pages/homepage.php");
			}
		}
		
		$mysqli->close();
	}
}
?>
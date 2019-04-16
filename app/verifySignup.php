<?php
session_start();

if ( !empty( $_POST ) ) {
	if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
		$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
		
		//check connection
		if ($mysqli->connect_errno) {
			echo "Could not connect to database.
				<br/>
				<a href='../pages/signup.php'>Return</a>";
		}
		
		//fetch user-submitted username and password from signup.php
		$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
		$password = password_hash(filter_var($_POST["password"], FILTER_SANITIZE_STRING), PASSWORD_BCRYPT);
		
		//check if there is already user with that username
		if (mysqli_num_rows($mysqli->query("SELECT * FROM User WHERE Username='$username'"))) {
			echo "Username is already taken.
				<br/>
				<a href='../pages/signup.php'>Return</a>";
		} else {
			$query = "INSERT INTO User(Username, Password)"."VALUES('$username', '$password')";
			
			if (!($mysqli->query($query))) {
				echo "Error: " . $query . "<br>" . $mysqli->error;
				echo "<br/><a href='../pages/signup.php'>Return</a>";
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
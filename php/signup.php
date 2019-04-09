<?php
	if ( !empty( $_POST ) ) {
		if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
			$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
			
			if ($mysqli->connect_errno) {
				echo "Could not connect to database.
					<br/>
					<a href='../signup.html'>Return</a>";
			}
			
			$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
			$password = password_hash(filter_var($_POST["password"], FILTER_SANITIZE_STRING), PASSWORD_BCRYPT);
		
			if (mysqli_num_rows($mysqli->query("SELECT * FROM User WHERE Username='$username'"))) {
				echo "Username is already taken.
					<br/>
					<a href='../signup.html'>Return</a>";
			} else {
				$query = "INSERT INTO User(Username, Password)"."VALUES('$username', '$password')";
			
				if (!($mysqli->query($query))) {
					echo "Error: " . $query . "<br>" . $mysqli->error;
					echo "<br/><a href='../signup.html'>Return</a>";
				} else {
					header("Location: ../homepage.html");
				}
			}
			
			$mysqli->close();
		}
	}
?>
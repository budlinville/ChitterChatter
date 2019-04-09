<?php
	if ( !empty( $_POST ) ) {
		if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
			$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
			
			if ($mysqli->connect_errno) {
				echo "Could not connect to databse.
					<br/>
					<a href='../login.html'>Return</a>";
			}
			
			$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
			$password = password_hash(filter_var($_POST["password"], FILTER_SANITIZE_STRING), PASSWORD_BCRYPT);
			
			$query = $mysqli->query("SELECT * FROM User WHERE Username='$username'");
			if (!mysqli_num_rows($query)) {
				echo "No user with that name.
					<br/>
					<a href='../login.html'>Return</a>";
			} else {
				if ($query->fetch_assoc()["Password"] != $password) {
					echo "Incorrect password.
					<br/>
					<a href='../login.html'>Return</a>";
				} else {
					header("Location: ../homepage.html");
				}
			}
			
			$mysqli->close();
		}
	}
?>
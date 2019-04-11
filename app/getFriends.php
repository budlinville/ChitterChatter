<?php
session_start();

$mysqli = new mysqli("mysql.eecs.ku.edu", "laubrey", "fahYee3e", "laubrey");
	
//check connection
if ($mysqli->connect_errno) {
	echo "Could not connect to databse.
		<br/>
		<a href='../pages/login.php'>Return</a>";
}

$user = $_SESSION['user_id'];

$query = "SELECT Friend_username FROM Friends WHERE Username='$user'";
$friends_obj = $mysqli->query($query);
$friends_arr = array();

while($row = mysqli_fetch_assoc($friends_obj)) {
	$friends_arr[] = $row;
}

$friends_json = json_encode($friends_arr);

header('Content-type: application/json');
echo $friends_json;
?>
<?php
session_start();

//If not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
	exit();
}
?>

<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script>
			$("document").ready(function(){
				$.ajax({
					url : '../app/getFriends.php',
					method : 'GET',
					dataType: 'json',
					success: function(data) {
						if (data.length > 0) {
							var list = $("<ul></ul>");
						
							for (var i = 0; i < data.length; i++) {
								var friend = data[i];
								var listItem = $("<li></li>");
								var listItemLink = $("<button></button>");
								
								listItemLink.text(friend.Friend_username);
								listItemLink.appendTo(listItem);
								listItem.appendTo(list);
							}
							list.appendTo($("body"));
						} else {
							$("<h4>You have no friends. You are a loser.</h4>").appendTo($("body"));
						}
					},
					error: function(xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText;
						alert('Error - ' + errorMessage + error);
					}
				});
				
				$('body').on('click', 'button', function () {
					$.ajax({
						url : '../app/prepareChat.php',
						method : 'POST',
						data: { friend:$(this).text() },
						success: function() {
							window.location.href = "./chat.php";
						}
					});
				});
			});
		</script>
	</head>
	<body>
		<a style="text-decoration:none; color:black" href="./homepage.php"><h1>Chitter Chatter</h1></a>
		<h2><?php echo $_SESSION['user_id']?>'s Homepage</h2>
		
		<form action="../app/logout.php" method="post">
			<input type="submit" value="Logout">
		</form><hr>
		
		<form action="../app/addFriend.php" method="post">
			<input type="text" name="friend"><br>
			<input type="submit" value="Add Friend">
		</form>
	</body>
</html>
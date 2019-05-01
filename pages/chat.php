<?php
session_start();

//If not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.php");
	exit();
//If user to chat with has not been selected, redirect to homepage
} else if (!isset($_SESSION['friend_id'])) {
	header("Location: ./homepage.php");
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
					url : '../app/getMessages.php',
					method : 'GET',
					dataType: 'json',
					success: function(data) {
						if (data.length > 0) {
							for (var i = data.length - 1; i >= 0; i--) {
								var msgContainer = $("<div></div>");
								msgContainer.css("border-radius", "20px");
								msgContainer.css("padding", "8px");
								msgContainer.css("margin", "4px");
								
								if (data[i]["user"] == "yes") {
									msgContainer.css("background-color", "#C2CEFB");
									msgContainer.css("border", "2px solid blue");
								} else {
									msgContainer.css("background-color", "#BBF8B9");
									msgContainer.css("border", "2px solid green");
								}
								
								var name = data[i]["Sender"];
								var msgHeader = $("<h4></h4>");
								msgHeader.text(name);
								
								var message = data[i]["Contents"];
								var msgBody = $("<p></p>");
								msgBody.text(message);
								
								msgHeader.appendTo(msgContainer);
								msgBody.appendTo(msgContainer);
								msgContainer.appendTo($("#msgs"));
								
							}
						} else {
							$("<h4>No messages. Come on. Don't be shy!</h4>").appendTo($("#msgs"));
						}
					},
					error: function(xhr, status, error) {
						var errorMessage = xhr.status + ': ' + xhr.statusText;
						alert('Error - ' + errorMessage + error);
					}
				});
			});
		</script>
	</head>
	<body>
		<a style="text-decoration:none; color:black" href="./homepage.php"><h1>Chitter Chatter</h1></a>
		<h2><?php echo $_SESSION['user_id']?>'s chat with <?php echo $_SESSION['friend_id']?></h2>
		<form action="../app/logout.php" method="post">
			<input type="submit" value="Logout">
		</form><hr style="border-top:1px solid black">
		
		<div id="msgs"></div>
		
		<form action="../app/sendMessage.php" method="post">
			<textarea rows="4" cols="50" id="newMsg" name="newMsg">Enter text here...</textarea><br/>
			<input type="submit" value="Send">
		</form>
	</body>
</html>
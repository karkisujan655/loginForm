<?php
include "connection.php";
	session_start();
	if(!isset($_SESSION['user'])){
		header("location: index.php");	
	}
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Home Page</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	
	<h1>
		WELCOME
	</h1>
	<h3> Hello, 
	<?php
	//  echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; 
	echo $_SESSION['user'];
	 ?>
</h3>

<style>
	h3 {
	  position: relative;
	  animation-name: move;
	  animation-duration: 4s;
	  animation-iteration-count: infinite;
	  animation-direction: alternate;
	  color: linen;
	  background-color: #45f3ff;
  	  padding: 6px;
	  font-family: 'Open Sans', sans-serif;
  	  font-weight: bold;
  	  text-shadow: 2px 2px #333;
		border-radius: 10px;
	}

	@keyframes move {
	  from {right: -100px;}
	  to {right: 100px;}
	}
	
</style>
			<div class="links">
				<a href="logot.php">Logout</a>
			</div>

</body>
</html>
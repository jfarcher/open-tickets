<?php
session_start();
if(!isset($_SESSION["ticketsuser"])){

$page=$_GET["page"];
?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>Tickets</title>
<link rel="stylesheet" type="text/css" media="screen" href="style-login.css">

    <script src="libs/prefixfree.min.js"></script>

</head>

<body>

  <div class="body"></div>
		<div class="grad"></div>
		<div class="header">
			<div>Tickets</div>
		</div>
		<br>
		<div class="login">
				<form id="login-form" action="login.php" method="post">
				<input type="text" placeholder="Username" name="ticketsuser"><br>
				<input type="password" placeholder="Password" name="ticketspass"><br>
				<input type="submit" value="Login">
			</form>
		</div>

  <script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>

</body>

</html>
<?php
}
else{
header("location:admin.php");
}


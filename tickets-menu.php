<?php
session_start();
if(!isset($_SESSION['ticketsuser']) || !isset($_SESSION['ticketspass'])){
//if(!session_is_registered(ticketsuser)){
$page=$_SERVER['REQUEST_URI'];
header("location:index.php?page=$page");

}
else{
?>
<html>
<head>
<link rel="stylesheet" type="text/css" media="screen" href="style.css">
</head>
<body>

<hr width=90>
<a href="tickets.php?s=open" target="mainframe">View Open Tickets</a><br>
<a href="tickets.php?s=closed" target="mainframe">Closed in last 24h</a><br>
<a href="tickets.php?s=unassigned" target="mainframe">Unassigned Tickets</a><br>
<a href="tickets-new.php" target="mainframe">New Ticket</a><br>
<hr width=90>
<a href="logout.php" target="_top">Logout</a>

</body>
</html>
<?php
}
?>

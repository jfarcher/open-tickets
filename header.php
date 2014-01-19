<?php
session_start();
if(!isset($_SESSION['ticketsuser']) || !isset($_SESSION['ticketspass'])){
//if(!session_is_registered(ticketsuser)){
$page=$_SERVER['REQUEST_URI'];
header("location:index.php?page=$page");

}
else{
include("config.inc.php");
?>
<html>
<head>
<link rel="stylesheet" type="text/css" media="screen" href="style.css">
</head>
<body>
<div id="wrap">
<div id="header">
<h1><?php print $title;?></h1>
<ul id="nav">
<li><a href="tickets.php?s=open">View Open Tickets</a></li>
<li><a href="tickets.php?s=closed">Closed in last 24h</a></li>
<li><a href="tickets.php?s=unassigned">Unassigned Tickets</a></li>
<li><a href="tickets-new.php" target="mainframe">New Ticket</a></li>

<li><a href="logout.php" >Logout</a></li>
</ul>
</div>
<div id="content">
<?php
}
?>

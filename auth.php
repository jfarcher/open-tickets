<?php
session_start();
if(!isset($_SESSION['ticketsuser']) || !isset($_SESSION['ticketspass'])){

//if(!session_is_registered(ticketsuser)){
header("location:index.php");
}
else{
print "
<html>
<body>
<frameset cols=\"15%,85%\" border=0>
  <frame src=\"tickets-menu.php\" name=\"menuframe\">
  <frame src=\"tickets-view.php\" name=\"mainframe\">
</frameset>
</body>
</html>
";
}

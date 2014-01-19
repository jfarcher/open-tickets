<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">

<?php
include("header.php");
require("config.inc.php");
include("functions.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");

get_unassigned();
include("footer.php");
?>

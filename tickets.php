<?php
include("header.php");
require("config.inc.php");
include("functions.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");

$sec=$_GET["s"];
?>

<?php

if ($sec=="closed"){ print ("<h3>Tickets closed in the last 24 Hours.</h3>");}
if ($sec=="open"){ print ("<h3>Tickets Open and assigned</h3>");}
if ($sec=="unassigned"){ print ("<h3>Tickets currently unassigned</h3>");}
?>

<?php
if ($sec=="closed"){
$sql="SELECT * from tickets_ticket where status='2' ORDER BY date";
$result = mysql_query($sql) or die ("Query failed");
$numofrows = mysql_num_rows($result);
echo "<table border=\"0\" width=\"800\">";
echo "<tr ><th>Ticket ID</th><th>Ticket Subject</th><th>User</th></tr>";
for($i = 0; $i < $numofrows; $i++) {
    $row = mysql_fetch_array($result); //get a row from our result set
?>
<tr class="<?php echo ($i % 2 == 0) ? "even" : "odd";?>">
<?php

$tid=$row['id'];
$tech=$row['tech'];
    echo "<td><a href=\"tickets-view.php?tid=$tid\"> $tid</a></td><td>" . $row['subject'] . "</td><td>" . get_tech($tech) . "</td>";
    echo "</tr>";
}
echo "</table>";


}
if ($sec=="open"){
$sql="SELECT * from tickets_ticket where status!='2' AND tech!='0' ORDER BY date";
$result = mysql_query($sql) or die ("Query failed");
$numofrows = mysql_num_rows($result);
echo "<table border=\"0\" width=\"800\">";
echo "<tr><td width=10>Ticket ID</td><td>Date Raised</td><td>Ticket Subject</td><td width=30>Assigned To</td></tr>";
for($i = 0; $i < $numofrows; $i++) {
    $row = mysql_fetch_array($result); //get a row from our result set
?>
<tr class="<?php echo ($i % 2 == 0) ? "even" : "odd";?>">
<?php
$tech=$row['tech'];
$tid=$row['id'];
$date=$row['date'];
$date=date("H:i d/m/y",$date);
    echo "<td><a href=\"tickets-view.php?tid=$tid\"> $tid</a></td><td>$date</td><td>" . $row['subject'] . "</td><td>" . get_tech($tech) . "</td>";
    echo "</tr>";
}
echo "</TABLE>";
}

if($sec=="unassigned"){
get_unassigned();
}
?>

<?php 
mysql_close(); 
include("footer.php");
?>


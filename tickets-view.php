<?php
$tid=$_GET["tid"];
include("config.inc.php");
include("functions.php");
include("header.php");
if ($tid==""){
}
else{
$details=get_ticket_from_id($tid);
$subject=$details[1];
$techno=$details[6];
$tech=get_tech($techno);
//$date=get_ticket_date($tid);
$ticket_details=get_ticket_details($tid);
$custno=$details[2];
$statraw=$details[3];
$priority=$details[4];
$customer_name=get_customer_details($custno);
$status=get_status($details[3]);
?>
<script language="javascript">
<!--
var state = 'none';

function showAddMessage(layer_ref) {

if (state == 'block') { 
state = 'none'; 
} 
else { 
state = 'block'; 
} 
if (document.all) { //IS IE 4 or 5 (or 6 beta) 
eval( "document.all." + layer_ref + ".style.display = state"); 
} 
if (document.layers) { //IS NETSCAPE 4 or below 
document.layers[layer_ref].display = state; 
} 
if (document.getElementById &&!document.all) { 
hza = document.getElementById(layer_ref); 
hza.style.display = state; 
} 
} 
//--> 
</script>


<h2>Ticket: <?php echo$tid; ?></h2>
<?php
echo "Assigned to: " . $tech . "<br>";

print "
<form method=\"post\" action=\"tickets-action.php\" name=\"updateticket\">
<input type=\"hidden\" name=\"ticketsaction\" value=\"updateticket\">
<input type=\"hidden\" name=\"tid\" value=\"$tid\">
<label for=\"customer\">Customer:</label <p name=\"customer\">$customer_name[0]</p>
<label for=\"company\">Company:</label><p>$customer_name[1]</p>
<label for=\"telephone\">Telephone:</label><p>$customer_name[2]</p>
<label for=\"subject\">Ticket Subject:</label><p>$subject</p>
<label for=\"ticket_details\">Ticket Details:</label><p name=\"ticket_details\" readonly=\"readonly\">$ticket_details</p><br>
<input type=\"hidden\" name=\"ostatus\" value=\"$statraw\">
<label for=\"status\">Status:</label>
";
if ($statraw=="2"){
print"$status";
}
else{
print"
<select name=\"status\">


";
//mysql_connect ("$dbhost", "$dbuser", "$dbpass");
//mysql_select_db("$dbname") or die("cannot select DB");
$sql="select * from tickets_status where id !='1'";
$result = mysql_query($sql) or die ("12Query failed");        /*** query the database ***/

while($row = mysql_fetch_array($result)){
        
            echo '<option value="'.$row['id'].'"';
            if($row['id']==$statraw)
            {
                echo ' selected';
            }
            echo '>'. $row['status'] . '</option>'."\n";
}
print "</select><br>";
}

print "
<input type=\"hidden\" name=\"opriority\" value=\"priority\">
<label for=\"priority\">Priority</label>
";
if($statraw=="2"){
print get_priority($priority);
}
else{
print"
<select width=\"60\" name=\"priority\">
";
//need an if statement here to cover non support based tickets
$sql="select * from tickets_priority where id!=\"5\"";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
 echo '<option value="'.$row['id'].'"';
            if($row['id']==$priority)
            {
                echo ' selected';
            }
            echo '>'. $row['priority'] . '</option>'."\n";


}

print"
</select><br>
";
}
if ($techno=="0"){
print "<label for=\"assignee\">Assign to:</label>";
}
else {
print "<label for=\"assignee\">Assigned to:</label>";
}
print"
<input type=\"hidden\" name=\"oassignee\" value=\"$techno\">
";
if($statraw=="2"){
print $tech;
}
else{
print"
<select width=\"60\" name=\"assignee\">
";
$sql="select * from tickets_techs";
$result = mysql_query($sql) or die ("Query failed");        /*** query the database ***/

while($row = mysql_fetch_array($result)){

            echo '<option value="'.$row['id'].'"';
            if($row['id']==$techno)
            {
                echo ' selected';
            }
            echo '>'. $row['name'] . '</option>'."\n";
}
print "
</select><br>
";
}
if ($statraw!="2"){print"<input type=\"submit\"  value=\"Make Changes\">";}
print"
</form>
";

//tidy up formatting
?>
<BR>
<HR>Messages:
<?php
if ($statraw!="2"){
?><form method="post" action="tickets-action.php" name="addmessage">
<input type="button" name="displaymessagebox" value="Add Message" onclick="showAddMessage('message1');" />
<div id="message1" style="display: none;">
<textarea cols="80" rows="7" name="newmessage"></textarea>
<input type="checkbox" name="privmess">Make this message Private
<input type="hidden" name="ticketsaction" value="addmessage">
<input type="hidden" name="tid" value="<?php echo $tid; ?>">
<input type="hidden" name="author" value="<?php echo $_SESSION['ticketsuser']; ?>">
<input type="submit" name="postmessage" value="Post Message">
</div>
</form>
<?php
}

mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="select * from tickets_messages where tid=$tid and (type=2 OR type=3 OR type=5 OR type=6) order by id";
$result = mysql_query($sql) or die (" Query failed");
$numofrows = mysql_num_rows($result);
echo "<TABLE BORDER=\"0\" width=\"90%\"  padding=10px>";
for($i = 0; $i < $numofrows; $i++) {

$row = mysql_fetch_array($result); //get a row from our result set
$author=$row[3];
$type=$row[2];
if($author[0]=="T"){
if ($type=="3"){
echo "<TR bgcolor=\"#81F781\"><td>";
}
else{
        echo "<TR bgcolor=\"#A9D0F5\"><TD>";
}
$techid=substr("$author",1);
echo "Tech response: <BR>";
$auth2=get_tech($techid);
}
elseif($author[0]=="C"){
echo "<TR bgcolor=\"#F2F5A9\"><td>";
$custid=substr("$author",1);
echo "Customer response: <BR>";
$cust=get_customer_details($custid);
$auth2="$cust[0] - $cust[1]";
}
elseif($author[0]=="S"){
echo "<TR bgcolor=\"#F5A9A9\"><td>";
echo "Service Desk response:";
$sid=substr("$author",1);
$auth2=get_tech($sid);

}

$message=$row[4];
$date=$row[5];
echo "Updated by " .$auth2 . "<BR>";
$message=nl2br($message);
print "<p>$message</p>";
$date=date("G:i D jS F Y",$date);
echo $date;   
print"</td></TR>";
}
echo "</table>
</fieldset>";

}
?>
<?php
include("footer.php");
?>

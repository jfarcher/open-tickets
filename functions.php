<?php

function get_tech($tech){
include ("config.inc.php");
if ($tech=="0"){
return ("<font color=red>Unassigned</font>");
}
else{
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT name from tickets_techs where id=$tech";
$result = mysql_query($sql) or die ("Query failed");
$row = mysql_fetch_array($result);
$techname=$row['name'];
return ($techname);
}
}
function get_tech_id($tech){
include ("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT * from tickets_techs where username=\"$tech\"";
$result = mysql_query($sql) or die ("Query failed - get_tech_id");
$row = mysql_fetch_array($result);
$techid=$row['id'];
return ($techid);
}
function get_tech_email($tech){
include("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT email from tickets_techs where id=\"$tech\"";
$result = mysql_query($sql) or die ("Query failed");
$row = mysql_fetch_array($result);
$email=$row['email'];
return ($email);
}

function get_status($status){
include ("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT status from tickets_status where id=$status";
$result = mysql_query($sql) or die ("Query failed - get_status");
$row = mysql_fetch_array($result);
$status=$row['status'];
return ($status);
}

function get_priority($priority){
include ("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT priority from tickets_priority where id=\"$priority\"";
$result = mysql_query($sql) or die ("Query failed - get_priority");
$row = mysql_fetch_array($result);
$priority=$row['priority'];
return ($priority);
}

function get_category($category){
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT status from tickets_category where id=$category";
$result = mysql_query($sql) or die ("Query failed - get_category");
$row = mysql_fetch_array($result);
$category=$row['category'];
return ($category);
}

function get_ticket_from_id($tid){
include ("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT * from tickets_ticket where id=$tid";
$result = mysql_query($sql) or die ("Query failed - get_ticket_from_id");
$row = mysql_fetch_array($result);
$tid=$row['id'];
$subject=$row['subject'];
$cid=$row['cid'];
$status=$row['status'];
$priority=$row['priority'];
$category=$row['category'];
$tech=$row['tech'];
$returnarray=array($tid,$subject,$cid,$status,$priority,$category,$tech);
return $returnarray;
}

function get_customer_details($cid){
include ("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT * from tickets_users where id=$cid";
$result = mysql_query($sql) or die ("Query failed - get_customer_details");
$row = mysql_fetch_array($result);
$name=$row['name'];
$company=$row['company'];
$telephone=$row['telephone'];
$mobile=$row['mobile'];
$postcode=$row['postcode'];
$address=$row['address'];
$email=$row['email'];
$returnarray=array($name,$company,$telephone,$mobile,$postcode,$address,$email);
return $returnarray;
}

function get_cid_from_email($email){
include ("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT id from tickets_users where email LIKE \"%$email%\"";
$result = mysql_query($sql);
if (mysql_num_rows($result)=="0"){
return FALSE;
}
else{
$row = mysql_fetch_array($result);
$cid=$row['id'];
return $cid;
}
}
function get_email_from_tid($tid){
include("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="select cid from tickets_ticket where id=\"$tid\"";
$result=mysql_query($sql);
$row = mysql_fetch_array($result);
$cid=$row['cid'];
$sql2="SELECT email from tickets_users where id=\"$cid\"";
$result2=mysql_query($sql2);
$row2=mysql_fetch_array($result2);
$email=$row2['email'];
return $email;
}

function get_ticket_details($tid){
//this function retrieves the main details for the ticket from the messages table.
include ("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql="SELECT * from tickets_messages where tid=$tid and type='1'";
$result = mysql_query($sql) or die ("Query failed - get_ticket_details");
$row = mysql_fetch_array($result);
$details=$row[4];
return $details;
}

function clean_data($string) {
//  if (get_magic_quotes_gpc()) {
//    $string = stripslashes($string);
//  }

//do {
//        $count = 0;
//        $string = preg_replace('/(<)([^>]*?<)/' , '&lt;$2' , $string , -1 , $count);
//    } while ($count > 0);
//    $string = strip_tags($string);
//    $string = str_replace('>' , '&gt;' , $string);
return mysql_real_escape_string($string);
}
function remove_headers($string) { 
  $headers = array(
    "/to\:/i",
    "/from\:/i",
    "/bcc\:/i",
    "/cc\:/i",
    "/Content\-Transfer\-Encoding\:/i",
    "/Content\-Type\:/i",
    "/Mime\-Version\:/i" 
  ); 
  return preg_replace($headers, '', $string); 
}

//Ticket creation stuff

 function ValidID($tid) {
//function to check that the randomly generated ticket ID doesn't already exist in the database
 global $dbhost, $dbuser, $dbpass, $dbname;
 include("config.inc.php");
 mysql_connect ("$dbhost", "$dbuser", "$dbpass");
 mysql_select_db("$dbname") or die("cannot select DB");
 $sql = "SELECT ID FROM tickets_ticket where id = $tid";
 $result = mysql_query($sql) or die (mysql_error());
  if (mysql_num_rows($result)==0){
     return false;}
else{
     return true;
}
 }
//function checkvalidcustomer($cid){
// check that the customer trying to create a ticket (probably via email) is valid
//}
//function checkvalidcontract($cid){
// check the customer has a valid support contract
//}


function CreateTicket($subject,$cid,$message,$priority,$error){
$date=time();
global $dbhost, $dbuser, $dbpass, $dbname;
include("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");

$sql = "insert into tickets_ticket VALUES(\"\",\"$subject\",\"$cid\",\"1\",\"5\",\"1\",\"0\",\"$date\")";
mysql_query($sql)or die(mysql_error());
$tid=mysql_insert_id();
$sql2 = "insert into tickets_messages VALUES(\"\",\"$tid\",\"1\",\"S1\",\"$message\",\"$date\")";
mysql_query($sql2)or die(mysql_error());
//Send Confirmation email to user
$email = get_customer_details($cid);
$email = $email[6];
if($error=="1"){
$contents = file_get_contents("ticket_email_error.txt");
$contents = str_replace("<<ticket>>",$tid,$contents);
$contents = str_replace("<<email>",$email,$contents);
$oldno= substr(strstr($subject, "[#"), 2, 5);
$subject = preg_replace("[[][#][0-9]{5}[]]","",$subject);
$subject = "[#$tid] $subject";
$contents = str_replace("<<oldno>>",$oldno,$contents);
}
else{
$contents = file_get_contents("ticket_email.txt");
$contents = str_replace("<<ticket>>",$tid,$contents);
$contents = str_replace("<<email>>",$email,$contents);
$subject = "[#$tid] $subject";
}
//$buffer = clean_data($message);
$buffer = nl2br($message);
$buffer = str_replace("\'", "'", $buffer);
$buffer = str_replace('\"', '"', $buffer);
$buffer = str_replace('\\n','<br>',$buffer);
  if (Send_Email($email, $from, $subject, $contents."<br><br>--------Ticket details--------<br>".$buffer)) {
    echo "Creation email sent.<br>\n";
  } else {
    echo "Creation email failed.<br>\n";
  }   
return $tid;
}

function CreateUnsupportedTicket($subject,$cid,$message,$priority,$error){
//Still under construction for next version

$date=time();
global $dbhost, $dbuser, $dbpass, $dbname;
include("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");

$sql = "insert into tickets_unsupported_ticket VALUES(\"\",\"$subject\",\"$cid\",\"1\",\"5\",\"1\",\"0\",\"$date\")";
mysql_query($sql)or die(mysql_error());
$tid=mysql_insert_id();
$sql2 = "insert into tickets_unsupported_messages VALUES(\"\",\"$tid\",\"1\",\"S1\",\"$message\",\"$date\")";
mysql_query($sql2)or die(mysql_error());


}
function UpdateEmail($tid,$message,$who){
$buffer = nl2br($message);
$buffer = str_replace("\'", "'", $buffer);
$buffer = str_replace('\"', '"', $buffer);
$buffer = str_replace('\\n','<br>',$buffer);
$message=$buffer;
if($who=="T"){
// a tech ticket update
$contents = file_get_contents("ticket_update_tech.txt");
}
elseif($who=="C"){
// a user ticket update
$contents = file_get_contents("ticket_update.txt");
}
$email=get_email_from_tid($tid);
$problem=get_ticket_from_id($tid);
$problem1=$problem[1];
$priority=$problem[4];
$status=$problem[3];
$status=get_status($status);
$priority=get_priority($priority);
$contents = str_replace("<<ticket>>",$tid,$contents);
$contents = str_replace("<<problem>>",$problem1,$contents);
$contents = str_replace("<<update>>",$message,$contents);
$contents = str_replace("<<status>>",$status,$contents);
$contents = str_replace("<<priority>>",$priority,$contents);
$subject="[#$tid] Ticket has been updated";
Send_Email($email,$from,$subject,$contents);
return($from);
}
function NoLogEmail($cemail,$reason,$tid){
if ($reason=="1"){
$reasontxt="Your E-Mail Address isn't associated with a support account";
}
$contents = file_get_contents("ticket_nolog.txt");
$subject="There Were Issues With Your Support Request";
$contents = str_replace("<<reason>>",$reasontxt,$contents);
Send_Email($cemail,$from,$subject,$contents);
return($from);
}

//create message function to put an entry into the messages table.
function createMessage($tid,$type,$authtype,$auth,$message){
include("config.inc.php");
$date=time();
 mysql_connect ("$dbhost", "$dbuser", "$dbpass");
 mysql_select_db("$dbname") or die("cannot select DB");
$sql = "insert into tickets_messages VALUES(\"\",\"$tid\",\"$type\",\"$authtype$auth\",\"$message\",\"$date\")";
if ($authtype!="S"){
UpdateEmail($tid,$message,$authtype);
}
mysql_query($sql)or die(mysql_error());
}


//EMAIL STUFF
function get_mime_type(&$structure) {
    $primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");

    if($structure->subtype) {
        return $primary_mime_type[(int) $structure->type] . '/' . $structure->subtype;
    }
    return "TEXT/PLAIN";
}
function Send_Email ($to,$from,$subject,$message) {
    // Prepare headers for HTML EMail Message
    $headers = "From: " . $from . " <" . $from . ">\r\n";
    $headers .= "Return-Path: " . $from . " <" . $from . ">\r\n";
    $headers .= "Reply-To: " . $from . " <" . $from . ">\r\n";
    $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";

    // Send Message
    return mail($to,$subject,$message,$headers);
}



function get_part($stream, $msg_number, $mime_type, $structure = false, $part_number = false) {
    if(!$structure) {
        $structure = imap_fetchstructure($stream, $msg_number);
    }
    if($structure) {
        if($mime_type == get_mime_type($structure)) {
            if(!$part_number) {
                $part_number = "1";
            }
            $text = imap_fetchbody($stream, $msg_number, $part_number);
            if($structure->encoding == 3) {
                return imap_base64($text);
            } else if($structure->encoding == 4) {
                return imap_qprint($text);
            } else {
                return $text;
            }
        }
        if($structure->type == 1) /* multipart */ {
            while(list($index, $sub_structure) = each($structure->parts)) {
                if($part_number) {
                    $prefix = $part_number . '.';
                }
                $data = get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1));
                if($data) {
                    return $data;
                }
            }
        }
    }
    return false;
}

function GetEmails() {
// WORK IN PROGRESS
//    global $trouble_email;
$mbox = imap_open("{$IMAP_SERV/imap:143/novalidate-cert}INBOX","tech.support","$IMAP_PASS")
	        or print ("Error retrieving new mail from tech support<br>\n");
//       Next;
//	exit;
	$curmsg = 1;
if (imap_num_msg($mbox) <> 0) print "Retrieving new messages.<br>";
  	while ($curmsg <= imap_num_msg($mbox)) {
            	$body = get_part($mbox, $curmsg, "TEXT/PLAIN");
	if ($body == "")
          $body = get_part($mbox, $curmsg, "TEXT/HTML");
	  $body=eregi_replace("-----Original.*","",$body); 
	  if ($body == "") { 
            print "Error: Message could not be parsed. I left it in the mailbox.<br>";
            continue;
        }
	$body=clean_data($body);           
	$head = imap_headerinfo($mbox, $curmsg, 800, 800);

//	$cemail = $head->reply_toaddress;
	$cemail = $head->from;
	$cemail=eregi_replace(".*<","",$cemail); // pl - quick hack to parse name, email
        $cemail=eregi_replace(">.*","",$cemail); // pl - quick hack contd.
    	$name = $head->fromaddress;
	$name=eregi_replace(" <.*","",$name); // pl - quick hack contd.
        $subject = $head->fetchsubject;
	$subject=imap_utf8($subject);
	$subject = utf8_decode($subject);
	$cid=get_cid_from_email($cemail);
	if ($cid==""){
	
	}
//send signup email and email group create non-contract based ticket
	//add entry to non-contract database table and enter into phonebook. with flag in flags table for missing info.

//if cid is !NULL check cid against contracts database for valid support contract

            print "Subject: $subject<br>";
echo $cemail;        
    /* Check the subject for ticket number */
//	Need to modify this as it doesn't always seem to pick up tickets.
            if (!ereg ("[[][#][0-9]{5}[]]", $subject)) {
                /* Seems like a new ticket, create it first */
	$ticket_id = CreateTicket($subject, $cid, $body);
		print "ticket created #$ticket_id";
	    if ($ticket_id == false) {
                    print "Warning: CreateTicket failed! Message forwarded to $trouble_email <br>";
	            Send_Email($trouble_email,$cemail, "{Ticket Problems} $subject", "[ERROR: CreateTicket failed]\n".$body);
		    imap_delete($mbox, $curmsg);
                    $curmsg++;
                    continue;
                }
            } else {
                /* Seems like a followup of an existing ticket, extract ticket_id from subject */
                $ticket_id = substr(strstr($subject, "[#"), 2, 5);
if (ValidID($ticket_id)==TRUE){
	//ticket exists in database so we need to add an update message
	print "Follow up to ticket #$ticket_id<br>";
	createMessage($ticket_id,"2","C","$cid","$body");
}
	else{
	//For some reason the ticket number specified in the subject doesn't exist in the database so we'll create
	//a ticket and also email admin with the details.
	$ticket_id2=CreateTicket($subject,$cid,$body,"3","1");
	//need a function for sending emails which contain a fault line
	Send_Email($trouble_email,"tech.support","{Ticket Problems}-ID specified but not in DB",$ticket_id." specified but not in database $ticket_id2 created". $body);
		}
            }

//            if (!PostMessage($ticket_id, $body)) {
//                /* Could not post the ticket, forward the problematic email to a real human */
//                print "Warning: PostMessage failed! Message forwarded to $trouble_email <bR>";
//                mail ($trouble_email, "{TROUBLE} $subject", "[ERROR: PostMessage failed]\n".$body, "From: $name\nReply-To: $email");
//            }
	imap_delete($mbox, $curmsg);
        $curmsg++;
        imap_expunge($mbox);
        imap_close($mbox);
    }
}

function notify_tech($tech,$ticket){
$email=get_tech_email($tech);
$subject ="You have been assigned a ticket #$ticket";
$message ="You have had a ticket assigned to you #$ticket";
Send_Email($email,$from,$subject,$message);
}

function get_unassigned(){
$sql="SELECT * from tickets_ticket where status='1' AND tech='0' ORDER BY date";
$result = mysql_query($sql) or die ("Query failed");
$numofrows = mysql_num_rows($result);
print "<div id=\"formish\" class=\"myform\">";
echo "<table border=\"0\" width=\"800\">";
echo "<tr bgcolor=\"#81BEF7\"><td>Ticket ID</td><td>Date Raised</td><td>Ticket Subject</td><td>Client</td></tr>";
for($i = 0; $i < $numofrows; $i++) {
    $row = mysql_fetch_array($result); //get a row from our result set
?>
<tr class="<?php echo ($i % 2 == 0) ? "even" : "odd";?>">
<?php
        $tid=$row['id'];
$cid=$row['cid'];
$client=get_customer_details($cid);
if($client[1]){
$client="$client[0] - $client[1]";
}
else{
$client=$client[0];
}
//        $tid=str_pad($tid, 6,"0", Str_PAD_LEFT);
        $date=$row['date'];
$date=date("H:i d/m/y",$date);
    echo "<td><a href=\"tickets-view.php?tid=$tid\"> $tid</a></td><td>".$date."</td><td>" . $row['subject'] . "</td> <td>$client</td></tr>";
}
echo "</table></div>";
}
?>

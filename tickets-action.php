<?php
session_start();
if(!isset($_SESSION['ticketsuser']) || !isset($_SESSION['ticketspass'])){

//if(!session_is_registered(ticketsuser)){
$page=$_SERVER['REQUEST_URI'];
header("location:index.php?page=$page");

//header("location:index.php");
}
else{
if ($_GET['ticketsaction']){
$ticketsaction=$_GET['ticketsaction'];
}
else{
$ticketsaction=$_POST['ticketsaction'];
}

if($ticketsaction=="addmessage"){
include ("functions.php");
$author=$_POST['author'];
$tid=$_POST['tid'];

$message=$_POST['newmessage'];
$message=clean_data($message);
$message=remove_headers($message);
//echo $message;
//echo $author;
$techid=get_tech_id($author);
//echo $techid;
include("config.inc.php");
$privmess=$_POST['privmess'];
if($privmess=="on"){
$type="3";
}
else{
$type="2";
}
$time=time();

if($type!="3"){
$mte=nl2br($message);
UpdateEmail("$tid","$mte","T");
}
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$sql= "INSERT INTO tickets_messages VALUES(\"\",\"$tid\",\"$type\",\"T$techid\",\"$message\",\"$time\")";
$result = mysql_query($sql) or die ("Message insert Query failed");
header("location:tickets-view.php?tid=$tid");
}

//ticket structure updates
if($ticketsaction=="updateticket"){
include("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");

$tid=$_POST[tid];
$assignee=$_POST[assignee];
$oassignee=$_POST[oassignee];
$status=$_POST[status];
$ostatus=$_POST[ostatus];
$priority=$_POST[priority];
$opriority=$_POST[opriority];

if($status!=$ostatus){
if ($status=="2"){
//header("location:tickets-action.php?ticketsaction=close&tid=$tid");
print "Closing ticket $tid<BR>";
?>
<html>
<head>
<link rel="stylesheet" type="text/css" media="screen" href="style.css">
<script src="libs/jquery.js" type="text/javascript"></script>
<script src="libs/dimensions.js" type="text/javascript"></script>
<script src="libs/autocomplete.js" type="text/javascript"></script>
<script type="text/javascript">
        $(function(){
            setAutoComplete("cusno", "results", "libs/autocomplete.php?part=");
        });
</script>

</head>
<body>
<div id="formish" class="myform">


Please enter a close description
<form id="form" name="form" method="post" action="?ticketsaction=close" enctype="multipart/form-data" >
<input type="hidden" name="tid" value="<?php echo $tid; ?>">
<textarea name="close" id="body" rows="20" cols="76" wrap="virtual" onfocus="alreadyFocused=true;">
</textarea>
<input type="submit" name="attach" value="Close">

</form>
</body>
</html>
<?php

exit;
//open a page to enter a close description
}
elseif ($status=="0"){
//survey says ich urgh not allowed to change to unassigned. leaving status incase the assignee has been changed this will set the status to 3 assigned
//this if is a holder so the else can exist
}
else{
$sql="UPDATE tickets_ticket set status=\"$status\" where id=\"$tid\"";
mysql_query($sql);
}
}


if (!($assignee==$oassignee)){
//assignee has changed
$sql="UPDATE tickets_ticket set tech=\"$assignee\" where id=\"$tid\"";
mysql_query($sql);
include("functions.php");
notify_tech($assignee,$tid);
//need to change author in create message to reflect a correct entity - possibly the logged in user
$author=$_SESSION[ticketsuser];
$author=get_tech_id($author);
$assname=get_tech($assignee);
createMessage($tid,"6","S",$author,"Ticket has been reassigned to $assname");
if(($ostatus==$status)AND($ostatus=="1")){

//we will change status to assigned here.
$sql="UPDATE tickets_ticket set status=\"3\" where id=\"$tid\"";
mysql_query($sql);
}
}
if (!($priority==$opriority)){
$sql="UPDATE tickets_ticket set priority=\"$priority\" where id=\"$tid\"";
mysql_query($sql);

}
header("location:tickets-view.php?tid=$tid");

}
//page if close
if ($ticketsaction=="close"){
include("config.inc.php");
include("functions.php");
$tid=$_POST['tid'];
$close=$_POST['close'];
echo "Closing ticket $tid, reason $close";
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");

$sql="Update tickets_ticket set status=\"2\" where id=\"$tid\"";
mysql_query($sql);
$author=$_SESSION[ticketsuser];
$author=get_tech_id($author);
createMessage($tid,"5","S",$author,$close);
$contents=file_get_contents("ticket_close.txt");
$email=get_email_from_tid($tid);
$problem=get_ticket_from_id($tid);
$problem1=$problem[1];
$priority=$problem[4];
$contents = str_replace("<<ticket>>",$tid,$contents);
$contents = str_replace("<<problem>>",$problem1,$contents);
$contents = str_replace("<<desc>>",$close,$contents);
$subject="[#$tid] Ticket has been closed";
Send_Email($email,$from,$subject,$contents);
header("location:tickets-view.php?tid=$tid");

}
}
?>

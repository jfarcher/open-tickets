<?php
ob_start();
include('config.inc.php');
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");
$ticketsuser=$_POST['ticketsuser'];
$ticketspass=$_POST['ticketspass'];
$page=$_POST['page'];
$ticketsuser = stripslashes($ticketsuser);
$ticketspass = stripslashes($ticketspass);

$ticketsuser = mysql_real_escape_string($ticketsuser);
$ticketspass = mysql_real_escape_string($ticketspass);
$encpass = md5($ticketspass);
$sql="SELECT * FROM tickets_techs WHERE username='$ticketsuser' and password='$encpass'";
$result=mysql_query($sql);
$count=mysql_num_rows($result);

if($count==1){
//session_register("ticketsuser");
session_start();
$_SESSION['ticketsuser']="$ticketsuser";
$_SESSION['ticketspass']="$ticketspass";
//session_register("ticketspass");
if ($page==""){
header("location:admin.php");
}
else{
header("location:$page");
}
}
else {
echo "$ticketsuser<BR>";
echo "$ticketspass<BR>";
echo "Error invalid username or password";
if (!$falseid){
$falseid=1;
}
else{
$falseid="$falseid+1";
}
$_SESSION['falseid']=$falseid;
//session_register("falseid");
}
ob_end_flush();
?>

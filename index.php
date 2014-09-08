<?php
session_start();
if(!isset($_SESSION["ticketsuser"])){

$page=$_GET["page"];

print ("

<html>
<head>
<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"style.css\">
</head>
<body >
	<form id=\"login-form\" action=\"login.php\" method=\"post\">
		<fieldset >
		
			<legend>Log in</legend>
			
			<label  for=\"login\">Email</label>
			<input  type=\"text\" id=\"ticketsuser\" name=\"ticketsuser\"/>
			<div class=\"clear\"></div>
			
			<label for=\"password\">Password</label>
			<input type=\"password\" id=\"ticketspass\" name=\"ticketspass\"/>
			<div class=\"clear\"></div>
			
			<label for=\"remember_me\" style=\"padding: 0;\">Remember me?</label>
			<input type=\"checkbox\" id=\"remember_me\" style=\"position: relative; top: 3px; margin: 5; \" name=\"remember_me\"/>
			<div class=\"clear\"></div>
			
			<br />
			
			<input type=\"submit\" style=\"margin: -20px 0 0 287px;\" class=\"button\" name=\"commit\" value=\"Log in\"/>	
		</fieldset>
	</form>

<!--<table width=\"300\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"1\" bgcolor=\"#CCCCCC\">
<tr>
<form name=\"form 1\" method=\"post\" action=\"login.php\">
<td>
<table width=\"100%\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#FFFFFF\">
<tr>
<td colspan=\"3\"><strong>Login</strong></td>
</tr>
<tr>
<td width=\"78\">Username</td>
<td width=\"6\">:</td>
<td width=\"294\"><input name=\"ticketsuser\" type=\"text\" id=\"ticketsuser\"></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name=\"ticketspass\" type=\"password\" id=\"ticketspass\"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<input type=\"hidden\" name=\"page\" value=\"$page\">
<td><input type=\"submit\" name=\"Submit\" value=\"Login\"></td>
</tr>
</table>
</td>
</form>
</tr>
</table>-->
</div>
");
}
else{
header("location:admin.php");
}

<?php
include("header.php");
$stage=$_POST[stage];
if ($stage==""){
include("header.php");
?>
<script type="text/javascript">
        $(function(){
            setAutoComplete("cusno", "results", "libs/autocomplete.php?part=");
        });
</script>

<div id="formish" class="myform">

<form id="form" name="form" method="post" action="?stage=2" enctype="multipart/form-data" > 
<label for="cusno">Customer Number:</label /> 
<input type="text" name="cusno" id="cusno" size="60" /><br>
<div id="tnci">

Are these details correct
</div>
<label for="subject">Ticket Subject:</label>
         <input type="text" name="subject" value="" size="60"/>   <br>

<?php
include("config.inc.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");
mysql_select_db("$dbname") or die("cannot select DB");

print "
<label for=\"priority\">Priority</label>
<select width=\"60\" name=\"priority\">
";
$sql="select * from tickets_priority";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){
 echo '<option value="'.$row['id'].'"';
            if($row['id']=="4")
            {
                echo ' selected';
            }
            echo '>'. $row['priority'] . '</option>'."\n";


}

print"
</select><br>
";
?>
<label for="body">Description</label>
<textarea name="body" id="body" rows="20" cols="76" wrap="virtual" onfocus="alreadyFocused=true;"> 
</textarea> 
<br>
 

<input type="hidden" name="MAX_FILE_SIZE" value="2097152" /> 
<label for="attachfile">Attach:</label> 
<input name="attachfile" size="48" type="file" /> 

<input type="submit" name="attach" value="Add" /> 
</form> 
</body></html> 
<?php
}
if($stage=="1"){
$namenumber=$_POST[namenumber];
if (!is_numeric($namenumber)==1){
echo"Searching customer name";

}
else{
include("functions.php");
$cust=get_customer_details($namenumber);
if ($cust[0]==""){
echo "not found, try again";
}
else{
echo "Customer: $cust[0]";

}}
}

include("footer.php");
?>

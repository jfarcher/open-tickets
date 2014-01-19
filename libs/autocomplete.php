<?php
/**
 * AutoComplete Field - PHP Remote Script
 *
 * This is a sample source code provided by fromvega.
 * Search for the complete article at http://www.fromvega.com
 *
 * Enjoy!
 *
 * @author fromvega
 *
 */

// define the colors array
include ("../functions.php");
include ("../db.php");
mysql_connect ("$dbhost", "$dbuser", "$dbpass");                                                                                                                                                         
mysql_select_db("$dbname") or die("cannot select DB");                                                                                                                                                   
$sql="SELECT id from phonebook";
$result = mysql_query($sql) or die ("Query failed");               
$values=array();
while ($row = mysql_fetch_array($result)){
$values[]=$row[0];    
}
// Delete last empty one



//$colors = array('black', 'blue', 'brown', 'green', 'grey',
//		'gold', 'navy', 'orange', 'pink', 'silver',
//		'violet', 'yellow', 'red');

// check the parameter
if(isset($_GET['part']) and $_GET['part'] != '')
{
	// initialize the results array
	$results = array();

	// search colors
	foreach($values as $value)
	{
		// if it starts with 'part' add to results
		if( strpos($value, $_GET['part']) === 0 ){
			$who = get_customer_details($value);
			$who = $who[0];
			$results[] = "$value" ." -  $who";
//	$results[] = $value;
		}
	}

	// return the array as json with PHP 5.2
	echo json_encode($results);
	// or return using Zend_Json class
	//require_once('Zend/Json/Encoder.php');
	//echo Zend_Json_Encoder::encode($results);
}

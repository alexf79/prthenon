<?php
$tbname="pn";
$hostname = "50.63.107.108";
$database = "parthenon123";
$username = "parthenon123";
$password = "NAN@123dos";

$connect = mysql_connect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);

if(!$connect){
	echo "Not Connected";
	exit;
}

?>

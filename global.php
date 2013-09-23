<?php
$httpAddress = "prthenon.com";

$appname ="Prthenon"; 

$sitename = "Prthenon";

$temppage = explode("/",substr($_SERVER['PHP_SELF'],1));
if($temppage[1]=="")
	$pagename = $temppage[0];
else
	$pagename = $temppage[1];


$Encrypt = "mysecretkey";
include('dbopen.php');
mysql_select_db($database, $connect);


?>
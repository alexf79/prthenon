<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}
include('global.php');
include('include/functions.php');
if(isset($_REQUEST['search']))
{
	
	$CatID=encrypt($_REQUEST['CID'],$Encrypt);
	$alphabetic=encrypt($_REQUEST['alphabetic'],$Encrypt);
	$page=$_REQUEST['page'];
	$searchkey=encrypt($_REQUEST['searchkey'],$Encrypt);
	
	echo "<script language='JavaScript'>window.location='rating.php?CID=".$CatID."&alphabetic=".$alphabetic."&page=".$page."&searchkey=".$searchkey."';</script>";
	exit;
}

?>
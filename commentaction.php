<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}
include('global.php');
include('include/functions.php');
if(isset($_REQUEST['Submit']))
{
		$comment=trim($_REQUEST['comment']);
		$CatID=trim($_REQUEST['cid']);
		$PCID=trim($_REQUEST['pid']);
		$date=date('Y-m-d');
		
	
	$insert="insert into  ".$tbname."_comment (_UID,_CID,_PID,_comment,_DateAdded) values ('".$_SESSION['userid']."','".replaceSpecialChar($CatID)."','".replaceSpecialChar($PCID)."','".replaceSpecialChar($comment)."','".$date."') ";

	if(mysql_query($insert))
		echo "<script language='JavaScript'>alert('Comment added successfully');window.close();window.opener.location.reload(true);</script>";
	} 

	


?>


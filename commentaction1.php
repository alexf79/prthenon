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
		
	
	$upd="update ".$tbname."_comment set _comment='".replaceSpecialChar($comment)."' where _UID='".$_SESSION['userid']."' and _CID='".replaceSpecialChar($CatID)."' and _PID='".replaceSpecialChar($PCID)."' ";

	if(mysql_query($upd))
		echo "<script language='JavaScript'>alert('Comment Updated successfully');window.close();window.opener.location.reload(true);</script>";
	} 

	


?>


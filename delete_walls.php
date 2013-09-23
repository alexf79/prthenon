<?php
	session_start();
	
	if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
	{
		echo "<script language='javascript'>window.location='index.php';</script>";
	}
	include('global.php');

	$user_id=$_REQUEST['UID'];
	$sql = "delete from ".$tbname."_wallposts where post_wall = '".$user_id."'";
	mysql_query($sql);
?>
<script>
	document.location.href = '/category_listing.php';
</script>

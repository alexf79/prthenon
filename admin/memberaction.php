<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
 
	include('../global.php');	
	include('../include/functions.php');  		
	include("classresizeimage.php");	

	$e_action = $_REQUEST['e_action'];	
	$id = trim($_REQUEST['id']);
	$PageNo = $_REQUEST['PageNo'];
	
	if ($e_action == 'delete')
	{
		$emailString = "";
	
		$cntCheck = $_POST["cntCheck"];
		for ($i=1; $i<=$cntCheck; $i++)
		{
			if ($_POST["CustCheckbox".$i] != "")
			{
				$emailString = $emailString . "_ID = '" . $_POST["CustCheckbox".$i] . "' OR ";
			}
		}
	
		$emailString = substr($emailString, 0, strlen($emailString)-4);
	
		
		$str = "delete from ".$tbname."_member ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='members.php?done=".encrypt('3',$Encrypt)."';</script>";
		exit();
	}
	
?>
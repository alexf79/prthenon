<?php
session_start();
include('global.php');
include('include/functions.php');

if(isset($_REQUEST['Submit']))
{
	
	$user=$_POST['username'];
	$Encrypt = "mysecretkey";
	$pass = encrypt($_POST['password'], $Encrypt);
	
	$sel_mem="select * from ".$tbname."_member where _Username='".$user."' AND _Password='".$pass."' ";
	$qr_mem=mysql_query($sel_mem);
	
	$res_mem=mysql_fetch_array($qr_mem);
	if($res_mem)
	{
		$logno=$res_mem['_Logno']+1;
		$uplog="update ".$tbname."_member set _Lastlog='".date('Y-m-d')."',_Logno='".$logno."' where _ID='".$res_mem['_ID']."'";
		$qr_log=mysql_query($uplog);
		
		$_SESSION['userid']=$res_mem['_ID'];
		$_SESSION['fname']=$res_mem['_Fname'];
		$_SESSION['lname']=$res_mem['_Lname'];
		$_SESSION['email']=$res_mem['_Email'];
		$_SESSION['photo']=$res_mem['_Photo'];
		$_SESSION['answers']=$res_mem['_QAanswers'];
				
		header("Location:category_listing.php");
	}
	else
	{
		echo "<script language='JavaScript'>alert('Invalide Username and Password.');window.location = 'index.php';</script>";			
	}
	
}

?>

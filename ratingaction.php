<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}

include('global.php');
include('include/functions.php');

$date = date('Y-m-d');

if(isset($_REQUEST['Submit']))
{
	$CatID=$_POST['CatID'];
	$alphabetic=$_POST['alphabetic'];
	$searchkey=$_POST['searchkey'];
	$currentpage=$_POST['currentpage'];
	
	$productid=$_POST['productID'];
	foreach($productid as $k=>$v)
	{
		$rat=$_POST['amount'.$v];
		if($rat >'0.00') 
		{
			$str_sel="select * from ".$tbname."_userrates where _Uid='".$_SESSION['userid']."' and _Prodid='".$v."'";
			$qr_sel=mysql_query($str_sel);
			if(mysql_num_rows($qr_sel) > 0)
			{
				$str_del="delete from ".$tbname."_userrates where _Uid='".$_SESSION['userid']."' and _Prodid='".$v."'";
				$qr_del=mysql_query($str_del);
			}
			$str="insert into ".$tbname."_userrates (_Prodid,_Uid,_Rate,_DateAdded) values('".$v."','".$_SESSION['userid']."','".$rat."','".$date."')";
			$qr_str=mysql_query($str);
		}
		else
		{
			$del="delete from ".$tbname."_userrates where _Prodid='".$v."' and _Uid='".$_SESSION['userid']."'";
			$qr_del=mysql_query($del);
			
			$del_c="delete from ".$tbname."_comment where _PID='".$v."' and _Uid='".$_SESSION['userid']."'";
			$qr_delc=mysql_query($del_c);
		}
		
	}
	echo "<script language='JavaScript'>window.location = 'rating.php?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&searchkey=".encrypt($searchkey,$Encrypt)."&currentpage=".$currentpage."&done=".encrypt(1,$Encrypt)."';</script>";		
	
	
}

?>

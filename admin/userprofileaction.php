<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']==""){
	echo "<script language='javascript'>window.location='login.php';</script>";
}
else{
	include('../global.php');
	include('../include/functions.php');          
	$Fullname = trim($_POST["Fullname"]);
	$Encrypt = "mysecretkey";
	$CurrentPassword  = encrypt($_POST["CurrentPassword"], $Encrypt);
	$NewPassword = encrypt($_POST["NewPassword"], $Encrypt);
	$Email = trim($_POST["Email"]);	
	$Remarks = trim($_POST["Remarks"]);
	
	if(trim($CurrentPassword) != ""){
	
		$str = "SELECT * FROM ".$tbname."_user WHERE _ID = '" . replaceSpecialChar($_SESSION['userid']) . "' AND _Password = '" . replaceSpecialChar($CurrentPassword) . "' ";
		
		//echo $str;
		//exit();
		
		$rst = mysql_query($str, $connect) or die(mysql_error());
	
		if(mysql_num_rows($rst) <= 0){
			include('dbclose.php');
			echo "<script language='javascript'>window.location='userprofile.php?error=1';</script>";
		}else{
			$CorrectPassword = "Yes";
		}
	}
	
	if((trim($CurrentPassword) == "") || ($CorrectPassword == "Yes")){
	
		// Code for not duplication of email //////////////		
		$sql = "select _Email from ".$tbname."_user where _Email='". replaceSpecialChar($Email)."'  and _ID != '" . replaceSpecialChar($_SESSION['userid']) . "'  ";
		$qry = mysql_query($sql);
		$nfound = mysql_num_rows($qry);
		
		if($nfound > 0)
		{
 			echo "<script language='javascript'>window.location='userprofile.php?error=2';</script>";
			exit;
		
		}
		
		$strSQL = "UPDATE ".$tbname."_user SET ";

		if ($Fullname != ""){
			$strSQL = $strSQL . "_Fullname = '" . replaceSpecialChar($Fullname) . "', ";
		}else{
			$strSQL = $strSQL . "_Fullname = null, ";
		}
		
		if (trim($NewPassword) != ""){
			$strSQL = $strSQL . "_Password = '" . replaceSpecialChar($NewPassword) . "', ";
		}
				
		if ($Email != ""){
			$strSQL = $strSQL . "_Email = '" . replaceSpecialChar($Email) . "', ";
		}else{
			$strSQL = $strSQL . "_Email = null, ";
		}
	
		if ($Remarks != ""){
			$strSQL = $strSQL . "_Remarks = '" . replaceSpecialChar($Remarks) . "' ";
		}else{
			$strSQL = $strSQL . "_Remarks = null ";
		}
		
		$strSQL = $strSQL . "WHERE _ID = '" . replaceSpecialChar($_SESSION['userid']) . "'";
	
		//echo $strSQL;
		//exit();
	
		mysql_query($strSQL);
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . replaceSpecialChar($_SESSION['userid']) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit User Profile', ";
		
		if ($Fullname != ""){
			$strSQL = $strSQL . "'" . replaceSpecialChar($Fullname) . "' ";
		}else{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);	
	}
	include('../dbclose.php');
	echo "<script language='javascript'>window.location='userprofile.php?done=1';</script>";
}
?>
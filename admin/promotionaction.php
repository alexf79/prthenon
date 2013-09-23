<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');	
	include('../include/functions.php');		
	$e_action = $_REQUEST['e_action'];
	$id = trim($_REQUEST['id']);
	$PageNo = $_REQUEST['PageNo'];
	$curdatetime = date("YmdHis");
	
	$PromotionName = trim($_POST["PromotionName"]);	
	
	if($_POST["PublishDate"]!="DD/MM/YYYY")
	{
		$TmpDay1 = explode('/',$_POST["PublishDate"]);		
		$PublishDay = trim($TmpDay1[0]);
		$PublishMth = trim($TmpDay1[1]);
		$PublishYr =  trim($TmpDay1[2]);
	}
	
	if($PublishDay != "" && $PublishMth != "" && $PublishYr != "") {
		$PublishDay = FormatDigitString($PublishDay, 2);
		$PublishMth = FormatDigitString($PublishMth, 2);
		$PublishDate = $PublishYr . "-" . $PublishMth . "-" . $PublishDay;
	}else $PublishDate = "";
			
	$BriefInfo = trim($_POST["BriefInfo"]);	
	$Description = trim($_POST["FCKeditor1"]);	
	$Status = trim($_POST["Status"]);	
													
	if($e_action == "AddNew")
	{		
		$str = "INSERT INTO ".$tbname."_promotion (_PromotionName, _PublishDate, _BriefInfo, ";
		$str .= "_Description, _Status, _UserID, _LastUpdatedByID, _IPAddress, _CreatedDate, _LastUpdatedDate) VALUES(";
		if($PromotionName != "")
			$str = $str . "'" . replaceSpecialChar($PromotionName) . "', ";
		else
			$str = $str . "null, ";
			
		if($PublishDate != "")
			$str = $str . "'" . replaceSpecialChar($PublishDate) . "', ";
		else
			$str = $str . "null, ";
			
		if($BriefInfo != "")
			$str = $str . "'" . replaceSpecialChar($BriefInfo) . "', ";
		else
			$str = $str . "null, ";

		if($Description != "")
			$str = $str . "'" . $Description . "', ";
		else
			$str = $str . "null, ";				
		
		if($Status != "")
			$str = $str . "'" . replaceSpecialChar($Status) . "', ";			
		else
			$str = $str . "null, ";	
										
		if($_SESSION['userid'] != "")
			$str = $str . "'" . replaceSpecialChar($_SESSION['userid']) . "', ";
		else
			$str = $str . "null, ";
			
		if($_SESSION['userid'] != "")
			$str = $str . "'" . replaceSpecialChar($_SESSION['userid']) . "', ";
		else
			$str = $str . "null, ";
			
		$str = $str . "'" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
		if($curdatetime != "")
			$str = $str . "'" . replaceSpecialChar($curdatetime) . "', ";
		else
			$str = $str . "null, ";
			
		if($curdatetime != "")
			$str = $str . "'" . replaceSpecialChar($curdatetime) . "' ";
		else
			$str = $str . "null ";
			
		$str = $str . ") ";
		mysql_query($str);

		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . replaceSpecialChar($_SESSION['userid']) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Add New Promotion', ";
		if ($PromotionName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($PromotionName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
							
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'promotions.php?PageNo=".$PageNo."&done=1'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		$str = "UPDATE ".$tbname."_promotion SET ";
							
		if($PromotionName != "")		
			$str = $str . "_PromotionName = '" . replaceSpecialChar($PromotionName) . "', ";
		else
			$str = $str . "_PromotionName = null, ";				
					
		if($PublishDate != "")		
			$str = $str . "_PublishDate = '" . replaceSpecialChar($PublishDate) . "', ";		
		else		
			$str = $str . "_PublishDate = null, ";
		
		if($BriefInfo != "")		
			$str = $str . "_BriefInfo = '" . replaceSpecialChar($BriefInfo) . "', ";		
		else		
			$str = $str . "_BriefInfo = null, ";
			
		if($Description != "")		
			$str = $str . "_Description = '" . $Description . "', ";		
		else		
			$str = $str . "_Description = null, ";
			
		if ($Status != "")			
			$str = $str . "_Status = '" . replaceSpecialChar($Status) . "', ";			
		else
			$str = $str . "_Status = null, ";
			
		if($_SESSION['userid'] != "")
			$str = $str . "_LastUpdatedByID = '" . replaceSpecialChar($_SESSION['userid']) . "', ";
		else
			$str = $str . "_LastUpdatedByID = null, ";
			
		$str = $str . "_IPAddress = '" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
		
		if($curdatetime != "")
			$str = $str . "_LastUpdatedDate = '" . replaceSpecialChar($curdatetime) . "' ";
		else
			$str = $str . "_LastUpdatedDate = null ";		
				
		$str = $str . "WHERE _ID = '" . replaceSpecialChar($id) . "' ";
		
		mysql_query($str);
		
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . replaceSpecialChar($_SESSION['userid']) . "', ";
		$strSQL = $strSQL . "'" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Edit Promotion', ";
		if ($PromotionName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($PromotionName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);				
				
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'promotions.php?PageNo=".$PageNo."&done=2'</script>";
		exit();
	}
	elseif ($e_action == 'delete')
	{
		$emailString = "";
	
		$cntCheck = $_POST["cntCheck"];
		for ($i=1; $i<=$cntCheck; $i++)
		{
			if ($_POST["CustCheckbox".$i] != "")
			{
				$emailString = $emailString . "_ID = '" . replaceSpecialChar($_POST["CustCheckbox".$i]) . "' OR ";
			}
		}
	
		$emailString = substr($emailString, 0, strlen($emailString)-4);
	
		$str = "SELECT DISTINCT _PromotionName FROM ".$tbname."_promotion WHERE (" . $emailString . ") ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{
				$str = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$str = $str . "'" . replaceSpecialChar($_SESSION['userid']) . "', ";
				$str = $str . "'" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
				$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
				$str = $str . "'Delete Promotion', ";
				if ($rs["_PromotionName"] != "")
				{
					$str = $str . "'" . str_replace("'", '&#39;', $rs["_PromotionName"]) . "' ";
				}
				else
				{
					$str = $str . "null ";
				}
				$str = $str . ")";
				mysql_query($str);
			}
		}
		$str = "DELETE FROM ".$tbname."_promotion ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='promotions.php?done=3';</script>";
		exit();
	}	
?>
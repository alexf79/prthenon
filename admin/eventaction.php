<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');	
	include('../include/functions.php');		
	include("classresizeimage.php");	

	$e_action = decrypt($_REQUEST['e_action'],$Encrypt);
	$id = decrypt($_REQUEST['id'],$Encrypt);
	$PageNo = decrypt($_REQUEST['PageNo'],$Encrypt);
	$curdatetime = date("YmdHis");
	
	$EventName = trim($_POST["EventName"]);	
	
	if($_POST["EventDate"]!="DD/MM/YYYY")
	{
		$TmpDay1 = explode('/',$_POST["EventDate"]);		
		$EventDay = trim($TmpDay1[0]);
		$EventMth = trim($TmpDay1[1]);
		$EventYr =  trim($TmpDay1[2]);
	}
	if($EventDay != "" && $EventMth != "" && $EventYr != "") {
		$EventDay = FormatDigitString($EventDay, 2);
		$EventMth = FormatDigitString($EventMth, 2);
		$EventDate = $EventYr . "-" . $EventMth . "-" . $EventDay;
	}else $EventDate = "";
			
	$BriefInfo = trim($_POST["BriefInfo"]);	
	$Description = trim($_POST["FCKeditor1"]);	
	$Status = trim($_POST["Status"]);	
	
	$AdminProductPicPath = "../images/events/";	
	$ProductFilePath = "../files/";
	
	if ($_FILES["cicon"]["size"] > 0)
	{
		if ($_FILES["cicon"]["error"] > 0)
			echo "Return Code: " . $_FILES["cicon"]["error"] . "<br />";
		else
		{
			$splitfilename = strtolower($_FILES["cicon"]["name"]); 
			$exts = split("[/\\.]", $splitfilename); 
			$n = count($exts)-1;
			$exts = $exts[$n];

			$datetime1 = date("YmdHis") . generateNumStr(4);
			$Thumbnaili = "";
			$Thumbnaili = $datetime1 . "." . $exts;		

			$datetime2 = date("YmdHis") . generateNumStr(4);
			$Imagei = "";
			$Imagei = $datetime2 . "." . $exts;

			$datetime3 = date("YmdHis") . generateNumStr(4);
			$Originali = "";
			$Originali = $datetime3 . "." . $exts;

			if (file_exists($AdminProductPicPath . $Thumbnaili))
				echo $Image . " already exists. ";
			else
			{						
				//Thumbnail				
				$myfile2 = new UploadedImage;
				$myfile2->file = $_FILES["cicon"];
				$myfile2->maxwidth = 100;
				$myfile2->maxheight = 100;
				$myfile2->relscale = true;
				$myfile2->scale = $_POST['scale'];
				$myfile2->newfile = $datetime1;
				$myfile2->maxsize = 10485760000;
				$myfile2->pictype = "Thumbnail";
				$myfile2->transfer = "Copy";
				$myfile2->uploaddir = $AdminProductPicPath;
				if(!$myfile2->upload_file()){
					echo $myfile2->ErrorMsg;
					exit();
				}				
												
				//Normal				
				$myfile2 = new UploadedImage;
				$myfile2->file = $_FILES["cicon"];
				$myfile2->maxwidth = 300;
				$myfile2->maxheight = 300;
				$myfile2->relscale = true;
				$myfile2->scale = $_POST['scale'];
				$myfile2->newfile = $datetime2;
				$myfile2->maxsize = 10485760000;
				$myfile2->pictype = "Thumbnail";
				$myfile2->transfer = "Copy";
				$myfile2->uploaddir = $AdminProductPicPath;
				if(!$myfile2->upload_file()){
					echo $myfile2->ErrorMsg;
					exit();
				}	
				
				//Original
				move_uploaded_file( $_FILES["cicon"]['tmp_name'] , $AdminProductPicPath.$Originali );
				chmod($AdminProductPicPath.$Originali, 0644);	
			}
		}
	}
	
													
	if($e_action == "AddNew")
	{		
	
		$str = "INSERT INTO ".$tbname."_events (_EventName, _EventDate, _BriefInfo, ";
		$str .= "_Description, _Image, _Status, _UserID, _LastUpdatedByID, _IPAddress, _CreatedDate, _LastUpdatedDate) VALUES(";
		if($EventName != "")
			$str = $str . "'" . replaceSpecialChar($EventName) . "', ";
		else
			$str = $str . "null, ";
			
		if($EventDate != "")
			$str = $str . "'" . replaceSpecialChar($EventDate) . "', ";
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
		
		if($Imagei != "")
			$str = $str . "'" . $Originali . "', ";
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
		$strSQL = $strSQL . "'Add New Event', ";
		if ($EventName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($EventName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
							
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'events.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt("1",$Encrypt)."'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
	
		/*echo $Description;
		echo replaceSpecialChar($Description)
		exit;*/
	
		$str = "UPDATE ".$tbname."_events SET ";
							
		if($EventName != "")		
			$str = $str . "_EventName = '" . replaceSpecialChar($EventName) . "', ";
		else
			$str = $str . "_EventName = null, ";				
					
		if($EventDate != "")		
			$str = $str . "_EventDate = '" . replaceSpecialChar($EventDate) . "', ";		
		else		
			$str = $str . "_EventDate = null, ";
		
		if($BriefInfo != "")		
			$str = $str . "_BriefInfo = '" . replaceSpecialChar($BriefInfo) . "', ";		
		else		
			$str = $str . "_BriefInfo = null, ";
			
		if($Description != "")		
			$str = $str . "_Description = '" . $Description . "', ";		
		else		
			$str = $str . "_Description = null, ";
		
		if($Imagei != "")
			$str = $str . "_Image = '" . replaceSpecialChar($Originali) . "', ";
		
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
		$strSQL = $strSQL . "'Edit Event', ";
		if ($EventName != "")
		{
			$strSQL = $strSQL . "'" . replaceSpecialChar($EventName) . "' ";
		}
		else
		{
			$strSQL = $strSQL . "null ";
		}
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);				
				
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'events.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt("2",$Encrypt)."'</script>";
		exit();
	}
	else if ($e_action == 'objdelete')
	{
		$str = "UPDATE ".$tbname."_events SET _Image = '' where _ID = ".replaceSpecialChar($id)."";
		mysql_query($str);
		
		$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
		$strSQL = $strSQL . "'" . $_SESSION['userid'] . "', ";
		$strSQL = $strSQL . "'" . $_SERVER['REMOTE_ADDR'] . "', ";
		$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
		$strSQL = $strSQL . "'Delete Category Image', ";
		$strSQL = $strSQL . "null ";
		$strSQL = $strSQL . ")";
		mysql_query($strSQL);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='event.php?id=".encrypt($id,$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."&imgdel=1';</script>";
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
	
		$str = "SELECT DISTINCT _EventName FROM ".$tbname."_events WHERE (" . $emailString . ") ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			while($rs = mysql_fetch_assoc($rst))
			{
				$str = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
				$str = $str . "'" . replaceSpecialChar($_SESSION['userid']) . "', ";
				$str = $str . "'" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
				$str = $str . "'" . date("Y-m-d H:i:s") . "', ";
				$str = $str . "'Delete Event', ";
				if ($rs["_EventName"] != "")
				{
					$str = $str . "'" . str_replace("'", '&#39;', $rs["_EventName"]) . "' ";
				}
				else
				{
					$str = $str . "null ";
				}
				$str = $str . ")";
				mysql_query($str);
			}
		}
		$str = "DELETE FROM ".$tbname."_events ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='events.php?done=".encrypt("3",$Encrypt)."';</script>";
		exit();
	}	
?>
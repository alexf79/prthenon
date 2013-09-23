<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	else
	{
		include('../dbopen.php');
		include('../global.php');
		include('../include/functions.php');			
		mysql_select_db($database, $connect) or die(mysql_error());	
		
		$HomePageImagePath = "../images/bottomleft/";
		
		$e_action = $_REQUEST['e_action'];
		$id = trim($_REQUEST['id']);
		$TypeID = trim($_REQUEST['typeid']);
		
		$HTMLContent = $_POST["FCKeditor1"];			
		$MetaTitle = $_POST["MetaTitle"];
		$MetaDec = $_POST["MetaDec"];
		$MetaKey = $_POST["MetaKey"];
		$MetaAdd = $_POST["MetaAdd"];				
		$PreviewID = $_REQUEST["PreviewID"];
		$curdatetime = date("YmdHis");
		$brifinfo = $_POST["brifinfo"];	
		$withLogin = $_REQUEST['withlogin'];
		$withoutLogin = $_REQUEST['withoutlogin'];
 		
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~Image 1~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~//
		$Image1Exist = trim($_POST['Image1Exist']);
	
		if($Image1Exist == "")
		{
		
			if ($_FILES["NewIcon"]["size"] > 0)
			{				
				if ($_FILES["NewIcon"]["error"] > 0)
				{
					echo "Return Code: " . $_FILES["NewIcon"]["error"] . "<br />";
				}
				else
				{ 		          
					$splitfilename = strtolower($_FILES["NewIcon"]["name"]) ; 
					$exts = split("[/\\.]", $splitfilename) ; 
					$n = count($exts)-1; 
					$exts = $exts[$n]; 
					$datetime = date("YmdHis") . generateNumStr(4);
	
					$Image1FileName = "";
					$Image1FileName = $datetime . "." . $exts;
	
					if (file_exists($HomePageImagePath . $Image1FileName))
					{
						echo $Image1FileName . " already exists. ";
					}
					else
					{
						move_uploaded_file( $_FILES["NewIcon"]['tmp_name'] , $HomePageImagePath . $Image1FileName );
						chmod($HomePageImagePath . $Image1FileName, 0777);
					}
				}
			}
		}
		
		

		if($e_action == "edit")
		{
			$str = "UPDATE ".$tbname."_home_cms SET ";
									
			if($HTMLContent != "" && $HTMLContent != "<br />")
				$str = $str . "_HTMLContent = '" . replaceSpecialChar($HTMLContent) . "', ";
			else
				$str = $str . "_HTMLContent = null, ";
				
			if($brifinfo != "" && $brifinfo != "<br />")
				$str = $str . "_brifInfo = '" . replaceSpecialChar($brifinfo) . "', ";
			else
				$str = $str . "_brifInfo = null, ";		
						
			if($Image1FileName != "")
				$str = $str . "_Image1='" . replaceSpecialChar($Image1FileName) . "', ";			
			
			$str = $str . "_Status = 'Live', ";
				
			if($_SESSION['userid'] != "")
				$str = $str . "_LastUpdatedByID = '" . replaceSpecialChar($_SESSION['userid']) . "', ";
			else
				$str = $str . "_LastUpdatedByID = null, ";
			
			if($withLogin != "")
				$str = $str . "_withLogin = '" . replaceSpecialChar($withLogin) . "', ";
			else
				$str = $str . "_withLogin = 0, ";
			
			if($withoutLogin != "")
				$str = $str . "_withoutLogin = '" . replaceSpecialChar($withoutLogin) . "', ";
			else
				$str = $str . "_withoutLogin = 0, ";
				
			
			$str = $str . "_IPAddress = '" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
			
			if($curdatetime != "")
				$str = $str . "_LastUpdatedDate = '" . replaceSpecialChar($curdatetime) . "' ";
			else
				$str = $str . "_LastUpdatedDate = null ";	
							
				$str = $str . "WHERE _ID = '".replaceSpecialChar($id)."' ";
			//echo $str;
			//exit;
			mysql_query($str) or die(mysql_error());
						
			$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
			$strSQL = $strSQL . "'" . replaceSpecialChar($_SESSION['userid']) . "', ";
			$strSQL = $strSQL . "'" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
			$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
			$strSQL = $strSQL . "'Edit Home Types', ";
			if($PageTitle != "")
				$strSQL = $strSQL . "'" . replaceSpecialChar($PageTitle) . "' ";
			else
				$strSQL = $strSQL . "null ";
			$strSQL = $strSQL . ")";
			mysql_query($strSQL);
	
			include('../dbclose.php');
					
			echo "<script language='JavaScript'>window.location = '2ndlvlhomecms.php?done=2&typeid=".encode($TypeID)."';</script>";	
			exit();
		}
		else if($e_action == "homeupdatedisplay")
		{
			$cntCheck = trim($_POST["cntCheck"]);
			
			for($i=1; $i<=$cntCheck; $i++)
			{
				$str = "UPDATE ".$tbname."_home_cms SET ";
				if($_POST["Display".$i] != "")
					$str .= "_Display = '" . replaceSpecialChar($_POST["Display".$i]) . "' ";
				else
					$str .= "_Display = null ";				
				$str .= "WHERE _ID = '" . trim($_POST["CatID".$i]) . "' ";
				mysql_query($str);
			}
			
			$strSQL = "INSERT INTO ".$tbname."_auditlog (_UserID, _IPAddress, _LogDate, _Event, _EventItem) VALUES (";
			$strSQL = $strSQL . "'" . replaceSpecialChar($_SESSION['userid']) . "', ";
			$strSQL = $strSQL . "'" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
			$strSQL = $strSQL . "'" . date("Y-m-d H:i:s") . "', ";
			$strSQL = $strSQL . "'Update Home CMS Display', ";
			$strSQL = $strSQL . "null ";
			$strSQL = $strSQL . ")";
			mysql_query($strSQL);
		
			include('../dbclose.php');
			echo "<script language='JavaScript'>alert('Home Page Types Display(s) has been updated successfully.'); window.location='".$_SERVER['HTTP_REFERER']."';</script>";
			exit();
		}else if($e_action == "EditPreview")
		{			
				$str = "UPDATE ".$tbname."_home_cms SET ";				
										
				if($HTMLContent != "" && $HTMLContent != "<br />")
					$str = $str . "_HTMLContent = '" . $HTMLContent . "', ";
				else
					$str = $str . "_HTMLContent = null, ";
				
				$str = $str . "_Display = 'Yes', ";			
					
				if($_SESSION['userid'] != "")
					$str = $str . "_LastUpdatedByID = '" . replaceSpecialChar($_SESSION['userid']) . "', ";
				else
					$str = $str . "_LastUpdatedByID = null, ";
					
				$str = $str . "_IPAddress = '" . replaceSpecialChar($_SERVER['REMOTE_ADDR']) . "', ";
				
				if($curdatetime != "")
					$str = $str . "_LastUpdatedDate = '" . replaceSpecialChar($curdatetime) . "' ";
				else
					$str = $str . "_LastUpdatedDate = null ";			
				$str = $str . "WHERE _ID = '".replaceSpecialChar($id)."' ";
				mysql_query($str);
				$MaxID = $id;
			
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = 'edit2ndlvlhomecms.php?typeid=".encode($TypeID)."&status=Preview';</script>";					
			exit();
		}
		else if ($e_action == 'objdelete')
		{
			$str = "UPDATE ".$tbname."_home_cms SET _Image1 = '' where _ID = '".replaceSpecialChar($id)."'";
			//echo $str;
			//exit;
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
			echo "<script language='JavaScript'>window.location = 'homeleftbottom.php?PageNo=1&id=".$_REQUEST['id']."&typeid=".encode($TypeID)."'</script>";
			exit();
		}
	}
?>
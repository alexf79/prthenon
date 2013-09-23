<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	else
	{
		include('../global.php');
		include('../include/functions.php');	
		
		
		if($_REQUEST['e_action'] != "AddNew" &&  $_REQUEST['e_action'] != "Edit" &&  $_REQUEST['e_action'] != "cmsupdateorder" &&  $_REQUEST['e_action'] != "AddPreview" &&  $_REQUEST['e_action'] != "EditPreview")
		{
			foreach($_GET as $k=>$v)
			{
			   $_GET[$k] = decrypt($v,$Encrypt);
			}
			foreach($_REQUEST as $k=>$v)
			{
			   $_REQUEST[$k] = decrypt($v,$Encrypt);
			}
			foreach($_POST as $k=>$v)
			{
			   $_POST[$k] = decrypt($v,$Encrypt);
			}
		
		}
	
		$PID = $_REQUEST['PID'];
		$Level = $_REQUEST['Level'];
		$e_action = $_REQUEST['e_action'];
		
		$id = trim($_REQUEST['id']);		
		$PageTitle = trim($_REQUEST['PageTitle']);
		$RedirectURL = trim($_REQUEST['RedirectURL']);
		$Title = $_REQUEST["TitleFCKeditor"];
		$HTMLContent = $_REQUEST["FCKeditor1"];
		$Hyperlink = $_REQUEST["Hyperlink"];		
		$MetaTitle = $_REQUEST["MetaTitle"];
		$MetaDec = $_REQUEST["MetaDec"];
		$MetaKey = $_REQUEST["MetaKey"];
		$MetaAdd = $_REQUEST["MetaAdd"];
		$Status = $_REQUEST["Status"];	
		$withLogin = $_REQUEST['withlogin'];
		$withoutLogin = $_REQUEST['withoutlogin'];	
		$PreviewID = $_REQUEST["PreviewID"];
		$curdatetime = date("YmdHis");
	
		if($e_action == "AddNew")
		{										
			//	
			$str = "SELECT * FROM ".$tbname."_cms WHERE _PID = '0' AND _Level = '".replaceSpecialChar($Level)."' ";
			$rst = mysql_query($str, $connect) or die(mysql_error());
			if(mysql_num_rows($rst) > 0)
			{
				$str2 = "SELECT MAX(_Order) AS MaxOrders FROM ".$tbname."_cms WHERE _PID = '0' AND _Level = '".replaceSpecialChar($Level)."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$Orders = (int)$rs2["MaxOrders"] + 1;
				}
			}
			else
			{
				$Orders = 1;
			}			
			//
			$str = "SELECT * FROM ".$tbname."_cms WHERE _PID = '0' AND _Level = '".replaceSpecialChar($Level)."' ";
			$rst = mysql_query($str, $connect) or die(mysql_error());
			if(mysql_num_rows($rst) > 0)
			{
				$str2 = "SELECT MAX(_FooterOrder) AS MaxOrders FROM ".$tbname."_cms WHERE _PID = '0' AND _Level = '".replaceSpecialChar($Level)."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$FooterOrders = (int)$rs2["MaxOrders"] + 1;
				}
			}
			else
			{
				$FooterOrders = 1;
			}
			//
			if($PreviewID=="")
			{
				$str = "INSERT INTO ".$tbname."_cms (_PID, _Level, _PageTitle, _RedirectURL, _Title, _HTMLContent, _Hyperlink, _Display, _Order, _FooterOrder, _MetaTitle,_MetaDescription,_MetaKeyWords,_MetaAdditional, _Status, _UserID, _LastUpdatedByID, _IPAddress, _CreatedDate, _LastUpdatedDate,_withLogin,_withoutLogin) VALUES(";			
				if($PID != "")
					$str = $str . "'" . replaceSpecialChar($PID) . "', ";
				else
					$str = $str . "null, ";				
					
				if($Level != "")
					$str = $str . "'" . replaceSpecialChar($Level) . "', ";
				else
					$str = $str . "null, ";	
								
				if($PageTitle != "")
					$str = $str . "'" . replaceSpecialChar($PageTitle) . "', ";
				else
					$str = $str . "null, ";
				
				if($RedirectURL != "")
					$str = $str . "'" . replaceSpecialChar($RedirectURL) . "', ";
				else
					$str = $str . "null, ";
				
				if($Title != "")
					$str = $str . "'" . replaceSpecialChar($Title) . "', ";
				else
					$str = $str . "null, ";
						
				if($HTMLContent != "" && $HTMLContent != "<br />")
					$str = $str . "'" . replaceSpecialChar($HTMLContent) . "', ";
				else
					$str = $str . "null, ";
				
				if($Hyperlink != "")
					$str = $str . "'" . replaceSpecialChar($Hyperlink) . "', ";
				else
					$str = $str . "null, ";	
				
				if($Status != "Draft")
				{
					$str = $str . "'Yes', ";
				}
				else
				{
					$str = $str . "null, ";
				}
				
				if($Orders != "")
					$str = $str . "'" . replaceSpecialChar($Orders) . "', ";
				else
					$str = $str . "null, ";
					
				if($FooterOrders != "")
					$str = $str . "'" . replaceSpecialChar($FooterOrders) . "', ";
				else
					$str = $str . "null, ";	
								
				if($MetaTitle != "")
					$str = $str . "'" . replaceSpecialChar($MetaTitle) . "', ";			
				else
					$str = $str . "null, ";
						
				if($MetaDec != "")
					$str = $str . "'" . replaceSpecialChar($MetaDec) . "', ";			
				else
					$str = $str . "null, ";	
					
				if($MetaKey != "")
					$str = $str . "'" . replaceSpecialChar($MetaKey) . "', ";			
				else
					$str = $str . "null, ";	
					
				if($MetaAdd != "")
					$str = $str . "'" . replaceSpecialChar($MetaAdd) . "', ";			
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
				
				if($withLogin != "")
					$str = $str . ", '".$withLogin."' ";
				else
					$str = $str . ",0";
				
				if($withoutLogin != "")
					$str = $str . ",'" . replaceSpecialChar($withoutLogin) . "' ";
				else
					$str = $str . ",0";
					
					
				$str = $str . ") ";		
				 
				mysql_query($str);
			}
			
			
			
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = '1stlvlcms.php?done=".encrypt("1",$Encrypt)."'</script>";
			exit();
		}
		else if($e_action == "Edit")
		{
			$str = "UPDATE ".$tbname."_cms SET ";			
			if($PageTitle != "")
				$str = $str . "_PageTitle = '" . replaceSpecialChar($PageTitle) . "', ";
			else
				$str = $str . "_PageTitle = null, ";		
				
			if($RedirectURL != "")
				$str = $str . "_RedirectURL = '" . replaceSpecialChar($RedirectURL) . "', ";
			else
				$str = $str . "_RedirectURL = null, ";		
			
			if($Title != "")
				$str = $str . "_Title = '" . replaceSpecialChar($Title) . "', ";
			else
				$str = $str . "_Title = null, ";		
										
			if($HTMLContent != "" && $HTMLContent != "<br />")
				$str = $str . "_HTMLContent = '" . replaceSpecialChar($HTMLContent) . "', ";
			else
				$str = $str . "_HTMLContent = null, ";							
			
			if ($Hyperlink != "")			
				$str = $str . "_Hyperlink = '" . replaceSpecialChar($Hyperlink) . "', ";			
			else
				$str = $str . "_Hyperlink = null, ";
			
			if($Status != "Draft")
			{
				$str = $str . "_Display = 'Yes', ";
			}
			else
			{
				$str = $str . "_Display = null, ";
			}
				
			if ($MetaTitle != "")			
				$str = $str . "_MetaTitle = '" . replaceSpecialChar($MetaTitle) . "', ";			
			else
				$str = $str . "_MetaTitle = null, ";
				
			if ($MetaDec != "")			
				$str = $str . "_MetaDescription = '" . replaceSpecialChar($MetaDec) . "', ";			
			else
				$str = $str . "_MetaDescription = null, ";
				
			if ($MetaKey != "")			
				$str = $str . "_MetaKeyWords = '" . replaceSpecialChar($MetaKey) . "', ";			
			else
				$str = $str . "_MetaKeyWords = null, ";
				
			if ($MetaAdd != "")			
				$str = $str . "_MetaAdditional = '" . replaceSpecialChar($MetaAdd) . "', ";			
			else
				$str = $str . "_MetaAdditional = null, ";
			
			if ($Status != "")			
				$str = $str . "_Status = '" . replaceSpecialChar($Status) . "', ";			
			else
				$str = $str . "_Status = null, ";
				
			if ($withLogin != "")		
			{	
				$str = $str . "_withLogin = '" .$withLogin. "', "	;		
			}
			else{
				$str = $str . "_withLogin = 0, ";
			}
				
			if ($withoutLogin != "")
			{		
				$str = $str . "_withoutLogin = '" .$withoutLogin. "', "	;
			}
			else{
				$str = $str . "_withoutLogin = 0, ";
				}
 				
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
			
			mysql_query($str) or die(mysql_error());
		   
			
			
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = '1stlvlcms.php?done=".encrypt("2",$Encrypt)."'</script>";
			exit();
		}
		else if($e_action == "delete")
		{
			$str = "SELECT * FROM ".$tbname."_cms WHERE _ID = '".replaceSpecialChar($id)."' ";
			$rst = mysql_query($str, $connect) or die(mysql_error());
			if(mysql_num_rows($rst) > 0)
			{
				$rs = mysql_fetch_assoc($rst);
				$PageTitle = $rs['_PageTitle'];				
			}
			
			$str2 = "SELECT * FROM ".$tbname."_cms WHERE _PID = '".replaceSpecialChar($id)."' ";
			$rst2 = mysql_query($str2, $connect) or die(mysql_error());
			if(mysql_num_rows($rst2) > 0)
			{
				include('../dbclose.php');
				echo "<script language='JavaScript'>window.location = '1stlvlcms.php?error=".encrypt("2",$Encrypt)."&name=".encrypt($PageTitle,$Encrypt)."'</script>";
				exit();
			}

			
			
			$str = "DELETE FROM ".$tbname."_cms WHERE _ID = '".replaceSpecialChar($id)."' AND _PID = '0' ";
			mysql_query($str);

			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = '1stlvlcms.php?done=".encrypt("3",$Encrypt)."'</script>";
			exit();			
		}
		else if($e_action == "cmsupdateorder")
		{
			$cntCheck = trim($_POST["cntCheck"]);
			
			for($i=1; $i<=$cntCheck; $i++)
			{
				$str = "UPDATE ".$tbname."_cms SET ";
				if($_POST["Display".$i] != "")
					$str .= "_Display = '" . replaceSpecialChar($_POST["Display".$i]) . "', ";
				else
					$str .= "_Display = null, ";
					
				if($_POST["Footer".$i] != "")
					$str .= "_Footer = '" . replaceSpecialChar($_POST["Footer".$i]) . "', ";
				else
					$str .= "_Footer = null, ";	
					
				if($_POST["Order".$i] != "")
					$str .= "_Order = '" . replaceSpecialChar($_POST["Order".$i]) . "', ";
				else
					$str .= "_Order = null, ";
					
				if($_POST["FooterOrder".$i] != "")
					$str .= "_FooterOrder = '" . replaceSpecialChar($_POST["FooterOrder".$i]) . "' ";
				else
					$str .= "_FooterOrder = null ";	
				$str .= "WHERE _ID = '" . trim($_POST["CatID".$i]) . "' ";
				mysql_query($str);
			}
			
			
			include('../dbclose.php');
			echo "<script language='JavaScript'>window.location = '1stlvlcms.php?done=".encrypt("4",$Encrypt)."'</script>";
			exit();
		}
		
	}
?>

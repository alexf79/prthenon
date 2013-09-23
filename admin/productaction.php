<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
 
	include('../global.php');	
	include('../include/functions.php');  		
	include("classresizeimage.php");	
	


	if($_REQUEST['e_action'] != "AddNew" &&  $_REQUEST['e_action'] != "Edit" &&  $_REQUEST['e_action'] != "delete")
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

	$e_action = $_REQUEST['e_action'];	
	$id = trim($_REQUEST['id']);
	$PageNo = $_REQUEST['PageNo'];
	
	$p_title = trim($_POST['P_title']);
	$category = trim($_POST['category']);
	$s_des = trim($_POST['S_des']);
		
	
	
	$AdminProductPicPath = "../images/products/";	
	
	
	
	if($e_action == "AddNew")
	{
		
		$str = "INSERT INTO ".$tbname."_product (_Title,_Catid, _Short_Des) VALUES(";
		if($p_title != "")
			$str = $str . "'" . replaceSpecialChar($p_title) . "', ";
		else
			$str = $str . "null, ";
		if($category != "")
			$str = $str . "'" . replaceSpecialChar($category) . "', ";
		else
			$str = $str . "null, ";
			
		if($s_des != "")
			$str = $str . "'" . replaceSpecialChar($s_des) . "' ";
		else
			$str = $str . "null ";	
		
		
					
 		$str = $str . ") ";
	//	echo $str;
	//	exit;
		
		mysql_query($str);				

		$str = "SELECT Max(_ID) AS MaxID FROM ".$tbname."_product ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$MaxID = $rs['MaxID'];
		}
		
			
		
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'products.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('1',$Encrypt)."'</script>";
		exit();
	}
	else if($e_action == "Edit")
	{
		$str = "UPDATE ".$tbname."_product SET ";
		if($p_title != "")
			$str = $str . "_Title = '" . replaceSpecialChar($p_title) . "', ";
		else
			$str = $str . "_Title = null, ";
			
		if($category != "")
			$str = $str . "_Catid = '" . replaceSpecialChar($category) . "', ";
		else
			$str = $str . "_Catid = null, ";
		
		
		if($s_des != "")
			$str = $str . "_Short_Des = '" . replaceSpecialChar($s_des) . "' ";
		else
			$str = $str . "_Short_Des = null ";	
				

		$str = $str . "WHERE _ID = '" . $id . "' ";
			//echo $str;
			//exit;		
		mysql_query($str);


		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location = 'products.php?PageNo=".encrypt($PageNo,$Encrypt)."&done=".encrypt('2',$Encrypt)."'</script>";
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
				$emailString = $emailString . "_ID = '" . $_POST["CustCheckbox".$i] . "' OR ";
			}
		}
	
		$emailString = substr($emailString, 0, strlen($emailString)-4);
		
		
		$str = "delete from ".$tbname."_product ";
		$str = $str . " WHERE (" . $emailString . ") ";
		mysql_query($str);
		
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='products.php?done=".encrypt('3',$Encrypt)."';</script>";
		exit();
	}
	elseif ($e_action == 'objdelete')
	{
		$sel="select * from ".$tbname."_product where _ID = ".$_REQUEST['id']."";
		$qr=mysql_query($sel);
		$rs_sel=mysql_fetch_array($qr);
		
		if(file_exists($AdminProductPicPath.$rs_sel['_Image']))
		{
			unlink($AdminProductPicPath.$rs_sel['_Image']);
		}
		$str = "UPDATE ".$tbname."_product SET _Image = '' where _ID = ".$_REQUEST['id']."";
		mysql_query($str);
	
		
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='product.php?PageNo=".encrypt($PageNo,$Encrypt)."&id=".encrypt($id,$Encrypt)."&e_action=".encrypt('edit',$Encrypt)."';</script>";
	}		
	else if($e_action == "updateorder")
	{
		$cntCheck = trim($_POST["cntCheck"]);
		
		for($i=1; $i<=$cntCheck; $i++)
		{
			$str = "UPDATE ".$tbname."_product SET ";								
				
			if($_POST["Order".$i] != "")
				$str .= "_Order = '" . replaceSpecialChar($_POST["Order".$i]) . "' ";
			else
				$str .= "_Order = null ";	
			$str .= "WHERE _ID = '" . trim($_POST["OrderID".$i]) . "' ";
			//echo $str."<br>";
			mysql_query($str);
		}
		//exit;
		
	
		include('../dbclose.php');
		echo "<script language='JavaScript'>window.location='products.php?done=".encrypt('4',$Encrypt)."';</script>";
		exit();
	}
?>
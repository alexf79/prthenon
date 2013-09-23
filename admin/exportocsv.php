<?
	ob_start();
	session_start();
	
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');	
	include('../include/functions.php');  
	
	$reportname = $_REQUEST['name'];
	
	$query = $_SESSION[$reportname];	
	
	$csv = NULL;
	
	if ($reportname == "memberslist")
	{
		$csv .= "No.,Fullname,Username,Email,Address,Country,State,City,Postal Code,HomeTel,Mobile,Fax,Register Date\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';				
				$csv .= $rs['_Fullname'].',';
				$csv .= $rs['_Username'].',';								
				$csv .= $rs['_Email'].',';
				$csv .= $rs['_Address'].',';
				
				$str2 = "SELECT * FROM ".$tbname."_country WHERE _ID = '".replaceSpecialChar($rs['_CountryID'])."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$CountryName = $rs2["_CountryName"];
				}
				$csv .= $CountryName.',';		
				$csv .= $rs['_State'].',';
				$csv .= $rs['_City'].',';											
				$csv .= $rs['_PostalCode'].',';
				$csv .= $rs['_HomeTel'].',';	
				$csv .= $rs['_Mobile'].',';
				$csv .= $rs['_Fax'].',';				
				$csv .= date('d/m/Y', strtotime($rs['_RegisterDate'])).',';				
				
				$csv .= "\n";
				$i++;
			}
		}
	}
	else if ($reportname == "orderslist")
	{
		$csv .= "No.,Order No,Order Date,Total Amount (SGD),Shipping Address,Order By,Delivery Date,Order Status\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';
				$csv .= $rs['_OrderID'].',';
				$csv .= date('d/m/Y', strtotime($rs['_OrderDate'])).',';
				$totalamt = str_replace(",","",$rs['_TotalAmt']);
				$csv .= '$ '.$totalamt.',';
				//$csv .= $rs['_ShippingAddress'].',';
				$str2 = "SELECT * FROM ".$tbname."_member WHERE _ID = '".replaceSpecialChar($rs['_MemID'])."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$Fullanme = $rs2["_Fullname"];
					$DAddress = $rs2["_DAddress"];
					$DAddress1 = $rs2["_DAddress1"];
				}
				
				$add1 = "\"" .$DAddress ;
				$add2 = $DAddress1."\"";
				
				$csv .= $add1.' '.$add2.',';	
				$csv .= $Fullanme.',';	
				$csv .= date('d/m/Y', strtotime($rs['_DeliveryDate'])).',';				
				$csv .= $rs['_OrderStatus'].',';			
  				$csv .= "\n";
				$i++;
			}
		}
	}	
	else if ($reportname == "productslist")
	{
		$csv .= "No.,Category,Sub Category,Item Code,Item Name,Description,Remarks\n";
		$result = mysql_query($query, $connect);
		if(mysql_num_rows($result) > 0)
		{
			$i = 1;
			while( $rs = mysql_fetch_assoc($result) )
			{
				$csv .= $i.',';
				$str2 = "SELECT * FROM ".$tbname."_productcat WHERE _ID = '".replaceSpecialChar($rs['_CatID'])."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$Category = $rs2["_ProdCat"];
				}
				$csv .= "\"".$Category.'",';
				$str2 = "SELECT * FROM ".$tbname."_productsubcat WHERE _ID = '".replaceSpecialChar($rs['_SubCatID'])."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$SubCategory = $rs2["_ProdSubCat"];
				}
				$csv .= "\"".$SubCategory.'",';
				$csv .= "\"".$rs['_ItemCode'].'",';
				$csv .= "\"".$rs['_ItemName'].'",';
				$csv .= "\"".$rs['_Desc'].'",';
 				$csv .= "\"".$rs['_Remarks'].'",';			
  				$csv .= "\n";
				$i++;
			}
		}
	}			
	
	include('../dbclose.php');
   
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=" . date("Y-m-d") . "_" . $reportname . ".csv;");
	header("Pragma: no-cache"); 
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Expires: 0");  
	print "$csv";
	exit;
	/*$fp = fopen($reportname.".csv", "w");	
	//$write .= substr($tmp, -1, 1) . "\r\n";
	fwrite($fp, $csv);
	fclose($fp);*/
?>
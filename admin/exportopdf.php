<?
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	include('../global.php');	
	include('../include/functions.php');  
	
	$TitleName = "";
	$Body = "";
	$reportname = $_REQUEST['name'];
		
	$query = $_SESSION[$reportname];
		
	$result = mysql_query($query, $connect);
	
	if ($reportname == "memberslist")
	{
		$theader .= '<tr>';
		$theader .= '	<td width=35 bgcolor="#D7E0F4"><b>No.</b></td>';		
		$theader .= '	<td width=90 bgcolor="#D7E0F4"><b>Fullname</b></td>';
		$theader .= '	<td width=90 bgcolor="#D7E0F4"><b>Username</b></td>';
		$theader .= '	<td width=120 bgcolor="#D7E0F4"><b>Email</b></td>';
		$theader .= '	<td width=100 bgcolor="#D7E0F4"><b>Address</b></td>';
		$theader .= '	<td width=100 bgcolor="#D7E0F4"><b>Country</b></td>';
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>State</b></td>';		
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>City</b></td>';		
		$theader .= '	<td width=100 bgcolor="#D7E0F4"><b>Postal Code</b></td>';
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>HomeTel</b></td>';
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>Mobile</b></td>';
		$theader .= '	<td width=70 bgcolor="#D7E0F4"><b>Fax</b></td>';
		$theader .= '	<td width=110 bgcolor="#D7E0F4"><b>Register Date</b></td>';
		$theader .= '</tr>';
		$TitleName = "Members List ";
	}
	else if ($reportname == "orderslist")
	{
		$theader .= '<tr>';
		$theader .= '	<td width=35 bgcolor="#CCCCCC" style="text-align:center;"><b>No.</b></td>';
		$theader .= '	<td width=100 bgcolor="#CCCCCC" style="text-align:center;"><b>Order No</b></td>';
		$theader .= '	<td width=130 bgcolor="#CCCCCC" style="text-align:center;"><b>Order Date</b></td>';
		$theader .= '	<td width=130 bgcolor="#CCCCCC" style="text-align:center;"><b>Total Amount (SGD)</b></td>';
		$theader .= '	<td width=150 bgcolor="#CCCCCC" style="text-align:center;"><b>Shipping Address</b></td>';
		$theader .= '	<td width=100 bgcolor="#CCCCCC" style="text-align:center;"><b>Order By</b></td>';
		$theader .= '	<td width=130 bgcolor="#CCCCCC" style="text-align:center;"><b>Delivery Date</b></td>';
		$theader .= '	<td width=130 bgcolor="#CCCCCC" style="text-align:center;"><b>Order Status</b></td>';
		$theader .= '</tr>';
		$TitleName = "Orders List ";
		
	}	
	
	//Body
	$Rheader = '<table width="1050" cellpadding="0" cellspacing="0" border="0">';
	$Rheader .= '<tr>';
	$Rheader .= '<td align="center"><b>First Impression</b></td>';
	$Rheader .= '</tr>';
	$Rheader .= '<tr><td height="10"></td></tr>';
	$Rheader .= '<tr>';
	$Rheader .= '<td align="center"><b>' . $TitleName . ' Report</b></td>';
	$Rheader .= '</tr>';
	$Rheader .= '</table>';

	if(mysql_num_rows($result) > 0)
	{
		$i = 1;		
		
		if ($reportname == "memberslist")
		{
			$Body .= '<table width="1050" border="1" cellspacing="1" cellpadding="2">';
			$Body .= $theader;
			$Rowcolor = "FFFFFF";
			$i=1;
			while($rs = mysql_fetch_assoc($result) )
			{
				if  ($Rowcolor == "F8F8F8")
					$Rowcolor = "FFFFFF";
				elseif ($Rowcolor == "FFFFFF")
					$Rowcolor = "F8F8F8";	
				$Body .= '<tr>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">'.$i.'</td>';			
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Fullname'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Username'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Email'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Address'] . '&nbsp;</td>';
				$str2 = "SELECT * FROM ".$tbname."_country WHERE _ID = '".$rs['_CountryID']."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$CountryName = $rs2["_CountryName"];
				}
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $CountryName . '&nbsp;</td>';			
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_State'] . '&nbsp;</td>';				
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_City'] . '&nbsp;</td>';				
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_PostalCode'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_HomeTel'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Mobile'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $rs['_Fax'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . date('d/m/Y', strtotime($rs['_RegisterDate'])) . '&nbsp;</td>';								
				$Body .= '</tr>';	
				$i++;		
			}
			$Body .= '</table>';
		}
		else if ($reportname == "orderslist")
		{
			$Body .= '<table width="1050" border="1" cellspacing="1" cellpadding="2">';
			$Body .= $theader;
			$Rowcolor = "FFFFFF";
			$i=1;			
			while($rs = mysql_fetch_assoc($result) )
			{
				if  ($Rowcolor == "F8F8F8")
					$Rowcolor = "FFFFFF";
				elseif ($Rowcolor == "FFFFFF")
					$Rowcolor = "F8F8F8";	
				$Body .= '<tr>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'"  style="text-align:center;">'.$i.'</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'"  style="text-align:center;">' . $rs['_OrderID'] . '&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'"  style="text-align:center;">' . date('d/m/Y', strtotime($rs['_OrderDate'])) . '&nbsp;</td>';		
				$Body .= '	<td bgcolor="#'.$Rowcolor.'"  style="text-align:right;">' . '$ '.$rs['_TotalAmt'] . '&nbsp;</td>';				
				$str2 = "SELECT * FROM ".$tbname."_member WHERE _ID = '".$rs['_MemID']."' ";
				$rst2 = mysql_query($str2, $connect) or die(mysql_error());
				if(mysql_num_rows($rst2) > 0)
				{
					$rs2 = mysql_fetch_assoc($rst2);
					$Fullname = $rs2["_Fullname"];
					$DAddress = $rs2["_DAddress"];
					$DAddress1 = $rs2["_DAddress1"];
				}
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $DAddress . '<br />'.$DAddress1.'&nbsp;</td>';
				$Body .= '	<td bgcolor="#'.$Rowcolor.'">' . $Fullname . '&nbsp;</td>';	
				$Body .= '	<td bgcolor="#'.$Rowcolor.'" style="text-align:center;">' . date('d/m/Y', strtotime($rs['_DeliveryDate'])) . '&nbsp;</td>';		
				$Body .= '	<td bgcolor="#'.$Rowcolor.'"  style="text-align:center;">' . $rs['_OrderStatus'] . '&nbsp;</td>';		
				$Body .= '</tr>';	
				$i++;
			}
			$Body .= '</table>';
			
		}					
	}
	
	$html = $Rheader.$Body;
	
	$pdf_filename = str_replace("/", "_",  date("Y-m-d") . "_" . $reportname  ) . ".pdf";
	$pdf_filepath = $pdf_filename;	
	
	include("mpdf/mpdf.php");

	$mpdf=new mPDF('en-GB','A4','','',10,10,25,25,16,13); 
	
	$mpdf->useOnlyCoreFonts = true;
	
	$mpdf->SetDisplayMode('fullpage');
	
	$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list
	
	// LOAD a stylesheet
	$stylesheet = file_get_contents('mpdfstyletables.css');
	$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
	$mpdf->SetHeader('{PAGENO}');
	$mpdf->SetFooter('First Impression ('.$TitleName.' Report)||'.date("d-M-Y").'');
	$mpdf->WriteHTML($html,2);
	
	$mpdf->Output($pdf_filepath,'D');
	exit;
		
	include('../dbclose.php');
?>
<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script type='text/javascript' language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php');  	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $appname; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />	
	<script type="text/javascript" src="../js/validate.js"></script>
    <link type="text/css" href="../jquery/css/smoothness/jquery-ui-1.8.5.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="../jquery/development-bundle/jquery-1.4.2.js"></script>
    <script type="text/javascript" src="../jquery/development-bundle/ui/jquery.ui.core.js"></script>
    <script type="text/javascript" src="../jquery/development-bundle/ui/jquery.ui.widget.js"></script>
    <script type="text/javascript"  src="../jquery/development-bundle/ui/jquery.ui.datepicker.js"></script> 
	<script type="text/javascript" language="javascript">
		<!--
		function validateForm()
		{			
			var errormsg;
			errormsg = "";
			//alert(document.FormName.To.value); return false;
			var df = document.FormName.From.value;
			var dt = document.FormName.To.value;
			
			if(df != "" || df != "DD/MM/YYYY" && dt != "" || dt != "DD/MM/YYYY")
			{			
				if(df > dt)
				{
					errormsg += "'From Date' should be earlier than 'To Date'.\n";
				}
			}
			//if(document.FormName.NewName.value=="" && (document.FormName.FromDay.value=="" || document.FormName.FromMth.value=="" || document.FormName.FromYr.value=="" || document.FormName.ToDay.value=="" || document.FormName.ToMth.value=="" || document.FormName.ToYr.value=="") && document.FormName.Status1.checked==false && document.FormName.Status2.checked==false)
				//{
				//	errormsg += "Please fill in at least 1 of the blanks.\n";
				// }				
			
			if ((errormsg == null) || (errormsg == ""))
			{
				return true;
			}
			else
			{
				alert(errormsg);
				return false;
			}
		}
		function validateForm3()
		{
			if(checkSelected('CustCheckbox', document.FormName.cntCheck.value) == false)
			{
				alert("Please select at least one checkbox.");
				document.FormName.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to delete the selected Promotion(s)?') == true)
				{
					document.forms.FormName.action = "promotionaction.php";
					document.forms.FormName.submit();
				}
			}
		}

		function checkSelected(msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document.FormName." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document.FormName." + msgtype + i + ".checked") == true)
					{
						return true;
					}
				}
			}
			return false;
		}
		
		function CheckUnChecked(msgType, count, chkbxName)
		{
			if (chkbxName.checked==true)
			{
				for (var i = 1; i<=count; i++)
				{
					 eval("document.FormName."+msgType+i+".checked = true");
					 for(var j=1;j<=7;j++)
					 {
						//document.getElementById('Row'+j+'ID'+i).className='gridline3'; // Cross-browser
					 }
				}
				
			}
			else
			{
				var rowcolor ='gridline1';
				for (var i = 1; i<=count; i++)
				{
					 eval("document.FormName."+msgType+i+".checked = false");
					 if(rowcolor=='gridline2')
					 {
						 rowcolor='gridline1';
					 }
					 else
					 {
						  rowcolor='gridline2';
					 }
					 for(var j=1;j<=7;j++)
					 {
						
						//document.getElementById('Row'+j+'ID'+i).className=rowcolor; // Cross-browser
					 }
				}
			}
		}
		
		function setActivities(fromfield,rowid,rowcolor) { 
			
			if(fromfield.checked == true)
			{				
				for(var i=1;i<=7;i++)
				{
					//document.getElementById('Row'+i+'ID'+rowid).className='gridline3'; // Cross-browser
				}
			}
			else
			{
				for(var i=1;i<=7;i++)
				{
					//document.getElementById('Row'+i+'ID'+rowid).className=rowcolor; // Cross-browser
				}
			}
		}
		
		$(function(){
			$('.datepicker').datepicker({
				changeDate: true,
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd/mm/yy',
				yearRange: '1900:+0'
			});			
		});
		
		/* START CODE FOR RESET COLOR ON CLEAR SELECTION */
		function setColorReset(){
			for(var i = 1; i <= document.FormName.cntCheck.value; i++ ){
				for(var j = 1; j <= 7; j++)
				{
					if(i%2 == 1)
						document.getElementById('Row'+j+'ID'+i).className='gridline2'; // Cross-browser
					else
						document.getElementById('Row'+j+'ID'+i).className='gridline1'; // Cross-browser
				}
			}			
		}
		/* END CODE FOR RESET COLOR ON CLEAR SELECTION */
		
		//-->
	</script>
</head>
<body>
	<table align="left" width="1000" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		<tr>
			<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr><td height="10" bgcolor="#C1DEFE"></td></tr>
					<tr>
						<td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
					</tr>
					<tr><td height="10" bgcolor="#C1DEFE"></td></tr>
					<tr>
						<td width="150" align="left" valign="top" bgcolor="#C1DEFE"><?php include('left.php'); ?></td>
						<td width="850" align="left" style="padding-left:5px;" valign="top">															
						<!--
						Start Contact
						-->
							<table cellpadding="0" cellspacing="0" border="0" width="840">
								<tr>
								  <td align="left" class="TitleStyle"><b><?php							 
									if ($_GET["SearchBy"] == "SearchBy1")
									{
									?>Search Promotion<?php 
									} 
									else 
									{ ?>
									Promotion List 
									<?php } ?></b></td>
								</tr>
								<tr><td height=""></td></tr>
							</table>
							<?php
							if ($_GET["done"] == 1)
							{
								echo "<div align='left'><font color='#FF0000'>Promotion has been added successfully.<br></font></div>";
							}
							if ($_GET["done"] == 2)
							{
								echo "<div align='left'><font color='#FF0000'>Promotion has been edited successfully.<br></font></div>";
							}
							if ($_GET["done"] == 3)
							{
								echo "<div align='left'><font color='#FF0000'>Promotion has been deleted successfully.<br></font></div>";
							}
							if ($_GET["error"] == 1)
							{
																
							}
							?>
							<br />
							<div>
							<?php							 
							if ($_GET["SearchBy"] == "SearchBy1") {
							?>
								<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
								<td>
								<table>
									<form name="FormName1" method="get" action="promotions.php">
										<input type="hidden" name="SearchBy" value="" />
										<tr>
											<td width="97">&nbsp;<b>Search By</b></td>
											<td width="10">:</td>
											<td width="731"><input type="submit" name="Submit" value="List All" class="button1" /></td>
										</tr>
										<tr><td height="10"></td></tr>
									</form>
								</table>
								</td>
								</tr>
								<tr>
								<td>
								<table>
									<form name="FormName" method="get" action="promotions.php" onsubmit="return validateForm();">
									<input type="hidden" name="SearchBy" value="SearchBy" />
                                    <tr><td height="5"></td></tr>
                                    <tr><td>&nbsp;<b>Or </b></td></tr>
                                    <tr>
                                        <td width="97">&nbsp;Promotion Name</td>
                                        <td width="10">:</td>
                                        <td width="731">
                                            <input type="text" autocomplete="off" id="PromotionName" name="PromotionName" value="" style="width:191px;" class="txtbox1" />
										</td>
									</tr>
									<tr>
                                    	<td width="92">&nbsp;From Date</td>
										<td width="10">:</td> 	
                                        <td>
                                        	<input id="From"  name="From" autocomplete="off" size="10" class="datepicker" value="<?=($_GET['From']!="" ? $_GET['From'] : "DD/MM/YYYY")?>" style="font-family: Arial; font-size: 11px; margin-top:2px;" readonly="readonly"/>    
                                        &nbsp;&nbsp;To&nbsp;&nbsp;: 
                                        
                                        	<input id="To"  name="To" type="text" autocomplete="off" size="10" class="datepicker" value="<?=($_GET['To']!="" ? $_GET['To'] : "DD/MM/YYYY")?>" style="font-family: Arial; font-size: 11px; margin-top:2px;" readonly="readonly"/>
                                        </td>
                                    </tr>
			
                                   <tr>	                                    	
                                      <table>
										<tr>
											<td width="97">&nbsp;Status</td>
											<td width="5">:</td>
											<td width="731">
												<input name="Status1" type="checkbox" value="S" />Show&nbsp;&nbsp;&nbsp;
												<input name="Status2" type="checkbox" value="H" />Hide&nbsp;&nbsp;&nbsp;   
											</td>
										</tr>		
										<tr><td height="10"></td></tr>		
										<tr>
											<td></td>
											<td></td>
											<td><input name="btnBack" type="button" class="button1" id="btnBack" value="&lt;&lt; Back" onclick="window.location='promotions.php'" />&nbsp;<input type="submit" class="button1" name="btnSearch" value="Search" />&nbsp;<input type="reset" class="button1" name="btnReset" value="Clear All" /></td>
										</tr>                                    
									</table>
									</td>
									</tr>
									</form>
                                </table>                              
							<?php
							}
                            if ($_GET["SearchBy"] == "" || $_GET["SearchBy"]  == "SearchBy") {
								$sortBy = trim($_GET["sortBy"]);
								$sortArrange = trim($_GET["sortArrange"]);
							
							if ($_GET["SearchBy"] == "SearchBy") {								
								$PromotionName = trim($_GET["PromotionName"]);
								$EventName = trim($_GET["EventName"]);
								if($_GET["From"]!="DD/MM/YYYY" && $_GET["To"]!="DD/MM/YYYY")
								{
									$TmpDay1 = explode('/',$_GET["From"]);
									$TmpDay2 = explode('/',$_GET["To"]);
									$FromDay = trim($TmpDay1[0]);
									$FromMth = trim($TmpDay1[1]);
									$FromYr = trim($TmpDay1[2]);
									$ToDay = trim($TmpDay2[0]);
									$ToMth = trim($TmpDay2[1]);
									$ToYr = trim($TmpDay2[2]);
									if($FromDay <> "" && $FromMth <> "" &&  $FromYr <> "")
									{
									$FromDate = $FromYr . "-" . $FromMth . "-" . $FromDay . " 00:00:00";
									}else
									{
									$ToDate = "";
									}
									if($ToDay <> "" && $ToMth <> "" &&  $ToYr <> "")
									{
									$ToDate = $ToYr . "-" . $ToMth . "-" . $ToDay . " 23:59:59";
									}else
									{
									$ToDate = "";
									}
								}
								
								$StatusString = "";
								$StatusPageString = "";
								$StatusCheckedBox = "No";
								for($i=1; $i<=2; $i++)
								{
									if(trim($_GET["Status".$i]) != "" && trim($_GET["Status".$i]) == "S")
									{
										$StatusString = $StatusString . "_Status = '" . trim($_GET["Status".$i]) . "' OR ";
										$StatusCheckedBox = "Yes";
									}
									else if(trim($_GET["Status".$i]) != "" && trim($_GET["Status".$i]) == "H")
									{
										$StatusString = $StatusString . "_Status = '" . trim($_GET["Status".$i]) . "' OR ";
										$StatusCheckedBox = "Yes";
									}
									$StatusPageString = $StatusPageString . "&Status" . $i . "=" . trim($_GET["Status".$i]);
								}
								
													
								
								if($StatusCheckedBox == "Yes")
								{
									$StatusString = substr($StatusString, 0, strlen($StatusString)-4);
								}	
							}							
							//Set the page size
							$PageSize = 30;
							$StartRow = 0;
							
							//Set the page no
							if(empty($_GET['PageNo']))
							{
								if($StartRow == 0)
								{
									$PageNo = $StartRow + 1;
								}
							}
							else
							{
								$PageNo = $_GET['PageNo'];
								$StartRow = ($PageNo - 1) * $PageSize;
							}
							
							//Set the counter start


							if($PageNo % $PageSize == 0)
							{
								$CounterStart = $PageNo - ($PageSize - 1);
							}
							else

							{
								$CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
							}
							
							//Counter End
							$CounterEnd = $CounterStart + ($PageSize - 1);

							$i = 1;
							$Rowcolor = "gridline1";
							
							if ($_GET["SearchBy"] == "SearchBy") {
								$str1 = "SELECT * FROM " . $tbname . "_promotion WHERE _ID IS NOT NULL ";		
												
								if ($PromotionName != "") {
									$str1 = $str1 . "AND _PromotionName LIKE '%" . replaceSpecialChar($PromotionName) . "%' ";
								}	
								if ($FromDate != "" && $ToDate != "")
								{
									$str1 = $str1 . "AND _PublishDate >= '".replaceSpecialChar($FromDate)."' AND _PublishDate <= '".replaceSpecialChar($ToDate)."' ";
								}							
								if ($StatusString != "")
								{
									$str1 = $str1 . "AND (".$StatusString.") ";
								}
								
								$str2 = $str1;
								if (trim($sortBy) != "" && trim($sortArrange) != "") {
									$str2 = $str2 . "ORDER BY " . trim($sortBy) . " " . trim($sortArrange) . " LIMIT $StartRow,$PageSize ";
								} else {
									$str2 = $str2 . "ORDER BY _PromotionName LIMIT $StartRow,$PageSize ";
								}
							}
	
							if ($_GET["SearchBy"] == "") {
							$str1 = "SELECT * FROM ".$tbname."_promotion ";																
							
							//$str2 = $str1 . "ORDER BY _Currencies LIMIT $StartRow,$PageSize ";

							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . "ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . "ORDER BY _PromotionName LIMIT $StartRow,$PageSize ";
							}
							
							$TRecord = mysql_query($str1, $connect);
							$result = mysql_query($str2, $connect);
							
							//Total of record
							$RecordCount = mysql_num_rows($TRecord);
							
							//Set Maximum Page
							$MaxPage = $RecordCount % $PageSize;
							if($RecordCount % $PageSize == 0)
							{
								$MaxPage = $RecordCount / $PageSize;
							}
							else
							{
								$MaxPage = ceil($RecordCount / $PageSize);
							}
							
							?>
							
							<?php
								//if($RecordCount > 0){
								
								
								if ($RecordCount == 0) {
									$PageNo = 0;
								}
									?>
									<form name="FormName" action="" method="post">
											<input type="hidden" name="e_action" value="delete" />
									<table cellpadding="0" cellspacing="0" border="0" width="840">
										<tr>
											<td colspan="2"><div align="right"><?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?></div></td>
                                        </tr>
										<tr>
											<td colspan="2">
											<?php if($RecordCount > 0){ ?>
											Page :
											<?php
												$QureyUrl = "&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange."";
												if($MaxPage > 1) echo "Page: ";
												for ($i=1; $i<=$MaxPage; $i++)
												{
													if ($i == $PageNo)
													{
														print "<a href='?PageNo=". $i . $QureyUrl ."' class='menulink'>[".$i."]</a> ";
													}
													else
													{
														print "<a href='?PageNo=" . $i . $QureyUrl ."' class='menulink'>".$i."</a> ";
													}
												}

											if (trim($sortArrange) == "DESC")
												$sortArrange = "ASC";
											elseif (trim($sortArrange) == "ASC")
												$sortArrange = "DESC";
											else
												$sortArrange = "DESC";
											?>
											<?php } ?>
											</td>
										</tr>										
										<tr><td colspan="2" height="5"></td></tr>
										<tr>
											<td align="left">
											<?php if($RecordCount > 0){ ?>
												<!-- <input type="button" class="button1" name="btnBack" value="< Back" onclick="javascript:history.back();">&nbsp; -->
												<input type="button" class="button1" name="btnSubmit2" value="Delete Promotions" onclick="return validateForm3();" style="width:100px;" />&nbsp;
												<input type="reset" class="button1" name="btnReset2" value="Clear Selection" onclick="setColorReset();" style="width:100px;" />
											<?php } ?>	
											</td>
											<td align="right">									
												<a href="promotion.php" class="TitleLink">Add Promotion</a> | <a href="promotions.php?SearchBy=SearchBy1" class="TitleLink">Promotion Search</a>									
											</td>
										</tr>
										<tr><td colspan="2" height="5"></td></tr>
										<tr>
											<td colspan="2">
												<table cellspacing="1" cellpadding="2" width="100%" border="0" class="grid" >
													<tr>
														<td class="gridheader" width="30" align="center"><input name="AllCheckbox" type="checkbox" value="All" onclick="CheckUnChecked('CustCheckbox',document.FormName.cntCheck.value,this);" /></td>
														<td class="gridheader" width="30" align="center">No.</td>
														<td class="gridheader" width="20%" align="center">&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_PromotionName&amp;sortArrange=<?=$sortArrange?>&amp;SearchBy=<?php echo $_GET['SearchBy']; ?>&amp;PromotionName=<?php echo $_GET['PromotionName']; ?>&amp;From=<?php echo $_GET['From']; ?>&amp;To=<?php echo $_GET['To']; ?>&amp;Status1=<?php echo $_GET['Status1']; ?>&amp;Status2=<?php echo $_GET['Status2']; ?>" class="link1"><u>Promotion Name</u></a></td>
														<td class="gridheader" width="13%" align="center" >&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_PublishDate&amp;sortArrange=<?=$sortArrange?>&amp;SearchBy=<?php echo $_GET['SearchBy']; ?>&amp;PromotionName=<?php echo $_GET['PromotionName']; ?>&amp;From=<?php echo $_GET['From']; ?>&amp;To=<?php echo $_GET['To']; ?>&amp;Status1=<?php echo $_GET['Status1']; ?>&amp;Status2=<?php echo $_GET['Status2']; ?>" class="link1"><u>Publish Date</u></a></td>	
														<td class="gridheader" width="45%" align="center" >&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_BriefInfo&amp;sortArrange=<?=$sortArrange?>&amp;SearchBy=<?php echo $_GET['SearchBy']; ?>&amp;PromotionName=<?php echo $_GET['PromotionName']; ?>&amp;From=<?php echo $_GET['From']; ?>&amp;To=<?php echo $_GET['To']; ?>&amp;Status1=<?php echo $_GET['Status1']; ?>&amp;Status2=<?php echo $_GET['Status2']; ?>" class="link1"><u>Brief Info</u></a></td>											
														<td class="gridheader" width="7%" align="center" >&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Status&amp;sortArrange=<?=$sortArrange?>&amp;SearchBy=<?php echo $_GET['SearchBy']; ?>&amp;PromotionName=<?php echo $_GET['PromotionName']; ?>&amp;From=<?php echo $_GET['From']; ?>&amp;To=<?php echo $_GET['To'];?>&amp;Status1=<?php echo $_GET['Status1']; ?>&amp;Status2=<?php echo $_GET['Status2']; ?>" class="link1"><u>Status</u></a></td>
														<td class="gridheader"  align="center">Edit</td>
														<!-- 
														<td class="gridheader" width="30" align="center"><input name="AllCheckbox" type="checkbox" value="All" onclick="CheckUnChecked('CustCheckbox',document.FormName.cntCheck.value,this);" /></td>
														<td class="gridheader" width="30" align="center">No.</td>
														<td class="gridheader" width="300" align="center">&amp;nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_NewName&amp;amp;sortArrange=<?=$sortArrange?>" class="link1"><u>News Name</u></a></td>
														<td class="gridheader" width="150" align="center" >&nbsp;<a href="?PageNo=<?=$PageNo?>&sortBy=_PublishDate&amp;sortArrange=<?=$sortArrange?>" class="link1"><u>Publish Date</u></a></td>	
														<td class="gridheader" width="250" align="center" >&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_BriefInfo&amp;sortArrange=<?=$sortArrange?>" class="link1"><u>Brief Info</u></a></td>											
														<td class="gridheader" width="100" align="center" >&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=_Status&amp;sortArrange=<?=$sortArrange?>" class="link1"><u>Status</u></a></td>
														<td class="gridheader" width="60" align="center">Edit</td>	
														-->
													</tr>
													<?php
													if ($RecordCount > 0) {
													$i = 1;											
													while($rs = mysql_fetch_assoc($result))
													{
														$bil = $i + ($PageNo-1)*$PageSize;	
														if  ($Rowcolor == "gridline2")
															$Rowcolor = "gridline1";
														else
															$Rowcolor = "gridline2";
															
														 if ($id == $rs["_ID"]) {
																$Rowcolor = "gridline3";
															}	
														?>
														<tr >
															<td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="30" align="center" valign="top">
															  <input name="CustCheckbox<?php echo $i; ?>" type="checkbox" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>');"/>
															</td>
															<td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" valign="top">&nbsp;<?php echo $bil; ?>&nbsp;</td>
															<td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" valign="top">&nbsp;<?=$rs["_PromotionName"]?>&nbsp;</td>
															<td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" valign="top">&nbsp;<? if($rs["_PublishDate"]!=""){?><?=date("d-M-Y", strtotime($rs["_PublishDate"]))?><? } ?>&nbsp;</td>	
															<td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left" valign="top">&nbsp;<?=$rs["_BriefInfo"]?>&nbsp;</td>																								
															<td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" valign="top">&nbsp;<?=($rs["_Status"]=="S") ? "Show" : "Hide" ?>&nbsp;</td>
															<td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" valign="top">&nbsp;<a href="promotion.php?PageNo=<?=$PageNo?>&amp;id=<?=$rs["_ID"]?>&amp;e_action=edit" class="TitleLink">Edit</a>&nbsp;</td>
														</tr>
														<?php
														$i++;
														}
													} else {
														echo "<tr><td colspan='6' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
																}
													?>
												</table>
											</td>
										</tr>
										<tr><td colspan="2" height="5"></td></tr>
										<tr>
											<td align="left"><!--<input type="button" class="button1" name="btnBack" value="< Back" onClick="javascript:history.back();">&nbsp;-->
											<?php if($RecordCount > 0){ ?>
											<input type="button" class="button1" name="btnSubmit2" value="Delete Promotion" onclick="return validateForm3();" style="width:100px;" />&nbsp;
											<input type="reset" class="button1" name="btnReset2" value="Clear Selection" onclick="setColorReset();" style="width:100px;" />
											<?php } ?>
											</td>												
											<td align="right">
												<a href="promotion.php" class="TitleLink">Add Promotion</a> | <a href="promotions.php?SearchBy=SearchBy1" class="TitleLink">Promotion Search</a>											
											</td>
										</tr>										
										<tr><td colspan="2" height="5"><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td></tr>
										<tr>
											<td colspan="2">
											<?php if($RecordCount > 0){ ?>
											Page :
											<?php
												if($MaxPage > 1) echo "Page: ";
												for ($i=1; $i<=$MaxPage; $i++)
												{
													if ($i == $PageNo)
													{
														print "<a href='?PageNo=". $i . $QureyUrl ."' class='menulink'>[".$i."]</a> ";
													}
													else
													{
														print "<a href='?PageNo=" . $i . $QureyUrl ."' class='menulink'>".$i."</a> ";
													}
												}
											?>
											</td>
											<?php } ?>
										</tr>										
									</table>
									</form>
									<?php
								//}
								//else{
									//?>
										<!-- <table cellpadding="0" cellspacing="0" border="0" width="840">
											<tr><td colspan="2" height="5"></td></tr>
											<tr>
												<td align="left">
													&nbsp;
												 <input type="button" class="button1" name="btnBack" value="< Back" onClick="javascript:history.back();">&nbsp;
													<input type="button" class="button1" name="btnSubmit2" value="Delete News" onclick="return validateForm3();" style="width:100px;">&nbsp;<input type="reset" class="button1" name="btnReset2" value="Clear Selection" style="width:100px;" />  
											 </td>
												<td align="right">									
													<a href="new.php" class="TitleLink">Add News</a> | <a href="news.php?SearchBy=SearchBy1" class="TitleLink">News Search</a>									
												</td>
											</tr>
											<tr><td colspan='6' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>											
										</table> -->
									<?php
								//}
							?>
																			
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
<?php		
include('../dbclose.php');
}
?>
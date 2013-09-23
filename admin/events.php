<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script type='text/javascript' language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php'); 
	
	
	if(isset($_GET['srch']) &&  $_GET['srch'] == 1)
	{
		foreach($_GET as $k=>$v)
		{
		   $_GET[$k] = encrypt($v,$Encrypt);
		}
		foreach($_REQUEST as $k=>$v)
		{
		   $_REQUEST[$k] = encrypt($v,$Encrypt);
		}
		foreach($_POST as $k=>$v)
		{
		   $_POST[$k] = encrypt($v,$Encrypt);
		}
	} 
	
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
	<script type="text/javascript" language="javascript" >
		<!--
		function validateForm()
		{			
			var errormsg;
			errormsg = "";
			//alert(document.FormName.To.value); return false;
			var df = document.FormNameNew.From.value;
			var dt = document.FormNameNew.To.value;
			
			if(df != "" || df != "DD/MM/YYYY" && dt != "" || dt != "DD/MM/YYYY")
			{			
				if(df > dt)
				{
					errormsg += "'From Date' should be earlier than 'To Date'.\n";
				}
			}
			//if(document.FormNameNew.NewName.value=="" && (document.FormNameNew.FromDay.value=="" || document.FormNameNew.FromMth.value=="" || document.FormName.FromYr.value=="" || document.FormName.ToDay.value=="" || document.FormNameNew.ToMth.value=="" || document.FormName.ToYr.value=="") && document.FormNameNew.Status1.checked==false && document.FormNameNew.Status2.checked==false)
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
				if(confirm('Are you sure you want to delete the selected Event(s)?') == true)
				{					
					document.forms.FormName.action = "eventaction.php";
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
					// document.getElementById('Row'+i+'ID'+rowid).className=rowcolor; // Cross-browser
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
									?>Search Event<?php 
									} 
									else 
									{ ?>
									Event List 
									<?php } ?></b></td>
								</tr>
								<tr><td height=""></td></tr>
							</table>
							<?php
							if ($_GET["done"] == 1)
							{
								echo "<div align='left'><font color='#FF0000'>Events has been added successfully.<br></font></div>";
							}
							if ($_GET["done"] == 2)
							{
								echo "<div align='left'><font color='#FF0000'>Events has been edited successfully.<br></font></div>";
							}
							if ($_GET["done"] == 3)
							{
								echo "<div align='left'><font color='#FF0000'>Events has been deleted successfully.<br></font></div>";
							}
							if ($_GET["error"] == 1)
							{
																
							}
							?>
							<br />
							<div>
							<?php							 
							 //if ($_GET["SearchBy"] == "SearchBy1") 
							{
							?>
								<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
								<td>
								<form name="FormName1" method="get" action="events.php">
								<input type="hidden" name="SearchBy" value="" />
								<input type="hidden" value="1" name="srch" />
								<table cellspacing="0" cellpadding="0">									
										<tr>
											<td width="97"><b>Search By</b></td>
											<td width="10">:</td>
											<td width="731"><input type="submit" name="Submit" value="List All" class="button1" /></td></tr>
										
								</table>
								</form>
								</td>
								</tr>
								<tr>
								<td>
								<form name="FormNameNew" method="get" action="events.php" onsubmit="return validateForm();">
									<input type="hidden" name="SearchBy" value="SearchBy" />
									<input type="hidden" value="1" name="srch" />
								<table cellspacing="0" cellpadding="0">									
                                    <tr><td><b>Or </b></td></tr>
                                    <tr>
                                        <td width="97">Event Name</td>
                                        <td width="10">:</td>
                                        <td width="731">
                                            <input type="text" autocomplete="off" id="EventName" name="EventName" value="" style="width:192px;" class="txtbox1" />
										</td>
									</tr>
									<tr><td height="10"></td></tr>	
                                    <tr>
                                    	<td width="92">From Date</td>
										<td width="10">:</td> 	
                                        <td>
                                        	<input id="From"  name="From" type="text" autocomplete="off" size="10" class="datepicker" value="<?=($_GET['From']!="" ? $_GET['From'] : "DD/MM/YYYY")?>" style="font-family: Arial; font-size: 11px; margin-top:2px;" readonly="readonly"/>    
                                        &nbsp;&nbsp;To&nbsp;&nbsp;:&nbsp; 
                                        
                                        	<input id="To"  name="To" type="text" autocomplete="off" size="10" class="datepicker" value="<?=($_GET['To']!="" ? $_GET['To'] : "DD/MM/YYYY")?>" style="font-family: Arial; font-size: 11px; margin-top:2px;" readonly="readonly"/>
                                        </td>
                                    </tr>    
									<tr><td height="10"></td></tr>		
									<?php
									//if ($_GET["SearchBy"] == "SearchBy1") 
									{
									?>
                                    <tr>
                                        <td width="92">Status</td>
                                        <td width="10">:</td>
                                        <td width="731">
                                        	<input name="Status1" type="checkbox" value="S" />Show&nbsp;&nbsp;&nbsp;
											<input name="Status2" type="checkbox" value="H" />Hide&nbsp;&nbsp;&nbsp;   
                                        </td>
                               		</tr>	
									<?php } ?>	
									<tr><td height="10"></td></tr>										
                                    <tr>
										<td></td>
										<td></td>
										<td><?php if ($_GET["SearchBy"] == "SearchBy1"){ ?><input name="btnBack" type="button" class="button1" id="btnBack" value="&lt;&lt; Back" onclick="window.location='events.php'" />&nbsp;<?php } ?><input type="submit" class="button1" name="btnSearch" value="Search" />&nbsp; <input type="reset" class="button1" name="btnReset" value="Clear All" /></td>
									</tr>                                    
									</table>
									</form>
									</td>
									</tr>	
                                </table>   
                             <?php if ($_GET["SearchBy"] == "SearchBy1")								
							  { ?>
								</div>
								</td>
							   </tr>
							 </table>
							</td>
						   </tr>
						  </table>
						  </body>
						  </html>
						  <?php }?>
							<?php
							}
                            if ($_GET["SearchBy"] == "" || $_GET["SearchBy"]  == "SearchBy") {
								$sortBy = trim($_GET["sortBy"]);
								$sortArrange = trim($_GET["sortArrange"]);
							
							if ($_GET["SearchBy"] == "SearchBy") {								
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
									$StatusPageString = $StatusPageString . "&amp;Status" . $i . "=" . trim($_GET["Status".$i]);
								}
								if($StatusCheckedBox == "Yes")
								{
									$StatusString = substr($StatusString, 0, strlen($StatusString)-4);
								}	
							}	
							
							$urlString = "&amp;EventName=".encrypt($EventName,$Encrypt)."&amp;From=".encrypt($_GET["From"],$Encrypt)."&amp;To=".encrypt($_GET["To"],$Encrypt)."&amp;Status1=".encrypt($_GET["Status1"],$Encrypt)."&amp;Status2=".encrypt($_GET["Status1"],$Encrypt)."&amp;SearchBy=".encrypt('SearchBy',$Encrypt)."";								
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
								$str1 = "SELECT * FROM " . $tbname . "_events WHERE _ID IS NOT NULL ";		
												
								if ($EventName != "") {
									$str1 = $str1 . "AND _EventName LIKE '%" . replaceSpecialChar($EventName) . "%' ";
								}	
								if ($FromDate != "" && $ToDate != "")
								{
									$str1 = $str1 . "AND _EventDate >= '".$FromDate."' AND _EventDate <= '".$ToDate."' ";
								}							
								if ($StatusString != "")
								{
									$str1 = $str1 . "AND (".$StatusString.") ";
								}
								$str2 = $str1;
								if (trim($sortBy) != "" && trim($sortArrange) != "") {
									$str2 = $str2 . "ORDER BY " . trim($sortBy) . " " . trim($sortArrange) . " LIMIT $StartRow,$PageSize ";
								} else {
									$str2 = $str2 . "ORDER BY _EventName LIMIT $StartRow,$PageSize ";
								}
							}
	
							
							
							if ($_GET["SearchBy"] == "") {
							$str1 = "SELECT * FROM ".$tbname."_events ";																
							
							//$str2 = $str1 . "ORDER BY _Currencies LIMIT $StartRow,$PageSize ";

							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . "ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . "ORDER BY _EventName LIMIT $StartRow,$PageSize ";
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
								//if ($RecordCount > 0) {
								if ($RecordCount == 0) {
									$PageNo = 0;
								}
								
							?>
							<form name="FormName" action="" method="post">
									<input type="hidden" name="e_action" value="<?=encrypt('delete',$Encrypt)?>" />
							<table cellpadding="0" cellspacing="0" border="0" width="840">								
								<!-- <tr>
									<td colspan="2"><div align="right"><?php print "$RecordCount record(s) - You are at page $PageNo  of $MaxPage"; ?></div></td>
                                </tr> --->
								<tr>
									<td >
									<?php if($RecordCount > 0){ ?>
									
 									<?php
										$QureyUrl = "&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange.$urlString."";
										//if($MaxPage > 1) echo "Page: ";
										 echo "Page: ";
										for ($i=1; $i<=$MaxPage; $i++)
										{
											if ($i == $PageNo)
											{
												print "<a href='?PageNo=". $i . $urlString ."' class='menulink'>[".$i."]</a> ";
											}
											else
											{
												print "<a href='?PageNo=" . $i . $urlString ."' class='menulink'>".$i."</a> ";
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
									<td align="right">
									  <?php print "$RecordCount record(s) - You are at page $PageNo  of $MaxPage"; ?>								
									</td>
								</tr>								
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td align="left"><!--<input type="button" class="button1" name="btnBack" value="< Back" onClick="javascript:history.back();" />&nbsp;-->
									<?php if($RecordCount > 0){ ?>
										<input type="button" class="button1" name="btnSubmit2" value="Delete Events" onclick="return validateForm3();" style="width:100px;" />&nbsp;
										<input type="reset" class="button1" name="btnReset2" onclick="setColorReset();" value="Clear Selection" style="width:100px;"  />
									<?php } ?>	
									</td>
									<td align="right">									
                                    	<a href="event.php" class="TitleLink">Add Event</a> | <a href="events.php?SearchBy=SearchBy1" class="TitleLink">New Search</a>									
									</td>
								</tr>
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2">
										<table cellspacing="1" cellpadding="2" width="100%" border="0" class="grid" >
											<tr>
												<td class="gridheader" width="3%" align="center"><input name="AllCheckbox" type="checkbox" value="All" onclick="CheckUnChecked('CustCheckbox',document.FormName.cntCheck.value,this);" /></td>
												<td class="gridheader" width="3%" align="center">No.</td>
												<td class="gridheader" width="24%" align="center">&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=<?=encrypt('_EventName',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?><?=$urlString?>" class="link1"><u>Event Name</u></a></td>
												<td class="gridheader" width="10%" align="center">&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=<?=encrypt('_EventDate',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?><?=$urlString?>" class="link1"><u>Event Date</u></a></td>	
                        <td class="gridheader" width="50%" align="center">&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=<?=encrypt('_BriefInfo',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?><?=$urlString?>" class="link1"><u>Brief Info</u></a></td>											
												<td class="gridheader" width="5%" align="center">&nbsp;<a href="?PageNo=<?=$PageNo?>&amp;sortBy=<?=encrypt('_Status',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?><?=$urlString?>" class="link1"><u>Status</u></a></td>
												<td class="gridheader" width="5%" align="center">Edit</td>
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
													<td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="30" align="center">
													  <input name="CustCheckbox<?php echo $i; ?>" type="checkbox" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>');"/>
													</td>
													<td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
													<td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left">&nbsp;<?=$rs["_EventName"]?>&nbsp;</td>
													<td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left">&nbsp;<? if($rs["_EventDate"]!=""){?><?=date("d-M-Y", strtotime($rs["_EventDate"]))?><? } ?>&nbsp;</td>	
                                                    <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left">&nbsp;<?=$rs["_BriefInfo"]?>&nbsp;</td>																								
													<td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="left">&nbsp;<?=($rs["_Status"]=="S") ? "Show" : "Hide" ?>&nbsp;</td>
													<td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<a href="event.php?PageNo=<?=$PageNo?>&amp;id=<?=encrypt($rs['_ID'],$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>" class="TitleLink">Edit</a>&nbsp;</td>
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
									<td align="left"><!--<input type="button" class="button1" name="btnBack" value="< Back" onClick="javascript:history.back();" />&nbsp;-->
									<?php if($RecordCount > 0){ ?>
									<input type="button" class="button1" name="btnSubmit2" value="Delete Events" onclick="return validateForm3();" style="width:100px;" />&nbsp;
									<input type="reset" class="button1" name="btnReset2" onclick="setColorReset();" value="Clear Selection" style="width:100px;" />
									<?php } ?>
									</td>
									<td align="right">
										<a href="event.php" class="TitleLink">Add Event</a> | <a href="events.php?SearchBy=SearchBy1" class="TitleLink">New Search</a>											
									</td>
								</tr>								
								<tr><td colspan="2" height="5"><input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" /></td></tr>
								<tr>
									<td colspan="2">
									<?php if($RecordCount > 0){ ?>
 									<?php
										//if($MaxPage > 1) echo "Page: ";
										echo "Page: ";
										for ($i=1; $i<=$MaxPage; $i++)
										{
											if ($i == $PageNo)
											{
												print "<a href='?PageNo=". $i . $urlString ."' class='menulink'>[".$i."]</a> ";
											}
											else
											{
												print "<a href='?PageNo=" . $i . $urlString ."' class='menulink'>".$i."</a> ";
											}
										}
									?>
									<?php } ?>
									</td>
								</tr>								
							</table>
								</form>
							<?php
								//}
								//else{
								?>
									<!--<table cellpadding="0" cellspacing="0" border="0" width="840">
										<tr><td colspan="2" height="5"></td></tr>
										<tr>
											<td align="left">
												&nbsp;											 <input type="button" class="button1" name="btnBack" value="< Back" onClick="javascript:history.back();" />&nbsp;
												<input type="button" class="button1" name="btnSubmit2" value="Delete News" onclick="return validateForm3();" style="width:100px;" />&nbsp;<input type="reset" class="button1" name="btnReset2" value="Clear Selection" style="width:100px;" />
									 	</td>
											<td align="right">
												<a href="event.php" class="TitleLink">Add Event</a> | <a href="events.php?SearchBy=SearchBy1" class="TitleLink">New Search</a>											
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
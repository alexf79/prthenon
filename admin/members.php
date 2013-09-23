<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }

	include('../global.php');	
	include('../include/functions.php');

	$CanAdd 	= "Yes";
	$CanEdit 	= "Yes";
	$CanDelete 	= "Yes";
	
	
	$AdminProductPicPath = "images/products/";	
	$QureyUrl = '';
	foreach($_GET as $k=>$v)
	{
		if($k != 'PageNo')
		{
			$QureyUrl.= '&'.$k.'='.$v;
		}
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
	
	function getSort($title)
	{
		$sortBy = $_REQUEST["sortBy"];
		$sortArrange = $_REQUEST["sortArrange"];
		if($sortBy == $title)
		{
			if($sortArrange == 'ASC')
			{
				return 'up-sort';
			}else{
				return 'down-sort';
			}
		}else{
		
		}
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
	<script language="javascript" type="text/javascript">
		<!--
		function validateForm3()
		{
			if(checkSelected('CustCheckbox', document.Product.cntCheck.value) == false)
			{
				alert("Please select at least one checkbox.");
				document.Product.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to delete the selected Member(s)?') == true)
				{
					document.forms.Product.action = "memberaction.php?e_action=delete";
					document.forms.Product.submit();
				}
			}
		}

		function checkSelected(msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document.Product." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document.Product." + msgtype + i + ".checked") == true)
					{
						return true;
					}
				}
			}
			return false;
		}
		
		
		function checkSelected(msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document.Product." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document.Product." + msgtype + i + ".checked") == true)
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
					 eval("document.Product."+msgType+i+".checked = true");
				}
			}
			else
			{
				for (var i = 1; i<=count; i++)
				{
					 eval("document.Product."+msgType+i+".checked = false");
				}
			}
		}
		
		function ClearAll()
		{
			for (var i=0;i<document.Search.elements.length;i++) {
				if (document.Search.elements[i].type == "text" || document.Search.elements[i].type == "textarea")
					document.Search.elements[i].value = "";  
				else if (document.Search.elements[i].type == "select-one")
					document.Search.elements[i].selectedIndex = 0;
				else if (document.Search.elements[i].type == "checkbox")
					document.Search.elements[i].checked = false;
			}
		}	
		
		function setActivities(fromfield,rowid,rowcolor) { 
			
			/*if(fromfield.checked == true)
			{				
				for(var i=1;i<=9;i++)
				{
					document.getElementById('Row'+i+'ID'+rowid).className='gridline3'; // Cross-browser
				}
			}
			else
			{
				for(var i=1;i<=9;i++)
				{
					document.getElementById('Row'+i+'ID'+rowid).className=rowcolor; // Cross-browser
				}
			}*/
		}			
		
		function validateForm2()
		{			
			var errormsg;
			errormsg = "";

			/*var i;
			
			for (i=1; i<=document.FormName2.cntCheck.value; i++)
			{								
				if (eval("document.FormName2.Order"+i+".value == ''"))
				{
					errormsg += "Please fill in Order (line "+i+").\n";
				}
				else
				{								
					if (eval("!isInteger(document.FormName2.Order"+i+".value)"))
						errormsg += "Please fill in number in Order (line "+i+").\n";
				}						
			}
			*/
			if ((errormsg == null) || (errormsg == ""))
			{
				document.forms.Product.action = "productaction.php?e_action=updateorder";
				document.forms.Product.submit();
			}
			else
			{
				alert(errormsg);
				return false;
			}
		}
		//-->
	</script>
 
</head>
<body >
	<table align="center" width="98%"   border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		<tr>
			<td valign="top">
				<table width="100%"   border="0" cellspacing="0" cellpadding="0">
					
						<td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
					</tr>
					
					<tr>
						
						<td width="100%" align="left" valign="top" class="TitleStyle toptd" style="padding-left:5px; padding-top:6px;">
						<div class="m">
								 <b>Member</b>
						<!--
						Start Contact
						-->
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr><td height=""></td></tr>
							</table>
							<?php
							if ($_GET["done"] == 1)
							{
								echo "<div align='left' style=\"font-size:8pt;\"><font color='#FF0000'>Member has been added successfully.<br /></font></div>";
							}
							if ($_GET["done"] == 2)
							{
								echo "<div align='left' style=\"font-size:8pt;\"><font color='#FF0000'>Member has been edited successfully.<br /></font></div>";
							}
							if ($_GET["done"] == 3)
							{
								echo "<div align='left' style=\"font-size:8pt;\"><font color='#FF0000'>Member has been deleted successfully.<br /></font></div>";
							}
							if ($_GET["done"] == 4)
							{
								echo "<div align='left' style=\"font-size:8pt;\"><font color='#FF0000'>Member Order has been updated successfully.<br /></font></div>";
							}
							if ($_GET["error"] == 1)
							{
								
							}
							?>
							<br />
							<div>
							<?php
							$sortBy = $_REQUEST["sortBy"];
							$sortArrange = $_REQUEST["sortArrange"];
							 
								$Category = $_REQUEST["Category"];	
								$SubCategory = $_REQUEST["SubCategory"];		
								$ItemCode = $_REQUEST["ItemCode"];	
								$ItemName = $_REQUEST["ItemName"];
						 
								
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
							
							//$str1 = "SELECT m.*,l._LevelName as levelname,i._IndName as industryname from ".$tbname."_member as m join ".$tbname."_level as l on l._ID=m._Level join ".$tbname."_Industry as i on i._ID=m._Industry ";
							
							$str1 = "SELECT *,CONCAT(_Fname,' ',_Lname) as Name from ".$tbname."_member ";
															
																	

							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . "ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . "ORDER BY _ID DESC LIMIT $StartRow,$PageSize ";
							
							//echo $str1;
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
							<form name="Product" method="post" action="">								
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td colspan="2"><b>Member List</b></td>
								</tr>
								<tr><td colspan="2" height="10"></td></tr>
								<?php if($RecordCount > 0){ ?> 
								<tr>
									<td colspan="2">
									<span style="text-align:left;float:left;">
									<?php 
                                     if($RecordCount > 0 ) {  echo "Page :";  } ?>
									 
                                                        <?php
                                        for ($i=1; $i<=$MaxPage; $i++)
										{
											if ($i == $PageNo)
											{
												print "<a href='?PageNo=".encrypt($i,$Encrypt). $QureyUrl ."' class='menulink'>[".$i."]</a> ";
											}
											else
											{
												print "<a href='?PageNo=" .encrypt($i,$Encrypt). $QureyUrl ."' class='menulink'>".$i."</a> ";
											}
										}
															
															
									if (trim($sortArrange) == "DESC")
										$sortArrange = "ASC";
									elseif (trim($sortArrange) == "ASC")
										$sortArrange = "DESC";
									else
										$sortArrange = "DESC";

                                                            if ($sProjectNext != "") {
                                                                print "&nbsp;&nbsp;" . $sProjectNext;
                                                            }
                                                        ?>
                                                    </span>
													
													<span style="text-align:right;float:right;">
													<?php if($MaxPage == '0') {  $MaxPage = 1; } ?>
													<?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?>
 													</span>
									</td>
								</tr>
 								<tr><td colspan="2" height="5"><!--<input type="hidden" name="e_action" value="delete" />--></td></tr>
								<tr>
								  <td align="left">
								  <?php if($CanDelete == "Yes") { ?>
								  <input type="button" class="button1" name="btnSubmit2" value="Delete Member" onclick="return validateForm3();" style="width:100px;" />&nbsp;
								  <?php } ?>
								
								  <input type="button" class="button1" name="btnReset22" value="Clear Selection" onclick="CheckUnChecked('CustCheckbox',document.Product.cntCheck.value, document.Product.AllCheckbox.checked = false);" style="width:100px;" />&nbsp;</td>
									
								</tr>
								<?php }else{ ?>
								<tr><td colspan="2" height="5"><!--<input type="hidden" name="e_action" value="delete" />--></td></tr>
								
								
								<?php } ?>
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2">
										<table cellspacing="1" cellpadding="2" width="100%" border="0" class="grid" >
											<tr>
												<td style="margin-left:0px;margin-right:0px;" class="gridheader" width="30" align="center"><input name="AllCheckbox" type="checkbox" value="All" onclick="CheckUnChecked('CustCheckbox',document.Product.cntCheck.value,this);" /></td>
												<td class="gridheader" width="30" align="center">No.</td>
                      
                        <td class="gridheader" width="120" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Username',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>" class="sort <?php echo getSort('_Username');?> link1">Username</a></td>
						
						
												<td class="gridheader" width="200" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('Name',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>" class="sort <?php echo getSort('Name');?> link1">Fullname</a></td>                                               
												<td class="gridheader" width="150"  align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Email',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>" class="sort <?php echo getSort('_Email');?> link1">Email</a></td>												
												<td class="gridheader" width="150"  align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Gender',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>" class="sort <?php echo getSort('_Gender');?> link1">Gender</a></td>	
                                                <td class="gridheader" align="center" width="30px"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Birthdate',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>" class="sort <?php echo getSort('_Birthdate');?> link1">Birthdate</a></td>
                                                <td class="gridheader" align="center" width="80px"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Regdate',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>" class="sort <?php echo getSort('_Regdate');?> link1">Registration Date</a></td>	
												<td class="gridheader" align="center" width="30px"><a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Lastlog',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>" class="sort <?php echo getSort('_Lastlog');?> link1">Last Login</a></td>
																							
												<?php if($CanEdit == "Yes") { ?><td class="gridheader" width="60" align="center">View</td><?php } ?>
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
												?>
												<tr >
													<td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" width="30" align="center">
													  <input name="CustCheckbox<?php echo $i; ?>" type="checkbox" value="<?php echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>');" />
													</td>
													<td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                    <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" width="100">													
                                                   <?php echo $rs['_Username']; ?>
													</td>
                                                    <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" >&nbsp;<?php echo $rs["Name"] ?></td>
													<td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" >&nbsp;<?php echo $rs["_Email"] ?></td> 
                                                    <td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" >&nbsp;<?php echo $rs["_Gender"] ?></td>      
													<td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" >
														&nbsp;<?php echo date('d-m-Y',strtotime($rs['_Birthdate']));?></td>	
                                                    <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" >
														&nbsp;<?php echo date('d-m-Y',strtotime($rs['_Regdate']));?></td>												
																										
													<td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">
														&nbsp;<?php if($rs['_Lastlog'] != '') echo date('d-m-Y',strtotime($rs['_Lastlog']));?>
													</td>
																										
													<?php if($CanEdit == "Yes") { ?><td id="Row9ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">
													<a href="viewmember.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;e_action=<?=encrypt('view',$Encrypt)?>" class="TitleLink1">view</a>
													</td><?php } ?>
												</tr>
												<?php
												$i++;
											}
												} else {
															echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
												}
											?>
                                            <input type="hidden" name="cntCheck" value="<?php echo $i-1; ?>" />
										</table>
									</td>
								</tr>
								<tr><td colspan="2" height="5"></td></tr>

 							</table></form>	
</div>							
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
?>
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
	$CanExportCSV 	= "Yes";
	
	$AdminProductPicPath = "images/products/";	
	$QureyUrl = '';
	if(!isset($_REQUEST['searchtype']))
	{
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
				if(confirm('Are you sure you want to delete the selected Product Detail(s)?') == true)
				{
					document.forms.Product.action = "productaction.php?e_action=delete";
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
								 <b>Product Detail</b>
						<!--
						Start Contact
						-->
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr><td height=""></td></tr>
							</table>
							<?php
							if ($_GET["done"] == 1)
							{
								echo "<div align='left' style=\"font-size:8pt;\"><font color='#FF0000'>Product Detail has been added successfully.<br /></font></div>";
							}
							if ($_GET["done"] == 2)
							{
								echo "<div align='left' style=\"font-size:8pt;\"><font color='#FF0000'>Product Detail has been edited successfully.<br /></font></div>";
							}
							if ($_GET["done"] == 3)
							{
								echo "<div align='left' style=\"font-size:8pt;\"><font color='#FF0000'>Product Detail has been deleted successfully.<br /></font></div>";
							}
							if ($_GET["done"] == 4)
							{
								echo "<div align='left' style=\"font-size:8pt;\"><font color='#FF0000'>Product Detail Order has been updated successfully.<br /></font></div>";
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
							 
								$Title = $_REQUEST["P_title"];	
								$S_Des = $_REQUEST["S_des"];		
															 
								
							//Set the page size
							$PageSize = 200;
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
							
					//		$str1 = "SELECT j.*,t._TypeName as _Type,j._Company as companyname,cont._ContName as location,i._IndName as industry FROM ".$tbname."_jobdetail j join ".$tbname."_continent as cont on cont._ID=j._Location join ".$tbname."_industry as i on i._ID=j._Industry join ".$tbname."_type as t on t._ID=j._TypeID where 1=1  ";
							
							
							$str1 = "SELECT p.*,c._Name as category FROM ".$tbname."_product p join ".$tbname."_category c on c._ID=p._Catid where 1=1 ";
																	
			
							if (trim($sortBy) != "" && trim($sortArrange) != "")
								$str2 = $str1 . "ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
							else
								$str2 = $str1 . "ORDER BY _ID DESC LIMIT $StartRow,$PageSize ";
							
							
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
                          	<form name="Product" method="post" >								
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td colspan="2"><b>Product Detail List</b></td>
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
								  <td align="left"><!--<input type="button" class="button1" name="btnBack" value="< Back" onclick="javascript:history.back();" />&nbsp;-->								  
					<!--			  <input style="width:100px;" type="button" class="button1" name="btnUpdateOrder" value="Update Order" onClick="return validateForm2();">&nbsp;
					-->
								  <?php if($CanDelete == "Yes") { ?>
								  <input type="button" class="button1" name="btnSubmit2" value="Delete Product" onclick="return validateForm3();" style="width:100px;" />&nbsp;
								  <?php } ?>
								
								  <input type="button" class="button1" name="btnReset22" value="Clear Selection" onclick="CheckUnChecked('CustCheckbox',document.Product.cntCheck.value, document.Product.AllCheckbox.checked = false);" style="width:100px;" />&nbsp;</td>
									<td align="right">	
									<?php if($CanAdd == "Yes") { ?>
                                    <a href="product.php" class="MainTitleLink1">Add Product Detail</a>
									<?php } ?>
									</td>
								</tr>
								<?php }else{ ?>
								<tr><td colspan="2" height="5"><!--<input type="hidden" name="e_action" value="delete" />--></td></tr>
								<tr>
								  <td align="left">&nbsp;</td>
									<td align="right">	
									<?php if($CanAdd == "Yes") { ?>
                                    <a href="product.php" class="MainTitleLink1">Add Product Detail</a>
									<?php } ?>
									</td>
								</tr>
								
								<?php } ?>
								<tr><td colspan="2" height="5"></td></tr>
								<tr>
									<td colspan="2">
										<table cellspacing="1" cellpadding="2" width="100%" border="0" class="grid" >
											<tr>
												<td style="margin-left:0px;margin-right:0px;" class="gridheader" width="10" align="center"><input name="AllCheckbox" type="checkbox" value="All" onclick="CheckUnChecked('CustCheckbox',document.Product.cntCheck.value,this);" /></td>
												<td class="gridheader" width="30" align="center">No.</td>
                      <td class="gridheader" width="120" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('category',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>&amp;Category=<?=encrypt($Category,$Encrypt)?>&amp;SubCategory=<?=encrypt($SubCategory,$Encrypt)?>&amp;ItemCode=<?=encrypt($ItemCode,$Encrypt)?>&amp;ItemName=<?=encrypt($ItemName,$Encrypt)?>" class="sort <?php echo getSort('category');?> link1">Category</a></td>
                        <td class="gridheader" width="120" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Title',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>&amp;Category=<?=encrypt($Category,$Encrypt)?>&amp;SubCategory=<?=encrypt($SubCategory,$Encrypt)?>&amp;ItemCode=<?=encrypt($ItemCode,$Encrypt)?>&amp;ItemName=<?=encrypt($ItemName,$Encrypt)?>" class="sort <?php echo getSort('_Title');?> link1">Title</a></td>
						
						
												<td class="gridheader" width="200" align="center">&nbsp;<a href="?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;sortBy=<?=encrypt('_Short_Des',$Encrypt)?>&amp;sortArrange=<?=encrypt($sortArrange,$Encrypt)?>&amp;Category=<?=encrypt($Category,$Encrypt)?>&amp;SubCategory=<?=encrypt($SubCategory,$Encrypt)?>&amp;ItemCode=<?=encrypt($ItemCode,$Encrypt)?>&amp;ItemName=<?=encrypt($ItemName,$Encrypt)?>" class="sort <?php echo getSort('_Short_Des');?> link1">Short Descreption</a></td>                                               
																								
								
								
							
												<?php if($CanEdit == "Yes") { ?><td class="gridheader" width="60" align="center">Edit </td><?php } ?>
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
													  <input name="CustCheckbox<?php echo $i; ?>" type="checkbox" value="<?php  echo $rs["_ID"]; ?>" onclick="setActivities(this.form.CustCheckbox<?php echo $i; ?>, <?php echo $i; ?>,'<?=$Rowcolor?>');" />
													</td>
													<td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $bil; ?>&nbsp;</td>
                                                     <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" width="100"><?php echo $rs['category']; ?>
                                                    <td id="Row3ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" width="100"><?php echo $rs['_Title']; ?>
													</td>
                                                    <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center" >&nbsp;<?php echo $rs["_Short_Des"] ?></td>	
																						
													<?php if($CanEdit == "Yes") { ?><td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" align="center">
													<a href="product.php?PageNo=<?=encrypt($PageNo,$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt)?>&amp;e_action=<?=encrypt('edit',$Encrypt)?>" class="TitleLink1">Edit</a>
													</td><?php } ?>
												</tr>
												<?php
												$i++;
											}
												} else {
															echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
												}
											?>
                                             <input type="hidden" name="cntCheck" value="<?php echo $i - 1; ?>" />
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
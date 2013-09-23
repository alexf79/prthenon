<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    echo "<script language='javascript'>window.location='login.php';</script>";
} else {
    include('../global.php');
    include('../include/functions.php');
    mysql_select_db($database, $connect) or die(mysql_error());	
	
	$TypeID = decode(trim($_GET['typeid']));
	
	$str = "SELECT * FROM ".$tbname."_home_cms WHERE _TypeID = '".replaceSpecialChar($TypeID)."' ";
		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);					
			$id = $rs["_ID"];	
			$TypeID = $rs["_TypeID"];
			$Display = $rs["_Display"];				
			$Status = $rs["_Status"];	
			$Hyperlink = replaceSpecialCharBack($rs["_Hyperlink"]);		
			
			$Image1= replaceSpecialCharBack($rs['_Image1']);
			$Image2= replaceSpecialCharBack($rs['_Image2']);
			$Image3= replaceSpecialCharBack($rs['_Image3']);
			$Image4= replaceSpecialCharBack($rs['_Image4']);	
			$Image5 = replaceSpecialCharBack($rs['_Image5']);	
			
			$Caption1= replaceSpecialCharBack($rs['_Caption1']);
			$Caption2= replaceSpecialCharBack($rs['_Caption2']);
			$Caption3= replaceSpecialCharBack($rs['_Caption3']);
			$Caption4= replaceSpecialCharBack($rs['_Caption4']);	
			$Caption5 = replaceSpecialCharBack($rs['_Caption5']);	
			
			$Url1= replaceSpecialCharBack($rs['_Url1']);
			$Url2= replaceSpecialCharBack($rs['_Url2']);
			$Url3= replaceSpecialCharBack($rs['_Url3']);
			$Url4= replaceSpecialCharBack($rs['_Url4']);	
			$Url5 = replaceSpecialCharBack($rs['_Url5']);	
			
			$Order1= replaceSpecialCharBack($rs['_Order1']);
			$Order2= replaceSpecialCharBack($rs['_Order2']);
			$Order3= replaceSpecialCharBack($rs['_Order3']);
			$Order4= replaceSpecialCharBack($rs['_Order4']);	
			$Order5 = replaceSpecialCharBack($rs['_Order5']);	
			
			$withLogin = $rs['_withLogin'];
		    $withoutLogin = $rs['_withoutLogin'];
			
		}
		
		$strTypeName = "SELECT ".$tbname."_hometypes._ID AS ID, _TypeName FROM ".$tbname."_hometypes WHERE _ID='" . replaceSpecialChar($TypeID) . "'";                                                                                                                    
		$rstTypeName = mysql_query($strTypeName, $connect) or die(mysql_error());
		if(mysql_num_rows($rstTypeName) > 0)
		{
			  $rsTypeName = mysql_fetch_assoc($rstTypeName);			
			  $TypeName=$rsTypeName["_TypeName"]; 			
		}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <title><?php echo $appname; ?></title>
            <link rel="stylesheet" type="text/css" href="../css/admin.css" />
			<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />
            <script type="text/javascript" src="../js/validate.js"></script>
            <script language="javascript">
                <!--
				function validateForm()
				{
					var errormsg;
					errormsg = "";				
					
					var Image1 = "",Image2 = "",Image3 = "",Image4 = "",Image5 = "";
					
					var Image1Exist = document.FormName.Image1Exist.value;
					var Image2Exist = document.FormName.Image2Exist.value;
					var Image3Exist = document.FormName.Image3Exist.value;
					var Image4Exist = document.FormName.Image4Exist.value;
					var Image5Exist = document.FormName.Image5Exist.value;
					
					if(Image1Exist == ""){
						Image1 = document.FormName.Image1.value;
					}
					if(Image2Exist == ""){
						Image2 = document.FormName.Image2.value;
					}
					if(Image3Exist == ""){
						Image3 = document.FormName.Image3.value;
					}
					if(Image4Exist == ""){
						Image4 = document.FormName.Image4.value;
					}
					if(Image5Exist == ""){
						Image5 = document.FormName.Image5.value;
					}
					
					var Caption1 = document.FormName.Caption1.value;
					var Caption2 = document.FormName.Caption2.value;
					var Caption3 = document.FormName.Caption3.value;
					var Caption4 = document.FormName.Caption4.value;
					var Caption5 = document.FormName.Caption5.value;
					
					var Order1 = document.FormName.Order1.value;
					var Order2 = document.FormName.Order2.value;
					var Order3 = document.FormName.Order3.value;
					var Order4 = document.FormName.Order4.value;
					var Order5 = document.FormName.Order5.value;
					
					if(Image1 != "" || Image1Exist != ""){
						if (Caption1 == "")
							errormsg += "Please fill in 'Caption1'.\n";
						if (Order1 == "" || Order1 == "0")
							errormsg += "Please fill in 'Order1'.\n";	
					}
					
					if(Image2 != "" || Image2Exist != ""){
						if (Caption2 == "")
							errormsg += "Please fill in 'Caption2'.\n";
						if (Order2 == "" || Order2 == "0")
							errormsg += "Please fill in 'Order2'.\n";	
					}
					
					if(Image3 != "" || Image3Exist != ""){
						if (Caption3 == "")
							errormsg += "Please fill in 'Caption3'.\n";
						if (Order3 == "" || Order3 == "0")
							errormsg += "Please fill in 'Order3'.\n";	
					}
					
					if(Image4 != "" || Image4Exist != ""){
						if (Caption4 == "")
							errormsg += "Please fill in 'Caption4'.\n";
						if (Order4 == "" || Order4 == "0")
							errormsg += "Please fill in 'Order4'.\n";	
					}
					
					if(Image5 != "" || Image5Exist != ""){
						if (Caption5 == "")
							errormsg += "Please fill in 'Caption5'.\n";
						if (Order5 == "" || Order5 == "0")
							errormsg += "Please fill in 'Order5'.\n";	
					}
					
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
				//-->
            </script>
        </head>
        <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
            <table align="center" width="98%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                <tr>
                    <td valign="top">
                        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                             <tr>
                                <td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
                            </tr>
                             <tr>
                                 <td width="100%" align="center" class="toptd" valign="top">
                                	<div class="m">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td align="left" class="TitleStyle"><b>Web Pages CMS - Home - <?php echo $TypeName; ?></b></td>
                                        </tr>
                                        <?php
                                        if ($_GET["done"] == 1) {
                                            echo "<tr><td align='left'><font color='#FF0000'>2nd Level has been added successfully.</font></td></tr><tr><td height='10'></td></tr>";
                                        }
                                        if ($_GET["done"] == 2) {
                                            echo "<tr><td align='left'><font color='#FF0000'>2nd Level has been edited successfully.</font></td></tr><tr><td height='10'></td></tr>";
                                        }
                                        if ($_GET["done"] == 3) {
                                            echo "<tr><td align='left'><font color='#FF0000'>2nd Level has been deleted successfully.</font></td></tr><tr><td height='10'></td></tr>";
                                        }
                                        if ($_GET["done"] == 4) {
                                            echo "<DIV align='left'><font color='#FF0000'>2nd Level order and display has been updated successfully.<br></font></DIV>";
                                        }
                                    ?>
                                        <tr>
                                        <td height="10">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">                                        
                                          <tr>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>
                                            	<form action="2ndlvlhomecms_action.php" method="post" onSubmit="return validateForm();" enctype="multipart/form-data" name="FormName">
                                            	<table width="100%" border="0" cellspacing="0" cellpadding="0">                                              
                                                  <tr>
                                                    <td valign="top">Image 1</td>
                                                    <td valign="top" width="10">&nbsp;:&nbsp;</td>
                                                    <td align="left"><?php
														if($Image1 != ""){?>
															<a href="<?php echo $HomePageImagePath;?><?php echo $Image1;?>" target="_blank" style="color:#FF0000; font-family:arial; font-size:11px;"><?php echo $Image1;?></a>&nbsp; 
															<a href="javascript:void(0);" onClick="if(confirm('Are you sure you want to delete this?')) { window.open('admin_removefile.php?ID=<?php echo encode($id);?>&Types=Image1','personalize','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1,height=1,left=1000,top=1000'); return true; }" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a><?php 
														} 
														else{?>
															<input name="Image1" type="file" class="txtbox1" id="Image1" size="23" /><?php 
														} ?>
														<br/><br/>
														
														&nbsp;Caption&nbsp;:&nbsp;<input type="text" name="Caption1" class="txtbox1" <?php if($Caption1 != ""){ echo "value=$Caption1"; } ?> />
														&nbsp;URL&nbsp;:&nbsp;<input type="text" name="Url1" class="txtbox1" <?php if($Url1 != ""){ echo "value=$Url1"; } ?> />
														&nbsp;Order&nbsp;:&nbsp;<input type="text" style="width:30px;text-align:center;" name="Order1" class="txtbox1" size="3" <?php if($Order1 != ""){ echo "value=$Order1"; } ?> />
                                                        <input type="hidden" name="Image1Exist" value="<?php echo $Image1;?>">  
                                                        <input name="e_action" type="hidden" value="edit"> 
                                                        <input name="id" type="hidden" value="<?=$TypeID?>">                                                  
                                                     </td>
                                                  </tr>
                                                  <tr><td height="10">&nbsp;</td></tr>
                                                  <?php
												  if($TypeID!='1' && $TypeID!='2' && $TypeID!='5' && $TypeID!='19')
												  {
												  ?>
                                                  <tr>
                                                    <td valign="top">Image 2</td>
                                                    <td valign="top" width="10">&nbsp;:&nbsp;</td>
                                                    <td align="left"><?php
                                                             if($Image2 != "")
                                                                {
                                                            ?>
                                                          <a href="<?php echo $HomePageImagePath;?><?php echo $Image2;?>" target="_blank" style="color:#FF0000; font-family:arial; font-size:11px;"><?php echo $Image2;?></a>&nbsp; <a href="javascript:void(0);" onClick="if(confirm('Are you sure you want to delete this?')) { window.open('admin_removefile.php?ID=<?php echo encode($id);?>&Types=Image2','personalize','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1,height=1,left=1000,top=1000'); return true; }" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a>
                                                          <?php }else{ ?>
                                                          <input name="Image2" type="file" class="txtbox1" id="Image2" size="23" />
                                                          <?php } ?>
														<br/><br/>
														&nbsp;Caption&nbsp;:&nbsp;<input type="text" name="Caption2" class="txtbox1" <?php if($Caption2 != ""){ echo "value=$Caption2"; } ?> />
														&nbsp;URL&nbsp;:&nbsp;<input type="text" name="Url2" class="txtbox1" <?php if($Url2 != ""){ echo "value=$Url2"; } ?> />
														&nbsp;Order&nbsp;:&nbsp;<input type="text" name="Order2" style="width:30px; text-align:center;" class="txtbox1" size="3" <?php if($Order2 != ""){ echo "value=$Order2"; } ?> />
                                                          <input type="hidden" name="Image2Exist" value="<?php echo $Image2;?>">                                                    
                                                       </td>
                                                  </tr>
                                                  <tr><td height="10">&nbsp;</td></tr>
                                                  
                                                  <tr>
                                                    <td valign="top">Image 3</td>
                                                    <td valign="top" width="10">&nbsp;:&nbsp;</td>
                                                    <td align="left"><?php
                                                             if($Image3 != "")
                                                                {
                                                        ?>
                                                        <a href="<?php echo $HomePageImagePath;?><?php echo $Image3;?>" target="_blank" style="color:#FF0000; font-family:arial; font-size:11px;"><?php echo $Image3;?></a>&nbsp; <a href="javascript:void(0);" onClick="if(confirm('Are you sure you want to delete this?')) { window.open('admin_removefile.php?ID=<?php echo encode($id);?>&Types=Image3','personalize','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1,height=1,left=1000,top=1000'); return true; }" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a>
                                                        <?php
                                                                }else{
                                                         ?>
                                                        <input name="Image3" type="file" class="txtbox1" id="Image3" size="23" />
                                                        <?php   } ?>
														<br/><br/>
														&nbsp;Caption&nbsp;:&nbsp;<input type="text" name="Caption3" class="txtbox1" <?php if($Caption3 != ""){ echo "value=$Caption3"; } ?> />
														&nbsp;URL&nbsp;:&nbsp;<input type="text" name="Url3" class="txtbox1" <?php if($Url3 != ""){ echo "value=$Url3"; } ?> />
														&nbsp;Order&nbsp;:&nbsp;<input type="text" name="Order3" style="width:30px; text-align:center;" class="txtbox1" size="3" <?php if($Order3 != ""){ echo "value=$Order3"; } ?> />
                                                        <input type="hidden" name="Image3Exist" value="<?php echo $Image3;?>">                                                    
                                                      </td>
                                                  </tr>
                                                  <tr><td height="10">&nbsp;</td></tr>
                                                  
                                                  <tr>
                                                    <td valign="top">Image 4</td>
                                                    <td valign="top" width="10">&nbsp;:&nbsp;</td>
                                                    <td align="left"><?php
														      if($Image4 != "")
															  {
                                                        ?>
                                                        <a href="<?php echo $HomePageImagePath;?><?php echo $Image4;?>" target="_blank" style="color:#FF0000; font-family:arial; font-size:11px;"><?php echo $Image4;?></a>&nbsp; <a href="javascript:void(0);" onClick="if(confirm('Are you sure you want to delete this?')) { window.open('admin_removefile.php?ID=<?php echo encode($id);?>&Types=Image4','personalize','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1,height=1,left=1000,top=1000'); return true; }" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a>
                                                        <?php }else{ ?>
                                                        <input name="Image4" type="file" class="txtbox1" id="Image4" size="23" />
                                                        <?php }?>
														<br/><br/>
														&nbsp;Caption&nbsp;:&nbsp;<input type="text" name="Caption4" class="txtbox1" <?php if($Caption4 != ""){ echo "value=$Caption4"; } ?> />
														&nbsp;URL&nbsp;:&nbsp;<input type="text" name="Url4" class="txtbox1" <?php if($Url4 != ""){ echo "value=$Url4"; } ?> />
														&nbsp;Order&nbsp;:&nbsp;<input type="text" style="width:30px; text-align:center;" name="Order4" class="txtbox1" size="3" <?php if($Order4 != ""){ echo "value=$Order4"; } ?> />
                                                        <input type="hidden" name="Image4Exist" value="<?php echo $Image4;?>">                                                    </td>
                                                  </tr>
                                                  <tr><td height="10">&nbsp;</td></tr>
                                                  
                                                  <tr>
                                                    <td valign="top">Image 5</td>
                                                    <td valign="top" width="10">&nbsp;:&nbsp;</td>
                                                    <td align="left"><?php
                                                             if($Image5 != "")
                                                              {
                                                        ?>
                                                        <a href="<?php echo $HomePageImagePath;?><?php echo $Image5;?>" target="_blank" style="color:#FF0000; font-family:arial; font-size:11px;"><?php echo $Image5;?></a>&nbsp; <a href="javascript:void(0);" onClick="if(confirm('Are you sure you want to delete this?')) { window.open('admin_removefile.php?ID=<?php echo encode($id);?>&Types=Image5','personalize','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1,height=1,left=1000,top=1000'); return true; }" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a>
                                                        <?php }else { ?>
                                                        <input name="Image5" type="file" class="txtbox1" id="Image5" size="23" />
                                                        <?php } ?>
														<br/><br/>
														&nbsp;Caption&nbsp;:&nbsp;<input type="text" name="Caption5" class="txtbox1" <?php if($Caption5 != ""){ echo "value=$Caption5"; } ?> />
														&nbsp;URL&nbsp;:&nbsp;<input type="text" name="Url5" class="txtbox1" <?php if($Url5 != ""){ echo "value=$Url5"; } ?> />
														&nbsp;Order&nbsp;:&nbsp;<input type="text" name="Order5" class="txtbox1" style="width:30px;text-align:center;" size="3" <?php if($Order5 != ""){ echo "value=$Order5"; } ?> />
                                                        <input type="hidden" name="Image5Exist" value="<?php echo $Image5;?>">
                                                    </td>
                                                  </tr>
												  <!--
                                                  <tr><td height="10"></td></tr>
												  <tr>
                                                    <td valign="top">After Login</td>
                                                    <td valign="top" width="10">&nbsp;:&nbsp;</td>
                                                    <td> 
														<input type="checkbox" name="withlogin" value="1" <?php if(isset($withLogin) && $withLogin == "1") { ?> checked="checked" <?php } ?> >
                                                    </td>
                                                  </tr>
 												  
												  <tr>
                                                    <td valign="top">Before Login</td>
                                                    <td valign="top" width="10">&nbsp;:&nbsp;</td>
                                                    <td> 
														<input type="checkbox" name="withoutlogin" value="1" <?php if(isset($withoutLogin) && $withoutLogin == "1") { ?> checked="checked" <?php } ?> >
                                                    </td>
                                                  </tr>
                                                  <tr><td height="10"></td></tr>
												  
                                                  <?php } ?>
												 -->
                                                  <tr>
                                                    <td colspan="3" align="left"> <br />
                                                  	Note : <!-- Logo (222px x 90px)<br/> -->
                                                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Banner (1000px x 343px)
                                                  </td>
                                                  </tr>
                                                  <tr><td height="15"></td></tr>
												 
												 <tr>
													<td align="left" valign="top">Status</td>
													<td align="left" valign="top">:</td>
													<td align="left">
													<select name="Status" class="dropdown1">
														<option value="Live" <?=($Status=="Live" ? "selected" : "")?>>Live</option> 
														<option value="Draft" <?=($Status=="Draft" ? "selected" : "")?>>Draft</option>
													</select>
													</td>
												</tr>
												 <tr><td height="10"></td></tr>
                                                  <tr>
                                                    <td></td>
                                                  	<td>&nbsp;</td>
                                                    <td align="left"><input name="btnBack" type="button" class="button1" id="btnBack" value="< Back" onClick="window.location='2ndlvlhomecms.php'">&nbsp;
                                                    <input type="submit" id="btnSubmit" name="btnSubmit" class="button1" value="Submit"></td>
                                                  </tr>
                                                </table>
                                                </form>
                                            </td>
                                          </tr>
                                        </table>
                                        </td>
                                    </tr>									
                                    <tr>
                                         <td align="left" valign="top"></td>
                                    </tr>
                                </table>
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
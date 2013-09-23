<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    echo "<script language='javascript'>window.location='login.php';</script>";
} else {
    include('../global.php');
    include('../include/functions.php');   
	
	$CanAdd 	= "Yes";
	$CanEdit 	= "Yes";
	$CanDelete 	= "Yes";
	
	/* START SCRIPT FOR DECRYPT */
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
	/* END SCRIPT FOR DECRYPT */	
	
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
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            <title><?=$appname?></title>
            <link rel="stylesheet" type="text/css" href="../css/admin.css" />	
			<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />	
            <script language="javascript" type="text/javascript" src="../js/validate.js"></script>
            <script language="javascript" type="text/javascript">
                <!--
                function validateForm2()
                {
                    var errormsg;
                    errormsg = "";

                    var i;

                    for (i=1; i<=document.FormName2.cntCheck.value; i++)
                    {
                        if (eval("document.FormName2.Display"+i+".checked"))
                        {
                            if (eval("document.FormName2.Order"+i+".value == ''"))
                                errormsg += "Please fill in Order (line "+i+").\n";
                            else
                            {
                                if (eval("!isInteger(document.FormName2.Order"+i+".value)"))
                                    errormsg += "Please fill in number in Order (line "+i+").\n";
                            }
                        }
                    }

                    if ((errormsg == null) || (errormsg == ""))
                    {
                        document.forms.FormName2.action = "1stlvlcms_action.php";
                        document.forms.FormName2.submit();
                    }
                    else
                    {
                        alert(errormsg);
                        return false;
                    }
                }

                function EnableDisableField(FromField, ToField)
                {
                    if(FromField.checked == true)
                            {
                                    ToField.disabled = false;
                            }
                            else
                            {
                                    ToField.disabled = true;
                            }
                }

                function ClearAll()
                {
                    for (var i=0;i<document.FormName2.elements.length;i++) {
                        if (document.FormName2.elements[i].type == "text" || document.FormName2.elements[i].type == "textarea")
                            document.FormName2.elements[i].value = "";
                        else if (document.FormName2.elements[i].type == "select-one")
                            document.FormName2.elements[i].selectedIndex = 0;
                        else if (document.FormName2.elements[i].type == "checkbox")
                            document.FormName2.elements[i].checked = false;
                    }
                }

                function Revert()
                {
                    document.FormName2.reset();
                }								
                //-->
            </script>
        </head>
        <body>
            <table align="center" width="98%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            
                            <tr>
                                <td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
                            </tr>
                            
                            <tr>
                                
                                <td width="100%" align="center" class="toptd" valign="top">
                                	<div class="m">
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                        <tr><td align="left" class="TitleStyle"><b>Web Pages CMS</b></td></tr>
                                        <tr><td height="10"></td></tr>
                                    </table>
                                    <?php
                                        if ($_REQUEST["done"] == '1') {
                                            echo "<div align='left'><font color='#FF0000'>Page has been added successfully.<br></font></div>";
                                        }
                                        if ($_REQUEST["done"] == '2') {
                                            echo "<div align='left'><font color='#FF0000'>Page has been edited successfully.<br></font></div>";
                                        }
                                        if ($_GET["done"] == 3) {
                                            echo "<div align='left'><font color='#FF0000'>Page has been deleted successfully.<br></font></div>";
                                        }
                                        if ($_GET["done"] == 4) {
                                            echo "<div align='left'><font color='#FF0000'>Page order and display has been updated successfully.<br></font></div>";
                                        }
                                        if ($_GET["error"] == 2) {
                                            echo "<div align='left'><font color='#FF0000'>Page [" . $name . "] cannot be deleted.  .<br></font></div>";
                                        }
                                    ?>
                                    <?php
                                    //Set the page size
                                    $PageSize = 30;
                                    $StartRow = 0;
									$sortBy = trim($_GET["sortBy"]);
                                    $sortArrange = trim($_GET["sortArrange"]);
									
									 $urlString = "&amp;PID=" . encrypt(replaceSpecialChar($PID),$Encrypt) . "&amp;PageTitle=" . encrypt(replaceSpecialChar($PageTitle),$Encrypt) . "&amp;RedirectURL=" . encrypt(replaceSpecialChar($RedirectURL),$Encrypt) . encrypt(replaceSpecialChar($StatusPageString),$Encrypt) . "";       
                                    //Set the page no
                                    if (empty($_GET['PageNo'])) {
                                        if ($StartRow == 0) {
                                            $PageNo = $StartRow + 1;
                                        }
                                    } else {
                                        $PageNo = $_GET['PageNo'];
                                        $StartRow = ($PageNo - 1) * $PageSize;
                                    }

                                    //Set the counter start
                                    if ($PageNo % $PageSize == 0) {
                                        $CounterStart = $PageNo - ($PageSize - 1);
                                    } else {
                                        $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
                                    }

                                    //Counter End
                                    $CounterEnd = $CounterStart + ($PageSize - 1);

                                    $i = 1;
                                    $Rowcolor = "gridline1";
                                    $str1 = "SELECT * FROM " . $tbname . "_cms WHERE _Level = '1' AND _ID IS NOT NULL ";
                                    $str2 = $str1;
									if (trim($sortBy) != "" && trim($sortArrange) != "") {
										$str2 = $str2 . "ORDER BY " . trim($sortBy) . " " . trim($sortArrange) . " LIMIT $StartRow,$PageSize ";
									} else {
										$str2 = $str2 . "ORDER BY _Order, _PageTitle LIMIT $StartRow,$PageSize ";
									}
									
                                    $TRecord = mysql_query($str1, $connect);
                                    $result = mysql_query($str2, $connect);

                                    //Total of record
                                    if ($result) {
                                        $RecordCount = mysql_num_rows($TRecord);
                                    }
                                    //Set Maximum Page
                                    $MaxPage = $RecordCount % $PageSize;
                                    if ($RecordCount % $PageSize == 0) {
                                        $MaxPage = $RecordCount / $PageSize;
                                    } else {
                                        $MaxPage = ceil($RecordCount / $PageSize);
                                    }

                                    /* '''''''''''''''''''''''''''''''''''''''''''''''''''''''' */
                                    $pageshowlimit = 20;
                                    $pageshowpoint = $_GET['pageshowpoint'];
                                    if ($pageshowpoint != "" && is_numeric($pageshowpoint)) {
                                        $pageshowpoint = (int) $pageshowpoint;
                                    } else {
                                        $pageshowpoint = 0;
                                    }
                                    $pageshowstart = (int) $pageshowpoint + 1;
                                    $pageshowend = (int) $pageshowpoint + (int) $pageshowlimit;

                                    if ((int) $pageshowpoint == 0) {
                                        $sProjectPrev = "";
                                    } elseif ((int) $pageshowpoint > 0) {
                                        $sProjectPrev = "<a href='?PageNo=". ((int) $pageshowpoint - (int) $pageshowlimit + 1) . "&amp;pageshowpoint=" . ((int) $pageshowpoint - (int) $pageshowlimit) . "' class='menulink'>Previous " . $pageshowlimit . "</a> ";
                                    }

                                    if ((int) $MaxPage <= (int) $pageshowend) {
                                        $sProjectNext = "";
                                    } elseif ((int) $MaxPage > (int) $pageshowend) {
                                        $sProjectNext = "<a href='?PageNo=" . ((int) $pageshowpoint + (int) $pageshowlimit + 1) . "&amp;pageshowpoint=" . ((int) $pageshowpoint + (int) $pageshowlimit) . "' class='menulink'>Next " . $pageshowlimit . "</a> ";
                                    }
                                    /* '''''''''''''''''''''''''''''''''''''''''''''''''''''''' */
                                    
                                    ?>
                                    <form name="FormName2" method="post" action="">
                                        <input type="hidden" name="e_action" value="cmsupdateorder" />
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
											<!-- <tr>
                                                        <td><div align="right"><?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?></div></td>
                                                    </tr> -->
                                            <tr>
                                                <td width="100%">
                                                    <span style="text-align:left;float:left;">
                                                        Page :
                                                        <?php
                                                            if ($sProjectPrev != "") {
                                                                print $sProjectPrev . "&nbsp;&nbsp;";
                                                            }

                                                            if ((int) $MaxPage < (int) $pageshowend) {
                                                                $untilpage = (int) $MaxPage;
                                                            } else {
                                                                $untilpage = (int) $pageshowend;
                                                            }

                                                            if ((int) $untilpage == 0) {
                                                                $untilpage = 1;
                                                            }

                                                            for ($i = (int) $pageshowstart; $i <= (int) $untilpage; $i++) {
                                                                if ($i > 0) {
                                                                    if ($i == $PageNo) {
                                                                        print "<a href='?PageNo=" . encrypt($i,$Encrypt) . "&amp;pageshowpoint=" . encrypt((int) $pageshowpoint,$Encrypt) . "' class='menulink'>[" . $i . "]</a> ";
                                                                    } else {
                                                                        print "<a href='?PageNo=" . encrypt($i,$Encrypt) . "&amp;pageshowpoint=" . encrypt((int) $pageshowpoint,$Encrypt) . "' class='menulink'>" . $i . "</a> ";
                                                                    }
                                                                }
                                                            }

                                                            if ($sProjectNext != "") {
                                                                print "&nbsp;&nbsp;" . $sProjectNext;
                                                            }
                                                        ?>
                                                    </span>
													
													<span style="text-align:right;float:right;">
													<?php print "$RecordCount record(s) founds - You are at page $PageNo  of $MaxPage"; ?>
 													</span>
                                                </td>
                                            </tr>
                                            <tr><td height="5"></td></tr>
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td valign="bottom" align="left">
                                                            	 <input style="width:100px;" type="button" class="button1" name="btnUpdateOrder" value="Update Order" onclick="return validateForm2();" />&nbsp;
																 <input style="width:100px;" type="button" class="button1" name="btnReset2" value="Clear" onclick="ClearAll();" /></td>
                                                            <td valign="bottom" align="right">
                                                            	<?php if($CanAdd == "Yes") { ?>
                                                            	<a href="add1stlvlcms.php" class="MainTitleLink1">Add Page</a>
                                                            	<?php } ?>
                                                            </td>
                                                        </tr>
                                                    </table>
												</td>
                                            </tr>
                                            <tr><td height="5"></td></tr>
                                            <tr>
                                                <td colspan="2">
                                                    <table width="100%" class="grid" cellspacing="1" cellpadding="2">
                                                    	<?php
															if (trim($sortArrange) == "DESC")
																$sortArrange = "ASC";
															elseif (trim($sortArrange) == "ASC")
																$sortArrange = "DESC";
															else
																$sortArrange = "DESC";
														?>
                                                        <tr>
                              <td bgcolor="#D7E0F4" class="gridheader" height="25" align="center">No.</td>
							  
															<td bgcolor="#D7E0F4" class="gridheader" height="25" align="center"><?php echo "<a href='?PageNo=" . encrypt($PageNo,$Encrypt) . "&amp;pageshowpoint=" . encrypt($pageshowpoint,$Encrypt) . "&amp;SearchBy=" . encrypt($_GET["SearchBy"],$Encrypt) . "&amp;sortBy=".encrypt('_PageTitle',$Encrypt)."&amp;sortArrange=" . encrypt($sortArrange,$Encrypt) . $urlString . "' class='sort ".getSort('_PageTitle')."  TitleLink'>"; ?>1st Level<?php echo "</a>"; ?></td>
															<!--<td bgcolor="#D7E0F4" class="gridheader" height="25" align="center"><b><?php echo "<a href='?PageNo=" . $PageNo . "&amp;pageshowpoint=" . $pageshowpoint . "&amp;SearchBy=" . $_GET["SearchBy"] . "&amp;sortBy=_RedirectURL&sortArrange=" . $sortArrange . $urlString . "' class='TitleLink'>"; ?>Redirect URL<?php echo "</a>"; ?></b></td>-->
                              <td bgcolor="#D7E0F4" class="gridheader" height="25" align="center"><?php echo "<a href='?PageNo=" . encrypt($PageNo,$Encrypt) . "&amp;pageshowpoint=" . encrypt($pageshowpoint,$Encrypt) . "&amp;SearchBy=" . encrypt($_GET["SearchBy"],$Encrypt) . "&amp;sortBy=".encrypt('_Status',$Encrypt)."&amp;sortArrange=" . encrypt($sortArrange,$Encrypt) . $urlString . "' class='sort ".getSort('_Status')." TitleLink'>"; ?>Status<?php echo "</a>"; ?></td>
                              <td bgcolor="#D7E0F4" class="gridheader" height="25" align="center"><?php echo "<a href='?PageNo=" . encrypt($PageNo,$Encrypt) . "&amp;pageshowpoint=" . encrypt($pageshowpoint,$Encrypt) . "&amp;SearchBy=" . encrypt($_GET["SearchBy"],$Encrypt) . "&amp;sortBy=".encrypt('_Display',$Encrypt)."&amp;sortArrange=" . encrypt($sortArrange,$Encrypt) . $urlString . "' class='sort ".getSort('_Display')." TitleLink'>"; ?>Top Menu Display<?php echo "</a>"; ?></td>
                              <!--<td bgcolor="#D7E0F4" class="gridheader" height="25" align="center"><?php echo "<a href='?PageNo=" . encrypt($PageNo,$Encrypt) . "&amp;pageshowpoint=" . encrypt($pageshowpoint,$Encrypt) . "&amp;SearchBy=" . encrypt($_GET["SearchBy"],$Encrypt) . "&amp;sortBy=".encrypt('_Footer',$Encrypt)."&amp;sortArrange=" . encrypt($sortArrange,$Encrypt) . $urlString . "' class=' sort ".getSort('_Footer')." TitleLink'>"; ?>Footer Menu Display<?php echo "</a>"; ?></td>-->
															<td bgcolor="#D7E0F4" class="gridheader" height="25" align="center"><?php echo "<a href='?PageNo=" . encrypt($PageNo,$Encrypt) . "&amp;pageshowpoint=" . encrypt($pageshowpoint,$Encrypt) . "&amp;SearchBy=" . encrypt($_GET["SearchBy"],$Encrypt) . "&amp;sortBy=".encrypt('_Order',$Encrypt)."&amp;sortArrange=" . encrypt($sortArrange,$Encrypt) . $urlString . "' class=' sort ".getSort('_Order')." TitleLink'>"; ?>Top Menu Order<?php echo "</a>"; ?></td>
                              <!--<td bgcolor="#D7E0F4" class="gridheader" height="25" align="center"><?php echo "<a href='?PageNo=" . encrypt($PageNo,$Encrypt) . "&amp;pageshowpoint=" . encrypt($pageshowpoint,$Encrypt) . "&amp;SearchBy=" . encrypt($_GET["SearchBy"],$Encrypt) . "&amp;sortBy=".encrypt('_FooterOrder',$Encrypt)."&amp;sortArrange=" . encrypt($sortArrange,$Encrypt) . $urlString . "' class='sort ".getSort('_FooterOrder')." TitleLink'>"; ?>Footer Menu Order<?php echo "</a>"; ?></td>-->
															<?php if($CanEdit == 'Yes'){ ?>
															<td bgcolor="#D7E0F4" class="gridheader" height="25" align="center">Edit</td>
															<?php } ?>
															<!--<td bgcolor="#D7E0F4" class="gridheader" height="25" align="center">Level 2 Pages</td>-->
                              <?php if($CanDelete == 'Yes'){ ?>
                              <td bgcolor="#D7E0F4" class="gridheader" height="25" align="center">Delete</td>
                              <?php } ?>
                              </tr>
                              <?php
														if ($RecordCount > 0) {
                                $i = 1;
                                $Rowcolor = "gridline1";
                                while ($rs = mysql_fetch_array($result)) {
                                    $bil = $i + ($PageNo - 1) * $PageSize;
                                    if ($Rowcolor == "gridline2")
                                        $Rowcolor = "gridline1";
                                    else
                                        $Rowcolor = "gridline2";

                                    if ($id == $rs["_ID"]) {
                                        $Rowcolor = "gridline3";
                                    }
                                ?>
                               <tr>
                                <td id="Row1ID<?=$i?>" class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center"><?php echo $bil; ?>&nbsp;<input type="hidden" name="CatID<?php echo $i; ?>" value="<?php echo $rs["_ID"]; ?>" /></td>
                                <td id="Row2ID<?=$i?>" class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center" ><?php echo $rs["_PageTitle"]; ?></td>
                                <!--<td id="Row3ID<?=$i?>"  class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="left" ><?php if($rs["_PageTitle"]!="Sitemap" && $rs["_PageTitle"]!="Products"){echo $rs["_RedirectURL"];} ?>&nbsp;</td>-->
                                <td id="Row3ID<?=$i?>"  class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center" ><?php echo $rs["_Status"]; ?>&nbsp;</td>
                                <td id="Row4ID<?=$i?>" class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center"><input name="Display<?php echo $i; ?>" type="checkbox" value="Yes" <?php if ($rs['_Display'] == "Yes") {
                                echo " checked = 'checked' "; } ?> onclick="EnableDisableField(this.form.Display<?php echo $i; ?>, this.form.Order<?php echo $i; ?>);" /></td>
                               <!--	<td id="Row5ID<?=$i?>" class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center"><input name="Footer<?php echo $i; ?>" type="checkbox" value="Yes" <?php if ($rs['_Footer'] == "Yes") {
                                echo " checked = 'checked' "; } ?> /></td>-->
                                <td id="Row6ID<?=$i?>" class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center"><input type="text" style="width:30px;text-align:center;" name="Order<?php echo $i; ?>" value="<?php echo $rs['_Order']; ?>" size="1" class="txtbox1" onkeypress="return numbersonly(event);" <?php if($rs['_Display'] != "Yes") { echo " disabled='disabled' "; }  ?> /> </td>
                                <!--<td id="Row7ID<?=$i?>" class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center"><input type="text" style="width:30px; text-align:center;" name="FooterOrder<?php echo $i; ?>" value="<?php echo $rs['_FooterOrder']; ?>" size="1" class="txtbox1" onkeypress="return numbersonly(event);" <?php if($rs['_Footer'] != "Yes") { echo " disabled='disabled'"; }  ?> /></td>-->
                                <?php if($CanEdit == 'Yes'){ ?>
															<td id="Row8ID<?=$i?>" class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center">
																<?php if($rs['_Type']!="Home")
																		{ if ($rs['_Type'] != "Preview") { ?>
                                                                            <a href="edit1stlvlcms.php?id=<?=encrypt($rs["_ID"],$Encrypt) ?>" class="TitleLink1">Edit</a>
                                                                            <? }else{ echo "-"; }			
																		}else{?>
																			<a href="2ndlvlhomecms.php" class="TitleLink1"><?php if ($rs["_Type"] != "Static" && $rs["_Type"] != "Home") { ?>Edit<?php } else { echo "-"; } ?></a>		
																  <?php }?>
                                                            </td>
                                  <?php }?>                          
															<!--<td id="Row9ID<?=$i?>" class="<?php echo $Rowcolor; ?>" valign="top" align="center"><?php 
																if ($rs["_Type"] != "Static" && $rs['_Type'] != "Preview" && $rs['_PageTitle']!="Home") { 
																	if($rs["_Status"] == "Live"){?>
																		<a href="2ndlvlcms.php?SearchBy=<?=encrypt('SearchBy',$Encrypt)?>&amp;PID=<?php echo encrypt($rs["_ID"],$Encrypt); ?>" class="TitleLink">Manage</a><?php 
																	}
																	else{
																		echo "-";
																	}
																} 
																else {
																	echo "-";
																} ?>
															</td>-->
															 <?php if($CanDelete == 'Yes'){ ?>
                               <td id="Row10ID<?=$i?>" class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center"><?php if ($rs["_Type"] != "Static" && $rs["_Type"] != "Home") { ?>
                                 <a href="1stlvlcms_action.php?e_action=<?=encrypt('delete',$Encrypt)?>&amp;id=<?=encrypt($rs["_ID"],$Encrypt) ?>" class="TitleLink1" onclick=" return confirm('Are you sure you want to delete this?');">Delete</a><?php } else {
																	echo "-";
                                  } ?>
		                          </td>
		                          <?php }?>  
                                                        </tr>
                                                <?php
                                                    $i++;
                                                    }
												} else {
															echo "<tr><td colspan='9' align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
														}
                                                ?>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr><td height="5"></td></tr>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td valign="bottom" align="left">
                                                           <!-- <input type="button" class="button1" name="btnBack" value="< Back" onClick="javascript:history.back();">&nbsp;--><input style="width:100px;" type="button" class="button1" name="btnUpdateOrder" value="Update Order" onclick="return validateForm2();" />&nbsp;
														   <input style="width:100px;" type="button" class="button1" name="btnReset2" value="Clear" onclick="ClearAll();" /></td>
                                                        <td valign="bottom" align="right"><!--<a href="add1stlvlcms.php" class="TitleLink1">Add Page</a>--></td>
                                                    </tr>
                                                </table>
                                                </div>
											</td>
                                        </tr>
                                        <tr><td height="5"><input type="hidden" name="cntCheck" value="<?php echo $i - 1; ?>" /></td></tr>                                        
                                        <tr>
                                            <td width="100%">
                                                <div align="left">
															Page : <?php
                                                    if ($sProjectPrev != "") {
                                                        print $sProjectPrev . "&nbsp;&nbsp;";
                                                    }

                                                    if ((int) $MaxPage < (int) $pageshowend) {
                                                        $untilpage = (int) $MaxPage;
                                                    } else {
                                                        $untilpage = (int) $pageshowend;
                                                    }

                                                    if ((int) $untilpage == 0) {
                                                        $untilpage = 1;
                                                    }

                                                    for ($i = (int) $pageshowstart; $i <= (int) $untilpage; $i++) {
                                                        if ($i > 0) {
                                                            if ($i == $PageNo) {
                                                                print "<a href='?PageNo=" . encrypt($i,$Encrypt) . "&amp;pageshowpoint=" . encrypt((int) $pageshowpoint,$Encrypt) . "' class='menulink'>[" . $i . "]</a> ";
                                                            } else {
                                                                print "<a href='?PageNo=" . encrypt($i,$Encrypt) . "&amp;pageshowpoint=" . encrypt((int) $pageshowpoint,$Encrypt) . "' class='menulink'>" . $i . "</a> ";
                                                            }
                                                        }
                                                    }

                                                    if ($sProjectNext != "") {
                                                        print "&nbsp;&nbsp;" . $sProjectNext;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                            <?php                                               
                                                if ($result) {
                                                    mysql_free_result($result);
                                                }
                                                if ($TRecord) {
                                                    mysql_free_result($TRecord);
                                                }
                                            ?>
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

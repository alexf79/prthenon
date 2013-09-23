<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php'); 
    	
	$PageStatus = "Settings";	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo $sitename; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />	
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
						
						<td class="toptd" width="100%" align="left" valign="top">															
						<!--
						Start Contact
						-->
						<div class="m">
							<table cellpadding="0" cellspacing="" border="0" width="100%" style="padding-top:3px;">
								<tr>
								  <td align="left" class="TitleStyle" style="padding-left:3px;padding-top:1px;"><b>Settings</b></td>
								</tr>
								<tr><td height=""></td></tr>
							</table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="2" >			
                            <tr>
                            <td>	
                      		
							<ul>
									<?php
                                    
                                    //$str1 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID ='0' AND ".$tbname."_menu._ID='8' ORDER BY _Order ASC ";
									$str1 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID ='0' AND ".$tbname."_menu._ID='36' group by  ".$tbname."_menu._ID  ORDER BY _Order ASC ";
									
									$rst1 = mysql_query($str1, $connect) or die(mysql_error());
                                        if(mysql_num_rows($rst1) > 0)
                                        {		
                                            while($rs1 = mysql_fetch_assoc($rst1))
                                            {			
                                    ?>
                                        <!--<li>-->		
                                          	
                                            <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="admin_mainsettings.php"){ ?> <ul> <?php } ?>
                                            <?php
                                            $str2 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs1["_ID"] . "' ORDER BY _Order ASC ";
												$str2 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs1["_ID"] . "' AND _PageName IS NOT NULL group by  ".$tbname."_menu._ID  ORDER BY _Order ASC ";
                                                 
													$rst2 = mysql_query($str2, $connect) or die(mysql_error());
                                                    if(mysql_num_rows($rst2) > 0)
                                                    {
                                                        while($rs2 = mysql_fetch_assoc($rst2))
                                                        {					
                                            ?>
                                                        
                                                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;								
                                                    <a  class="TitleLink" <?php if($rs2["_PageName"]!="No"){ ?> href="<?php echo $rs2["_PageName"]; ?>" <?php } ?> ><?php echo $rs2["_Title"]; ?><br /></a>								
                                                    <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                    <?php
                                                    $str3 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs2["_ID"] . "' group by ".$tbname."_menu._PageName ORDER BY _Order ASC ";				
                                                            $rst3 = mysql_query($str3, $connect) or die(mysql_error());
                                                            if(mysql_num_rows($rst3) > 0)
                                                            {
                                                                while($rs3 = mysql_fetch_assoc($rst3))
                                                                {							
                                                    ?>
                                                                
                                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                            <a class="shortcut" <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php } ?>><?php echo $rs3["_Title"]; ?></a>				
                                                                <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>
                                                                <?php
                                                                $str4 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs3["_ID"] . "' ORDER BY _ID ASC ";				
                                                                        $rst4 = mysql_query($str4, $connect) or die(mysql_error());
                                                                        if(mysql_num_rows($rst4) > 0)
                                                                        {
                                                                            while($rs4 = mysql_fetch_assoc($rst4))
                                                                            {							
                                                                ?>
                                                                            
                                                                    <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
                                                                        <a class="shortcut" <?php if($rs4["_PageName"]!="No"){ ?> href="<?php echo $rs4["_PageName"]; ?>" <?php } ?>><?php echo $rs4["_Title"]; ?></a>				
                                                                    </li>		
                                                                <?php
                                                                            }
                                                                        }
                                                                ?>
                                                                <?php if($rs3["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                                        </li>		
                                                    <?php
                                                                }
                                                            }
                                                    ?>
                                                    <?php if($rs2["_PageName"]=="No"){ ?> </ul> <?php } ?>
                                                </li>		
                                            <?php
                                                        }
                                                    }			
                                            ?>
                                            <?php if($rs1["_PageName"]=="No" || $rs1["_PageName"]=="admin_mainsettings.php"){ ?> </ul> <?php } ?>
                                        <!--</li>-->
                                    <?php							
                                            }
                                        } 
                                    ?>	
                                    </ul>
                                    <br />
                                    </td>
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
?>
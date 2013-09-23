<?php
include('../global.php');		
if (date("H") < 12)
{
$greet = "Good Morning";
}
elseif (date("H") >= 12 && date("H")  <= 18)
{
$greet = "Good Afternoon";
}
else
{
$greet = "Good Evening";
}
?>
<?php
$userid = $_SESSION['userid'];
$level = $_SESSION['level'];
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	
	
<tr>
	<td>
  	<a href="main.php">
			<img src="../images/logo.png" border="0" alt="<?php $appname ?>" />
		</a>
	</td>
	<td valign="middle">
  	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
    	<tr>
      	<td align="right" style="padding-right:12px;" valign="bottom" class="Twelve_Blackfont_bold"><span style="padding-bottom:5px; float:right;">&nbsp;<b><?php echo $greet; ?>&nbsp;<i><?php echo $_SESSION['name']; ?></i>, Welcome to <?php echo $sitename; ?> Admin Site.</b></span></td>
      </tr>
      <tr>
        <td align="right" valign="bottom" class="Twelve_Blackfont_bold"><span style="padding-bottom:5px; float:right;">&nbsp;
        &nbsp;<b><?php echo date("j M Y g:i:s A"); ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</span>
        </td>
       </tr>
      <tr>
        <td align="right" style="padding-right:12px;" colspan="2"><span style="padding-bottom:10px;">&nbsp;
			  	<a class="TitleLink1" href="userprofile.php">My Profile</a>
			  	&nbsp;|&nbsp;
			  	<a class="TitleLink1" href="logout.php">Logout</a>
			  	</span>
				</td>
      </tr>
		</table>
	</td>
</tr>	
<tr>
<td colspan="2">
<div id="header-box">
	
	<div id="module-menu">
	<ul id="menu">
<?php
// Check for normal user
//if($_SESSION['levelid']!=3)
$str1 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID ='0' AND _UserID = '" . $_SESSION['levelid'] . "' AND ".$tbname."_menu._ID  <> 9 group by ".$tbname."_menu._ID ORDER BY _Order ASC ";
//echo $str1;
//else
//$str1 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID ='0' AND _UserID = '" . $_SESSION['groupid'] . "' AND ".$tbname."_menu._ID  <> 8  group by ".$tbname."_menu._ID ORDER BY _Order ASC ";
//echo $str1;
$rst1 = mysql_query($str1, $connect) or die(mysql_error());
if(mysql_num_rows($rst1) > 0)
{		
    while($rs1 = mysql_fetch_assoc($rst1))
    {
?>

    <li>
     
    <a <?php if($rs1["_PageName"]!="#"){ ?> href="<?php echo $rs1["_PageName"]; ?>" 
    	<? if($rs1["_ID"]==8)echo " target='_blank' ";  ?>
    	 <?php }else{ ?> class="MenuBarItemSubmenu" href="<?php echo $rs1["_PageName"]; ?>" <?php } ?> ><?php echo $rs1["_Title"]; ?></a>
    <?php if($rs1["_PageName"]=="#"){ ?> <ul> <?php } ?>
    <?php
    $str2 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs1["_ID"] . "' AND _UserID = '" . $_SESSION['levelid'] . "'   GROUP BY ".$tbname."_menu._Title ORDER BY _Order ASC ";
	
    $rst2 = mysql_query($str2, $connect) or die(mysql_error());
    if(mysql_num_rows($rst2) > 0)
    {
        while($rs2 = mysql_fetch_assoc($rst2))
        {
		
    ?>

    <li>
    <a <?php if($rs2["_PageName"]!="#"){ ?> href="<?php echo $rs2["_PageName"];?>"  <?php echo "class='SecLayer'"; }else{ ?> class=MenuBarItemSubmenu <?php } ?> ><?php echo $rs2["_Title"]; ?></a>
    <?php if($rs2["_PageName"]=="#"){ ?> <ul> <?php } ?>

    <?php
    $str3 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs2["_ID"] . "' AND _PID <>'36' ORDER BY _Order ASC ";
    $rst3 = mysql_query($str3, $connect) or die(mysql_error());
    if(mysql_num_rows($rst3) > 0)
    {
        while($rs3 = mysql_fetch_assoc($rst3))
        {
    ?>

    <li>
    <a <?php if($rs3["_PageName"]!="#"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php echo "class='SecLayer'"; }else{ ?> class=MenuBarItemSubmenu <?php } ?> ><?php echo $rs3["_Title"]; ?></a>
    <?php if($rs3["_PageName"]=="#"){ ?> <ul> <?php } ?>

    <?php
    $str4 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs3["_ID"] . "' AND _PID <>'36' ORDER BY _Order ASC ";
    $rst4 = mysql_query($str4, $connect) or die(mysql_error());
	
    if(mysql_num_rows($rst4) > 0)
    {
        while($rs4 = mysql_fetch_assoc($rst4))
        {
    ?>
    <li>
    <a <?php if($rs4["_PageName"]!="#"){ ?> href="<?php echo $rs4["_PageName"]; ?>" <?php echo "class='SecLayer'"; }else{ ?> class=MenuBarItemSubmenu <?php } ?>><?php echo $rs4["_Title"]; ?></a>
    <?php if($rs4["_PageName"]=="#"){ ?> <ul> <?php } ?>
    <?php
    $str5 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . replaceSpecialChar($rs4["_ID"]) . "' AND _PID <>'36' ORDER BY _Order ASC ";
    $rst5 = mysql_query($str5, $connect) or die(mysql_error());
	//echo $str5;
    if(mysql_num_rows($rst5) > 0)
    {
        while($rs5 = mysql_fetch_assoc($rst5))
        {
    ?>
    <li>
    <a <?php if($rs5["_PageName"]!="#"){ ?> href="<?php echo $rs5["_PageName"]; ?>" <?php echo "class='SecLayer'"; }else{ ?> class=MenuBarItemSubmenu <?php } ?>><?php echo $rs5["_Title"]; ?></a>
    </li>
    <?php
        }
    }
    ?>
    <?php if($rs4["_PageName"]=="#"){ ?> </ul> <?php } ?>
    </li>
    <?php
        }
    }
    ?>
    <?php if($rs3["_PageName"]=="#"){ ?> </ul> <?php } ?>
    </li>
    <?php
        }
    }
    ?>
    <?php if($rs2["_PageName"]=="#"){ ?> </ul> <?php } ?>
    </li>
	<li class="separator"><span></span></li>
    <?php
        }
    }
    ?>
    <?php if($rs1["_PageName"]=="#"){ ?> </ul> <?php } ?>
    </li>
<?php							
    }
} 
?>	
</ul>
</div>
<div class="clr"></div>
</div>
</td>
</tr>


</table>
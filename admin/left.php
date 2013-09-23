<!--<LINK href="../css/adminmenubar.css" type=text/css rel=stylesheet>-->
<script src="../js/adminmenubar.js" type="text/javascript"></script>
<?php	
include('../global.php');
?>
<ul class="MenuBarVertical" id="MenuBar2" style="min-height:525px;">
<?php
// Check for normal user
//if($_SESSION['levelid']!=3)
$str1 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID ='0' group by ".$tbname."_menu._ID ORDER BY _Order ASC ";
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
    <a <?php if($rs1["_PageName"]!="No"){ ?> href="<?php echo $rs1["_PageName"]; ?>" 
    	<? if($rs1["_ID"]==8)echo " target='_blank' "; ?>
    	 <?php }else{ ?> class="MenuBarItemSubmenu" <?php } ?> ><?php echo $rs1["_Title"]; ?></a>
    <?php if($rs1["_PageName"]=="No"){ ?> <ul> <?php } ?>
    <?php
    $str2 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs1["_ID"] . "' AND _PID <>'36' GROUP BY ".$tbname."_menu._Title ORDER BY _Order ASC ";
	
    $rst2 = mysql_query($str2, $connect) or die(mysql_error());
    if(mysql_num_rows($rst2) > 0)
    {
        while($rs2 = mysql_fetch_assoc($rst2))
        {
		
    ?>

    <li>
    <a <?php if($rs2["_PageName"]!="No"){ ?> href="<?php echo $rs2["_PageName"];?>"  <?php echo "class='SecLayer'"; }else{ ?> class=MenuBarItemSubmenu <?php } ?> ><?php echo $rs2["_Title"]; ?></a>
    <?php if($rs2["_PageName"]=="No"){ ?> <ul> <?php } ?>

    <?php
    $str3 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs2["_ID"] . "' AND _PID <>'36' ORDER BY _Order ASC ";
    $rst3 = mysql_query($str3, $connect) or die(mysql_error());
    if(mysql_num_rows($rst3) > 0)
    {
        while($rs3 = mysql_fetch_assoc($rst3))
        {
    ?>

    <li>
    <a <?php if($rs3["_PageName"]!="No"){ ?> href="<?php echo $rs3["_PageName"]; ?>" <?php echo "class='SecLayer'"; }else{ ?> class=MenuBarItemSubmenu <?php } ?> ><?php echo $rs3["_Title"]; ?></a>
    <?php if($rs3["_PageName"]=="No"){ ?> <ul> <?php } ?>

    <?php
    $str4 = "SELECT ".$tbname."_menu._ID , ".$tbname."_menu._PID, ".$tbname."_menu._Title, ".$tbname."_menu._PageName, ".$tbname."_accessright._UserID FROM (".$tbname."_accessright join ".$tbname."_menu on((".$tbname."_accessright._MID = ".$tbname."_menu._ID))) WHERE _PID = '" . $rs3["_ID"] . "' AND _PID <>'36' ORDER BY _Order ASC ";
    $rst4 = mysql_query($str4, $connect) or die(mysql_error());
	
    if(mysql_num_rows($rst4) > 0)
    {
        while($rs4 = mysql_fetch_assoc($rst4))
        {
    ?>
    <li>
    <a <?php if($rs4["_PageName"]!="No"){ ?> href="<?php echo $rs4["_PageName"]; ?>" <?php echo "class='SecLayer'"; }else{ ?> class=MenuBarItemSubmenu <?php } ?>><?php echo $rs4["_Title"]; ?></a>
    <?php if($rs4["_PageName"]=="No"){ ?> <ul> <?php } ?>
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
    <a <?php if($rs5["_PageName"]!="No"){ ?> href="<?php echo $rs5["_PageName"]; ?>" <?php echo "class='SecLayer'"; }else{ ?> class=MenuBarItemSubmenu <?php } ?>><?php echo $rs5["_Title"]; ?></a>
    </li>
    <?php
        }
    }
    ?>
    <?php if($rs4["_PageName"]=="No"){ ?> </ul> <?php } ?>
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
    <?php if($rs1["_PageName"]=="No"){ ?> </ul> <?php } ?>
    </li>
<?php							
    }
} 
?>	
</ul>
<script language="JavaScript" type="text/javascript">
<!--
    var MenuBar2 = new Spry.Widget.MenuBar("MenuBar2", {imgRight:"Menu/tri-right1.gif"});
//-->
</script>
<div style="height:200px;"></div>

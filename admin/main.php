<?php
session_start();
?>
<?php	
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
echo "<script language='javascript'>window.location='login.php';</script>";
}
else
{
include('../global.php');
include('../dbopen.php');
include('../include/functions.php');  
mysql_select_db($database, $connect) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $appname; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />	
<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />	
<script type="text/javascript" src="../js/validate.js"></script>
<script type="text/javascript" language="javascript">
    <!--
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
                
				<!--- Today Orders List Start  -->
                 <tr>
                     <td width="100%" align="left" valign="top" class="toptd TitleStyle"><b><span style="float:left; padding-top:15px; padding-left:15px;">Dashboard</span></b><br/><br/>
					  
					  
					  
					  
					  <div class="m">
 					  <table width="100%" class="grid" style="border-bottom:1px solid #B7B6B6;" cellspacing="1" cellpadding="2">
						
						<tr>
                            <td class="gridheader" align="center" colspan="4">
                            <b>Login History For&nbsp;<?php echo date("F Y");?></b>&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td class="gridheader" align="center" width="20%">&nbsp;<b>User Name</b>&nbsp;</td>
                            <td class="gridheader" align="center" width="21%">&nbsp;<b>IP Address</b>&nbsp;</td>
                            <td class="gridheader" align="center" width="22%">&nbsp;<b>Date / Time In</b>&nbsp;</td>
                            <td class="gridheader" align="center" width="22%">&nbsp;<b>Date / Time Out</b>&nbsp;</td>
                        </tr>
                        <?php
                        $i = 1;
                        $Rowcolor = "gridline1";
                        $sql1 = "SELECT * FROM ".$tbname."_logginglog INNER JOIN ".$tbname."_user ON ".$tbname."_logginglog._UserID = ".$tbname."_user._ID WHERE YEAR(_DateTimeIn) = '" . date("Y") . "' AND MONTH(_DateTimeIn) = '" . date("n") . "' AND ".$tbname."_logginglog._UserID = '" . replaceSpecialChar($_SESSION['userid']) . "' GROUP BY _DateTimeIn DESC LIMIT 0,5";
                        $rst1 = mysql_query($sql1, $connect);
                        if(mysql_num_rows($rst1) > 0)
                        {
                            while ($row1 = mysql_fetch_array($rst1))
                            {
                            if($Rowcolor == "gridline2")
                            $Rowcolor = "gridline1";
                            elseif ($Rowcolor == "gridline1")
                            $Rowcolor = "gridline2";
                            ?>
                            <tr>
                                <td class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $row1['_Username']; ?>&nbsp;</td>
                                <td class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php echo $row1['_IPAddress']; ?>&nbsp;</td>
                                <td class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php if($row1['_DateTimeIn'] != "") { echo date("j M Y g:i:s A", strtotime($row1['_DateTimeIn'])); } ?>&nbsp;</td>
                                <td class="<?php echo $Rowcolor; ?>" align="center">&nbsp;<?php if($row1['_DateTimeOut'] != "") { echo date("j M Y g:i:s A", strtotime($row1['_DateTimeOut'])); } ?>&nbsp;</td>
                            </tr>
                        <?php
                            }                           
                        }
                        ?>
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
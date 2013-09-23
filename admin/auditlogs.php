<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
echo "<script type='text/javascript' language='javascript'>window.location='login.php';</script>";
}
else
{
include('../global.php');
include('../dbopen.php');
include('../include/functions.php');  
/* START SCRIPT FOR ENCRYPT */
if(isset($_GET['Submit']) && $_GET['Submit'] == 'Submit')
	{
	$a=0;
	foreach($_GET as $k=>$v)       
	{       
		$a++;
	  if($k != 'Submit')
		{
			if($a == 1)
			{
				$extra.= $k.'='.encrypt($v,$Encrypt);  
			}else{
				$extra.= '&'.$k.'='.encrypt($v,$Encrypt);  
			}
		}
	}
	//echo $extra;
	echo "<script language='JavaScript'>window.location = 'auditlogs.php?".$extra."';</script>";
	exit();
}
mysql_select_db($database, $connect) or die(mysql_error());
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
<script type="text/javascript" src="../jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>   
<script language="javascript" type="text/javascript">
<!--
function validateForm()
{
	var errormsg;
	errormsg = "";
	var date1=document.AuditLog.From.value;	
	var tmpdate1=date1.split("/");	
	var date2=document.AuditLog.To.value;
	var tmpdate2=date2.split("/");
	
	if(date1=="" || date1=="DD/MM/YYYY")
	{
		//errormsg += "Please choose From Date.\n";
	}	
	else
	{			
		if (!isDate(tmpdate1[2], tmpdate1[1], tmpdate1[0]))
				errormsg += "Please select a valid 'From Date'.\n";
	}
					
	if(date2=="" || date2=="DD/MM/YYYY")
	{
		//errormsg += "Please choose To Date.\n";
	}	
	else
	{
		if (!isDate(tmpdate2[2], tmpdate2[1], tmpdate2[0]))
				errormsg += "Please select a valid 'To Date'.\n";
	}
	
	if(date1!="" && date1!="DD/MM/YYYY" && date2 !="" && date2!="DD/MM/YYYY")
	{	
		var tmpdate11 = new Date(tmpdate1[2], tmpdate1[1], tmpdate1[0]);
		var tmpdate22 =new Date(tmpdate2[2], tmpdate2[1], tmpdate2[0]);
			
		if ( tmpdate22 < tmpdate11 )
			errormsg += "'From Date' should be earlier than 'To Date'.\n";
	}
	
	/*if (document.AuditLog.LogType.value == "")
    errormsg += "Please select a Log Type.\n";*/

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

$(function(){
	$('.datepicker').datepicker({
		changeDate: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		yearRange: '1900:+0'
	});			
});
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
                    <td width="850" align="center" valign="top"><!--TD Start-->
                        <table width="835" border="0" cellspacing="0" cellpadding="0">
                            <tr><td align="left" class="TitleStyle"><b>Reports &gt; Audit Logs</b></td></tr>
                            <tr><td height="10"></td></tr>
                            <tr>
                                <td align="left">
                                    <table width="825" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td height="5"></td></tr>
                                        <tr>
                                        <td>
                                        <form action="auditlogs.php" name="AuditLog" method="get" onsubmit="return validateForm();">
                                        <table width="825" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="99">From</td>
                                          <td width="10">:</td>
                                          <td width="726">
                                          		<input id="From"  name="From" type="text" autocomplete="off" class="datepicker" size="10" readonly="readonly" value="<?=($_GET['From']!="" ? $_GET['From'] : "DD/MM/YYYY")?>" style="font-family: Arial; font-size: 11px; margin-top:2px;" />    
                                          &nbsp;&nbsp;
										  <span style="vertical-align:center;">To : </span>
                                          		<input id="To"  name="To" type="text" autocomplete="off" class="datepicker" size="10" readonly="readonly" value="<?=($_GET['To']!="" ? $_GET['To'] : "DD/MM/YYYY")?>" style="font-family: Arial; font-size: 11px; margin-top:2px;" />       
                                          </td>
                                        </tr>
                                        <tr><td height="5"></td></tr>
                                        <tr>
                                            <td>Username</td>
                                            <td>:</td>
                                            <td><input type="text" autocomplete="off" id="Username" name="Username" value="<?php echo trim($_GET['Username']); ?>" style="width:190px;" class="txtbox1" /></td>
                                        </tr>                                         
                                        <tr><td height="5"></td></tr>
                                        <!--<tr>
                                            <td>Log Type</td>
                                            <td>:</td>
                                            <td>-->
                                            	<?php 
                                            	$sql = "SELECT _LogTypeName FROM ".$tbname."_logtype where _ID = 1";
                                              $rst = mysql_query($sql, $connect);
                                              $rs = mysql_fetch_assoc($rst);
                                              ?>    
                                              <input type="hidden" name="LogType" value="<?php echo $rs['_LogTypeName'];?>" />   
                                            	<!--<select name="LogType" class="dropdown1" onchange="document.getElementById('DivHistoryLog').style.display = (this.value == 'History Log' ? 'block' : 'none' );">-->
                                            	<!--	<select name="LogType" class="dropdown1" >
                                                    <?php
                                                        $sql = "SELECT _LogTypeName FROM ".$tbname."_logtype where _ID = 1";
                                                        $rst = mysql_query($sql, $connect);
                                                        if(mysql_num_rows($rst) > 0)
                                                        {
                                                            while($rs = mysql_fetch_assoc($rst))
                                                            {
                                                    ?>
                                                                <option value="<?php echo $rs['_LogTypeName'];?>" <?php if($rs['_LogTypeName'] == $_GET['LogType']) { ?>  selected="selected" <?php } ?> ><?php echo $rs['_LogTypeName']; ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
												<font style=" vertical-align: top; color: rgb(255, 0, 0);">*</font>
                                            </td>
                                        </tr>
                                        <tr><td height="5"></td></tr>-->
                                        <tr>
                                            <td colspan="3">
                                                <div id="DivHistoryLog" style="display:<?=(trim($_GET['LogType']) == "History Log" ? "block;" : "none;")?>">
                                                    <table width="835" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="100">Event</td>
                                                            <td width="10">:</td>
                                                            <td width="725"><input type="text" autocomplete="off" id="Event" name="Event" value="<?php echo (trim($_GET['LogType']) == "History Log" ? trim($_GET['Event']) : ""); ?>" size="30" class="txtbox1" /></td>
                                                        </tr>
                                                        <tr><td height="5"></td></tr>
                                                        <tr>
                                                            <td>Event Item</td>
                                                            <td>:</td>
                                                            <td><input type="text" autocomplete="off" id="EventItem" name="EventItem" value="<?php echo (trim($_GET['LogType']) == "History Log" ? trim($_GET['EventItem']) : ""); ?>" size="30" class="txtbox1" /></td>
                                                        </tr>
                                                        <tr><td height="2"></td></tr>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><input type="submit" name="Submit" value="Submit" class="button1" /></td>
                                        </tr>
                                        </table>
                                        </form>
                                        </td>
                                        </tr>
                                        <?php
                                        if ($_GET["LogType"] != "")
                                        {
										$sortBy = trim($_GET["sortBy"]);
										$sortArrange = trim($_GET["sortArrange"]);
										
										$Username  = trim($_GET["Username"]);
										$LogType  = trim($_GET["LogType"]);
										$Event  = trim($_GET["Event"]);
										$EventItem  = trim($_GET["EventItem"]);	
                                        $LogType  = trim($_GET["LogType"]);
										
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
											$StartDate = $FromYr . "-" . $FromMth . "-" . $FromDay . " 00:00:00";
											}else
											{
											$StartDate = "";
											}
											if($ToDay <> "" && $ToMth <> "" &&  $ToYr <> "")
											{
											$EndDate = $ToYr . "-" . $ToMth . "-" . $ToDay . " 23:59:59";
											}else
											{
											$EndDate = "";
											}
										}

										//$urlString = "&Username=".replaceSpecialChar($Username)."&LogType=".replaceSpecialChar($LogType)."&Event=".replaceSpecialChar($Event)."&EventItem=".replaceSpecialChar($EventItem)."&From=".$From."&To=".$To."";
										$urlString = "";
										
										/*$urlString = "&amp;Username=".encrypt($Username,$Encrypt)."&amp;LogType=".encrypt($LogType,$Encrypt)."&amp;Event=".encrypt($Event,$Encrypt)."&amp;EventItem=".encrypt($EventItem,$Encrypt)."";*/

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
                                       
									   if($LogType=="Login Log"){
											
											$str1 = "SELECT *, U._Username
													 FROM ".$tbname."_logginglog L
													 INNER JOIN ".$tbname."_user U ON U._ID = L._UserID
													 WHERE L._ID IS NOT NULL ";

											if ($Username != ""){
												$str1 .= "AND _Username LIKE '%".replaceSpecialChar($Username)."%' ";
											}
											
											if ($StartDate != ""){
												$str1 = $str1 . "AND _DateTimeIn >= '".replaceSpecialChar($StartDate)."' ";
											}
											
											if ($EndDate != ""){
												$str1 = $str1 . "AND _DateTimeIn <= '".replaceSpecialChar($EndDate)."' ";
											}
											//
											$str2 = $str1;
											
											if (trim($sortBy) != "" && trim($sortArrange) != "")	{
											
												if($sortBy == "_IPAddress"){
													$sortBy = "L._IPAddress";
												}
											
												$str2 = $str2 . "ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
											}else{
												$str2 = $str2 . "ORDER BY _DateTimeIn DESC LIMIT $StartRow,$PageSize ";
											}
                                        
										}else if($LogType="History Log") {
											
											$str1 = "SELECT log.*, _Username ";
											$str1 .= "FROM ".$tbname."_auditlog log INNER JOIN ".$tbname."_user usr ON log._UserID = usr._ID ";
											$str1 .= "WHERE log._ID IS NOT NULL ";
											if ($Username != "")
											{
												$str1 .= "AND _Username LIKE '%".replaceSpecialChar($Username)."%' ";
											}
											if ($StartDate != "")
											{
												$str1 .= "AND _LogDate >= '".replaceSpecialChar($StartDate)."' ";
											}
											if ($EndDate != "")
											{
												$str1 .= "AND _LogDate <= '".replaceSpecialChar($EndDate)."' ";
											}
											if ($Event != "")
											{
												$str1 .= "AND _Event LIKE '%".replaceSpecialChar($Event)."%' ";
											}
											if ($EventItem != "")
											{
												$str1 .= "AND _EventItem LIKE '%".replaceSpecialChar($EventItem)."%' ";
											}
											
											$str2 = $str1;
											if (trim($sortBy) != "" && trim($sortArrange) != "")
											{
																							
												$str2 = $str2 . "ORDER BY ".trim($sortBy)." ".trim($sortArrange)." LIMIT $StartRow,$PageSize ";
											}
											else
											{
												$str2 = $str2 . "ORDER BY _LogDate DESC LIMIT $StartRow,$PageSize ";
											}
										}
										
										//echo $str2;
										
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
										
										/*''''''''''''''''''''''''''''''''''''''''''''''''''''''''*/
										$pageshowlimit = 20;
										$pageshowpoint = $_GET['pageshowpoint'];
										if($pageshowpoint != "" && is_numeric($pageshowpoint))
										{
											$pageshowpoint = (int)$pageshowpoint;
										}
										else
										{
											$pageshowpoint = 0;
										}
										$pageshowstart = (int)$pageshowpoint + 1;
										$pageshowend = (int)$pageshowpoint + (int)$pageshowlimit;
										
										if((int)$pageshowpoint == 0)
										{
											$sProjectPrev = "";
										}
										elseif((int)$pageshowpoint > 0)
										{
											$sProjectPrev = "<a href='?PageNo=".((int)$pageshowpoint - (int)$pageshowlimit + 1)."&amp;pageshowpoint=".((int)$pageshowpoint - (int)$pageshowlimit)."&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange.$urlString."' class='menulink'>Previous ".$pageshowlimit."</a> ";
										}
										
										if((int)$MaxPage <= (int)$pageshowend)
										{
											$sProjectNext = "";
										}
										elseif((int)$MaxPage > (int)$pageshowend)
										{
											$sProjectNext = "<a href='?PageNo=".((int)$pageshowpoint + (int)$pageshowlimit + 1)."&amp;pageshowpoint=".((int)$pageshowpoint + (int)$pageshowlimit)."&amp;sortBy=".$sortBy."&amp;sortArrange=".$sortArrange.$urlString."' class='menulink'>Next ".$pageshowlimit."</a> ";
										}
										/*''''''''''''''''''''''''''''''''''''''''''''''''''''''''*/
										
										if($RecordCount > 0)
										{
                                        ?>
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                    
                                                    <tr>
                                                        <td width="100%">
                                                            <span style="text-align:left;float:left;">
                                                         Page : <?php
                                     $QureyUrl = "&amp;From=".encrypt($_GET['From'],$Encrypt)."&amp;To=".encrypt($_GET['To'],$Encrypt)."&amp;Username=".encrypt($_GET['Username'],$Encrypt)."&amp;LogType=".encrypt($_GET['LogType'],$Encrypt)."&amp;sortBy=".encrypt($sortBy,$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt)."";
										//if($MaxPage > 1) echo "Page: ";
										for ($i=1; $i<=$MaxPage; $i++)
										{
											if ($i == $PageNo)
											{
												print "<a href='?PageNo=".encrypt($i,$Encrypt). $QureyUrl ."' class='menulink'>[".$i."]</a> ";
											}
											else
											{
												print "<a href='?PageNo=" . encrypt($i,$Encrypt) . $QureyUrl ."' class='menulink'>".$i."</a> ";
											}
										}
										
									if (trim($sortArrange) == "DESC")
										$sortArrange = "ASC";
									elseif (trim($sortArrange) == "ASC")
										$sortArrange = "DESC";
									else
										$sortArrange = "DESC";
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
                                                            <?php 
                                                                if($LogType=="Login Log")
                                                                {
                                                                	if ($_GET['sortArrange'] == "DESC")
                                                                    $_GET['sortArrange'] = "ASC";
	                                                                elseif ($_GET['sortArrange'] == "ASC")
	                                                                    $_GET['sortArrange'] = "DESC";
	                                                                else
	                                                                    $_GET['sortArrange'] = "DESC";
                                                                
                                                            ?>
																<table width="100%" class="grid" cellspacing="1" cellpadding="2">
																	<tr>
																		<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b>No.</b>&nbsp;</td>
																		<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b><?php echo "<a href='?PageNo=".encrypt($PageNo,$Encrypt)."&amp;From=".encrypt($_GET['From'],$Encrypt)."&amp;To=".encrypt($_GET['To'],$Encrypt)."&amp;Username=".encrypt($_GET['Username'],$Encrypt)."&amp;LogType=".encrypt($_GET['LogType'],$Encrypt)."&amp;sortBy=".encrypt('_Username',$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt).$urlString."' class='TitleLink'>"; ?>Username<?php echo "</a>"; ?></b>&nbsp;</td>
																		<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b><?php echo "<a href='?PageNo=".encrypt($PageNo,$Encrypt)."&amp;From=".encrypt($_GET['From'],$Encrypt)."&amp;To=".encrypt($_GET['To'],$Encrypt)."&amp;Username=".encrypt($_GET['Username'],$Encrypt)."&amp;LogType=".encrypt($_GET['LogType'],$Encrypt)."&amp;sortBy=".encrypt('_IPAddress',$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt).$urlString."' class='TitleLink'>"; ?>IP Address<?php echo "</a>"; ?></b>&nbsp;</td>
																		<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b><?php echo "<a href='?PageNo=".encrypt($PageNo,$Encrypt)."&amp;From=".encrypt($_GET['From'],$Encrypt)."&amp;To=".encrypt($_GET['To'],$Encrypt)."&amp;Username=".encrypt($_GET['Username'],$Encrypt)."&amp;LogType=".encrypt($_GET['LogType'],$Encrypt)."&amp;sortBy=".encrypt('_DateTimeIn',$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt).$urlString."' class='TitleLink'>"; ?>Date / Time In<?php echo "</a>"; ?></b>&nbsp;</td>
																		<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b><?php echo "<a href='?PageNo=".encrypt($PageNo,$Encrypt)."&amp;&amp;From=".encrypt($_GET['From'],$Encrypt)."&amp;To=".encrypt($_GET['To'],$Encrypt)."&amp;Username=".encrypt($_GET['Username'],$Encrypt)."&amp;LogType=".encrypt($_GET['LogType'],$Encrypt)."&amp;sortBy=".encrypt('_DateTimeOut',$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt).$urlString."' class='TitleLink'>"; ?>Date / Time Out<?php echo "</a>"; ?></b>&nbsp;</td>
																	</tr>
                                                                        <?php
                                                                            $i = 1;
                                                                            $Rowcolor = "gridline1";
                                                                            while ($row = mysql_fetch_array($result)) 
                                                                            {
                                                                                $bil = $i + ($PageNo-1)*$PageSize;
                                                                                if ($Rowcolor == "gridline2")
                                                                                    $Rowcolor = "gridline1";
                                                                                elseif ($Rowcolor == "gridline1")
                                                                                    $Rowcolor = "gridline2";
                                                                        ?>
                                                                                <tr>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" align="center" width="35">&nbsp;<?php echo $bil; ?>.&nbsp;</td>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" align="center" width="230">&nbsp;<?php echo $row['_Username']; ?>&nbsp;</td>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" align="center" width="230">&nbsp;<?php echo $row['_IPAddress']; ?>&nbsp;</td>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" align="center" width="240">&nbsp;<?php if($row['_DateTimeIn'] != "") { echo date("j M Y g:i:s A", strtotime($row['_DateTimeIn'])); } ?>&nbsp;</td>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" align="center" width="240">&nbsp;<?php if($row['_DateTimeOut'] != "") { echo date("j M Y g:i:s A", strtotime($row['_DateTimeOut'])); } ?>&nbsp;</td>
                                                                                </tr>
                                                                        <?php
                                                                                $i++;
                                                                            }
                                                                        ?>
                                                                    </table>
                                                            <?php
                                                                }
                                                                else if($LogType=="History Log")
                                                                {
                                                            ?>
													<table width="100%" class="grid" cellspacing="1" cellpadding="2">
														<tr>
															<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b>No.</b>&nbsp;</td>
															<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b><?php echo "<a href='?PageNo=".encrypt($PageNo,$Encrypt)."&amp;sortBy=".encrypt('_Username',$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt).$urlString."' class='TitleLink'>"; ?>Username<?php echo "</a>"; ?></b>&nbsp;</td>
															<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b><?php echo "<a href='?PageNo=".encrypt($PageNo,$Encrypt)."&amp;sortBy=".encrypt('_IPAddress',$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt).$urlString."' class='TitleLink'>"; ?>IP Address<?php echo "</a>"; ?></b>&nbsp;</td>
															<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b><?php echo "<a href='?PageNo=".encrypt($PageNo,$Encrypt)."&amp;sortBy=".encrypt('_LogDate',$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt).$urlString."' class='TitleLink'>"; ?>Log Date / Time<?php echo "</a>"; ?></b>&nbsp;</td>
															<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b><?php echo "<a href='?PageNo=".encrypt($PageNo,$Encrypt)."&amp;&amp;sortBy=".encrypt('_Event',$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt).$urlString."' class='TitleLink'>"; ?>Event<?php echo "</a>"; ?></b>&nbsp;</td>
															<td bgcolor="#D7E0F4" class="gridheader" align="center" height="25">&nbsp;<b><?php echo "<a href='?PageNo=".encrypt($PageNo,$Encrypt)."&amp;sortBy=".encrypt('_EventItem',$Encrypt)."&amp;sortArrange=".encrypt($sortArrange,$Encrypt).$urlString."' class='TitleLink'>"; ?>Event Item<?php echo "</a>"; ?></b>&nbsp;</td>
														</tr>
														<?php
															$i = 1;
															$Rowcolor = "gridline1";
															while ($row = mysql_fetch_array($result)) 
															{
																$bil = $i + ($PageNo-1)*$PageSize;
																if ($Rowcolor == "gridline2")
																	$Rowcolor = "gridline1";
																elseif ($Rowcolor == "gridline1")
																	$Rowcolor = "gridline2";
														?>
                                                                                <tr>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center" width="35">&nbsp;<?php echo $bil; ?>.&nbsp;</td>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center" width="100">&nbsp;<?php echo $row['_Username']; ?>&nbsp;</td>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center" width="100">&nbsp;<?php echo $row['_IPAddress']; ?>&nbsp;</td>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="center" width="180">&nbsp;<?php if($row['_LogDate'] != "") { echo date("j M Y g:i:s A", strtotime($row['_LogDate'])); } ?>&nbsp;</td>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="left" width="200"><?php echo $row['_Event']; ?>&nbsp;</td>
                                                                                    <td class="<?php echo $Rowcolor; ?>" height="25" valign="top" align="left" width="360"><?php echo $row['_EventItem']; ?>&nbsp;</td>
                                                                                </tr>
                                                                        <?php
                                                                                $i++;
                                                                            }
                                                                        ?>
                                                                    </table>
                                                            <?php
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr><td height="5"></td></tr>
                                                    <tr>
                                                        <td width="100%">
                                                            <div align="left">
                                                               Page : <?php
 										//if($MaxPage > 1) echo "Page: ";
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
										
									 
                                                        ?>
                                                             </div>
                                                        </td>
                                                    </tr>
                                                    <tr><td height="5"></td></tr>
                                                </table>
                                             </td>
                                         </tr>
                                        <?php
                                            }
                                            else
                                            {
                                            echo "<tr><td align='center' colspan='5'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr>";
                                            }
										mysql_free_result($result);
										mysql_free_result($TRecord);
										}
                                        ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
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
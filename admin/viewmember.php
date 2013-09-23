<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }

	include('../global.php');	
	include('../include/functions.php');  
	
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
	
	$PageStatus = "Member Detail";	
	$btnSubmit = "Submit";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];
	
	if($id != "" && $e_action == 'view')
	{
		$str = "SELECT * from ".$tbname."_member WHERE _ID = '".replaceSpecialChar($id)."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{			
			$rs = mysql_fetch_assoc($rst);
			
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
	
<link type="text/css" href="../jquery/css/smoothness/jquery-ui-1.8.5.custom.css" rel="stylesheet" />	

</head>
<body >
	<table align="center" width="98%"   border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		<tr>
			<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
						<td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
					</tr>
					
					<tr>
						
						<td width="100%" align="left" valign="top" class="TitleStyle toptd" style="padding-left:5px; padding-top:6px;">
						<div class="m">
								 <b><?=$PageStatus?></b><br/><br/>
						<!--
						Start Contact
						-->
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr><td height=""></td></tr>
							</table>							
							<form name="Product" action="productaction.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
							                     
							<table cellpadding="0" cellspacing="0" border="0" width="100%" >								
                                <tr><td height="10"></td></tr>
								
                                <tr>
									<td width="120">FullName</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=$rs['_Fname']." ".$rs['_Lname'];?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                                <tr>
									<td width="120">Username</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=$rs['_Username'];?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                              <tr>
									<td width="120">Gender</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=$rs['_Gender'];?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                                <tr>
									<td width="120">Email</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=$rs['_Email'];?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                               <tr>
									<td width="120">Birthdate</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=date('d-m-Y',strtotime($rs['_Birthdate']));?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                                <tr>
									<td width="120">Registration Date</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=date('d-m-Y',strtotime($rs['_Regdate']));?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                                <tr>
									<td width="120">Last Login Date</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?php if($rs['_Lastlog'] !="") echo  date('d-m-Y',strtotime($rs['_Lastlog']));?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                                <tr>
									<td width="120">No. of Login</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=$rs['_Logno'];?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                               
								<tr>
									
									<td>
										<input type="button" name="btnSubmit" class="button1" value="Back" onClick="javascript: history.go(-1)" />&nbsp;
										
									</td>
                                    <td colspan="2">&nbsp;</td>
								</tr>
                                 <tr><td height="10"></td></tr>
							</table>
							</form>
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
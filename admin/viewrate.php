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
	
	$PageStatus = "Member Rate Detail";	
	$btnSubmit = "Submit";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];
	
	if($id != "" && $e_action == 'view')
	{
		$str = "SELECT r.*,c._Name as category,p._Title as product,m._Username as username from ".$tbname."_userrates r join  ".$tbname."_product p on p._ID=r._Prodid join ".$tbname."_category c on c._ID=p._Catid join ".$tbname."_member m on m._ID=r._Uid WHERE r._ID = '".replaceSpecialChar($id)."' ";
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
									<td width="120">Username</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=$rs['username'];?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                                <tr>
									<td width="120">Category</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=$rs['category'];?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                              
                                <tr>
									<td width="120">Product</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=$rs['product'];?>
									</td>
								</tr>
                                <tr><td height="10"></td></tr>
                               
                                <tr>
									<td width="120">Rate</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td width="710">
									<?=$rs['_Rate'];?>
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
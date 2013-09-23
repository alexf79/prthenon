<?php
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']=="")
{
echo "<script type='text/javascript' language='javascript'>window.location='login.php';</script>";
}
else
{
include('../global.php');
include('../include/functions.php');          
$sql = "SELECT * FROM ".$tbname."_user WHERE _ID = '" . replaceSpecialChar($_SESSION['userid']) . "' ";
$rst = mysql_query($sql, $connect) or die(mysql_error());
if(mysql_num_rows($rst) > 0)
{
$rs = mysql_fetch_assoc($rst);
$Fullname = $rs['_Fullname'];
$Username = $rs['_Username'];
$DOBDay = date("j", strtotime($rs['_DOB']));
$DOBMth = date("m", strtotime($rs['_DOB']));
$DOBYr = date("Y", strtotime($rs['_DOB']));
$Gender = $rs['_Gender'];
$Email = $rs['_Email'];
$Location = $rs['_Location'];
$CountryID = $rs['_CountryID'];	
$PostalCode = $rs['_PostalCode'];	
$Signature = $rs['_Remarks'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$appname?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />
<style type="text/css">
<!--
.style1 {font-size: 11px}
-->
</style>
<script type="text/javascript" src="../js/validate.js"></script>
<script type="text/javascript" src="../js/calendar.js"></script>
<script type="text/javascript" language="javascript">
<!--
function write_it(status_text)
{
window.status=status_text;
}
function testKey(e)
{
chars= "0123456789+ ";
e    = window.event;
if(chars.indexOf(String.fromCharCode(e.keyCode))==-1) 
window.event.keyCode=0;
}
function validateForm()
{
	var errormsg;
	errormsg = "";
	
	if (document.EditUserProfile.Fullname.value == "")
		errormsg += "Please fill in 'Full Name'.\n";
		
	if (document.EditUserProfile.CurrentPassword.value != "")
	{
		if (document.EditUserProfile.NewPassword.value == "")
			 errormsg += "Please fill in 'New Password'.\n";
	
		if (document.EditUserProfile.RetypePassword.value == "")
			 errormsg += "Please fill in 'Re-type Password'.\n";
	}
	
	if (document.EditUserProfile.NewPassword.value != "" || document.EditUserProfile.RetypePassword.value != "")
	{
		if (document.EditUserProfile.CurrentPassword.value == "")
			 errormsg += "Please fill in 'Current Password'.\n";
	
		if (document.EditUserProfile.NewPassword.value != document.EditUserProfile.RetypePassword.value)
			 errormsg += "'New Password' is not the same as 'Re-type Password'.\n";
	}
	
	if (document.EditUserProfile.Email.value == "")
	errormsg += "Please fill in 'Email'.\n";
	else
	{
				//alert('dfgbbg');
			   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			   var address =document.EditUserProfile.Email.value;
			   if(reg.test(address) == false ) {
				  errormsg += "Please fill in valid email address in 'Email'.\n";
			   }
	}	

    if ((errormsg == null) || (errormsg == ""))
    {
        document.EditUserProfile.btnSubmit.disabled=true;
        return true;
    }
    else
    {
        alert(errormsg);
        return false;
    }
}
function ClearAll()
{				
    for (var i=0;i<document.EditUserProfile.elements.length;i++) {
         if (document.EditUserProfile.elements[i].type == "text" || document.EditUserProfile.elements[i].type == "textarea")
              document.EditUserProfile.elements[i].value = "";
         else if (document.EditUserProfile.elements[i].type == "select-one")
              document.EditUserProfile.elements[i].selectedIndex = 0;
         else if (document.EditUserProfile.elements[i].type == "checkbox")
              document.EditUserProfile.elements[i].checked = false;
    }
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
                        <td width="100%" align="left" valign="top" class="toptd">
                        	<div class="m">
                            <table width="835" border="0" cellspacing="0" cellpadding="0">
                                <tr><td align="left" class="TitleStyle" style="padding-left:5px;" ><b>Edit User Profile</b></td></tr>
                                <tr><td height="10"></td></tr>
                                <?php
                                if ($_GET["done"] == 1)
                                {
                                echo "<tr><td height='5'></td></tr><tr><td colspan='3' align='left'><font color='#FF0000'>Your User Profile has been edited successfully.</font></td></tr><tr><td height='5'></td></tr>";
                                }
                                if ($_GET["error"] == 1)
                                {
                                echo "<tr><td height='5'></td></tr><tr><td colspan='3' align='left'><font color='#FF0000'>Invalid Current Password. Please try again.</font></td></tr><tr><td height='5'></td></tr>";
                                }
								if ($_GET["error"] == 2)
                                {
                                echo "<tr><td colspan='3' align='left'><font color='#FF0000'> &nbsp; Email already Exists.</font></td></tr><tr><td height='5'></td></tr>";
                                }
                                ?>
                                <tr>
                                <td>
                                    <form action="userprofileaction.php" method="post" name="EditUserProfile" onsubmit="return validateForm();">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                        <tr>
                                            <td>&nbsp;User Name&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><?php echo $Username; ?></td>
                                        </tr>
                                        <tr><td height="10"></td></tr>
                                        <tr>
                                           <td>&nbsp;Full Name&nbsp;</td>
                                           <td>&nbsp;:&nbsp;</td>
                                           <td width="700">
											<input type="text" autocomplete="off" id="Fullname" name="Fullname" value="<?php echo $Fullname; ?>" size="60" class="txtbox1" />
											<font style=" vertical-align: top; color: rgb(255, 0, 0);">*</font>
											</td>
                                        </tr>
                                        <tr><td height="10"></td></tr>
                                        <tr>
                                            <td>&nbsp;Current Password&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><input type="password" id="CurrentPassword" name="CurrentPassword" size="60" class="txtbox1" /></td>
                                        </tr>
                                        <tr><td height="10"></td></tr>
                                        <tr>
                                            <td>&nbsp;New Password&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><input type="password" id="NewPassword" name="NewPassword" size="60" class="txtbox1" /></td>
                                        </tr>
                                        <tr><td height="10"></td></tr>
                                        <tr>
                                            <td>&nbsp;Re-type Password&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td><input type="password" id="RetypePassword" name="RetypePassword" size="60" class="txtbox1" /></td>
                                        </tr>
                                        <tr><td height="10"></td></tr>                                        
                                        <tr>
                                            <td>&nbsp;Email&nbsp;</td>
                                            <td>&nbsp;:&nbsp;</td>
                                            <td>
												<input type="text" autocomplete="off" id="Email" name="Email" value="<?php echo $Email; ?>" size="60" class="txtbox1" />
												<font style=" vertical-align: top; color: rgb(255, 0, 0);">*</font>
											</td>
                                        </tr>                                                                                                                       
                                        <tr><td height="10"></td></tr>
                                        <tr>
                                            <td valign="top">&nbsp;Signature&nbsp;</td>
                                            <td valign="top">&nbsp;:&nbsp;</td>
                                            <td><textarea name="Remarks" style="width:225px;" cols="35" rows="4" class="textarea"><?php echo $Signature; ?></textarea></td>
                                        </tr>
                                        <tr><td height="10"></td></tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td align="left"><input type="submit" class="button1" name="btnSubmit" value="Update" />&nbsp;
											<input type="reset" class="button1" name="btnRevert" value="Revert" />&nbsp;
											<input type="button" class="button1" name="btnClearAll" value="Clear All" onclick="ClearAll();" /></td>
                                        </tr>
                                    </table>
                                    </form>
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
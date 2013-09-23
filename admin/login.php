<?php
session_start();
include('../global.php');	
include('../dbopen.php');   
include('../include/functions.php');	
if(isset($_POST['SubmitLogin']) && $_POST['SubmitLogin']=="SubmitLogin"){	
    mysql_select_db($database, $connect) or die(mysql_error());
    $Encrypt = "mysecretkey";
    $Password = encrypt($_POST['password'],$Encrypt);
    $sql = "SELECT _ID, _Fullname, _Username, _Password, _Email, _LevelID FROM ".$tbname."_user WHERE _Username='".replaceSpecialChar($_POST['username'])."' AND _Password='".replaceSpecialChar($Password)."' AND _Deleted IS NULL AND _LevelID <> 4 ";
	$rst = mysql_query($sql, $connect) or die(mysql_error());
    if(mysql_num_rows($rst) > 0)
    {
    $rs = mysql_fetch_assoc($rst);
    if(strcmp($rs['_Password'],$Password)==0)
    {
        session_register("userid");
        session_register("name");
        session_register("user");
        session_register("email");
        session_register("levelid");
        session_register("loginTime");
        $_SESSION['userid'] = $rs['_ID'];
        $_SESSION['name'] = $rs['_Fullname'];
        $_SESSION['user'] = $rs['_Username'];
        $_SESSION['pwd'] =  decrypt($rs['_Password'],$Encrypt);
        $_SESSION['email'] = $rs['_Email'];
        $_SESSION['levelid'] = $rs['_LevelID'];
        $_SESSION['loginTime'] = date("Y-m-d H:i:s");
        $UserID = $_SESSION['userid'];
        $SessionInfo = session_id() . $_SESSION['user'] . $_SESSION['loginTime'];
        $IPAddress = $_SERVER['REMOTE_ADDR'];
        $DateTimeIn = date("Y-m-d H:i:s");
        mysql_query("INSERT INTO ".$tbname."_logginglog (_UserID, _SessionInfo, _IPAddress, _DateTimeIn) VALUES ('$UserID','$SessionInfo','$IPAddress','$DateTimeIn')");
        include('../dbclose.php');		
        echo "<script language='JavaScript'>window.location = 'main.php'; </script>";
    }
    else
    {
		$_SESSION['uname1']=$_REQUEST['username'];
		$e_msg = "Invalid User Name or password.";
    }
    }
    else
    {
		$_SESSION['uname1']=$_REQUEST['username'];
    	$e_msg = "Invalid User Name or password.";
    }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $appname; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<meta http-equiv="Content-language" content="en-us" />
<link rel="stylesheet" type="text/css" href="../css/admin.css "/>
<script type="text/javascript" src="../js/validate.js"></script>
<script type="text/javascript" src="../jquery/development-bundle/jquery-1.4.2.js"></script>
<script language="javascript" type="text/javascript">
<?php if(isset($e_msg) && $e_msg != '') { ?>
alert('<?=$e_msg?>');
<?php } ?>
function validateForm()
{
	
	var errormsg;
    errormsg = "";
    if (document.Login.username.value == "")
	{
		errormsg += "Please enter User Name.\n"
	}
	else
	{
		var sUsername = jQuery.trim(document.Login.username.value);
		
		/* START OLD CODE IT MAY WRONG */
		/*var tomatch = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;
		if (tomatch.test(sUsername) == false)
		{
			alert(tomatch.test(sUsername));
			if (sUsername != "")
			errormsg += "Please fill in correct 'User Name'.\n";
		}*/
		/* END OLD CODE IT MAY WRONG */
		
		/* START NEW CODE */
		var iChars = "*|,\":<>[]{}`\';()@&$#%";
		for (var i = 0; i < sUsername.length; i++) {
			if (iChars.indexOf(sUsername.charAt(i)) != -1){
				errormsg += "Please fill in correct 'User Name'.\n";
				break;
			}
		}
		/* END NEW CODE */
	}
	
	
	
    if (document.Login.password.value == "")
    errormsg += "Please enter Password.\n"
    if ((errormsg == null) || (errormsg == ""))
    {
    if (document.Login.checker.checked){ toMem(this);}
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
	for (var i=0;i<document.Login.elements.length;i++) {
		if (document.Login.elements[i].type == "text" || document.Login.elements[i].type == "textarea" || document.Login.elements[i].type == "password")
			document.Login.elements[i].value = "";  
		else if (document.Login.elements[i].type == "select-one")
			document.Login.elements[i].selectedIndex = 0;
		else if (document.Login.elements[i].type == "checkbox")
			document.Login.elements[i].checked = false;
	}
}	
function clearcontent()
{
	document.Login.username.value="";
	document.Login.password.value="";
	
	if(document.Login.checker.checked==true)
	{
		document.Login.checker.checked=false;
	}
	
}

</script>
<script language="javascript" type="text/javascript">
<!-- Cookie script - Scott Andrew -->
<!-- Popup script, Copyright 2005, Sandeep Gangadharan --> 
<!--
function newCookie(name,value,days) {
    var days = 1;  // the number at the left reflects the number of days for the cookie to last
            // modify it according to your needs
    if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString(); }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/"; }
function readCookie(name) {
    var nameSG = name + "=";
    var nuller = '';
    if (document.cookie.indexOf(nameSG) == -1)
    return nuller;

    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameSG) == 0) return c.substring(nameSG.length,c.length); }
    return null; }
function eraseCookie(name) {
    newCookie(name,"",1); }
function toMem(a) {	
    newCookie('username', document.Login.username.value); // add a new cookie as shown at left for every
    newCookie('password', document.Login.password.value); // field you wish to have the script remember
}
function Checker(a) {
    if(document.Login.username.value !='' && document.Login.password.value !='')
    {
     document.Login.checker.checked=true;
    }
}
function delMem(a) {		
    if(document.Login.checker.checked==false)
    {
       eraseCookie('username');// make sure to add the eraseCookie function for every field
       eraseCookie('password');
    }
}

function screenresolution()
{
	var h;
	if(typeof window.innerHeight != 'undefined'){
		h = window.innerHeight;
	}
	else{
		h = parseInt(document.body.offsetHeight) + 180;
	}
	document.getElementById('MainDivision').style.height = h + "px"; 
}

//-->
</script>
</head>

<body onload="screenresolution(); document.Login.username.focus(); Checker(this);">
<table height="100%" width="970" cellspacing="0" cellpadding="0" border="0" align="center" style="align:center;">
		<tbody><tr>
			<td valign="top">
				<div class="maintable">
				<table width="970" cellspacing="0" cellpadding="0" border="0">			
						<tbody><tr>
							<td valign="top" colspan="2">
								<table width="970" cellspacing="0" cellpadding="0" border="0">
<tbody><tr>    
    <td valign="middle">
        <table width="970" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody>
			<tr>
						
			</tr>
		</tbody></table>
    </td>
</tr>	
</tbody></table>


							</td>
						</tr>
						
					<tr>
						<!--<td width="970" valign="top" align="left"  class="inner-block">	-->
						<td width="970" valign="top" align="left" style="border:0px;"  class="inner-block">	
						<div class="m"  style="margin:0px;">			
							<table width="924" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr>
        <td>
			<div style="background:#EAEAEA; border:1px solid #EAEAEA;" id="MainDivision" style="min-height:480px;">
            <table width="400" border="0" cellpadding="0" cellspacing="0" align="center" style="padding-top:130px;">
				<!--<tr><td height="150"></td></tr>-->
				<tr><td height="100"></td></tr>
                <tr><td align="center">
				<!--<img src="images/logo.png" border="0" alt="<?php $gbtitlename ?>">--><img src="../images/logo.png"/><!--<br><span style="font-size:20px; color:#000000; font-weight:bold">Admin Control Panel</span>--></td></tr>
                
                <tr>
                    <td align="left" style="padding:0px;">
                        <form name="Login" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return validateForm();">
                        <input type="hidden" name="SubmitLogin" value="SubmitLogin" />
                        <table width="260" border="0" cellpadding="0" cellspacing="0" align="center">                                
                                <tr><td height="10"></td></tr>
                                <tr>
                                     <td width="25%" align="right">&nbsp;User Name&nbsp;</td>
                                     <td width="5%">&nbsp;:&nbsp;</td>
                                     <td width="75%">&nbsp;<input type="text" name="username" value="<?php echo $_POST['username'];?>" style="width:170px;" class="txtbox1" />&nbsp;
									
									 </td>
                                </tr>
                                <tr><td height="5"></td></tr>
                                <tr>
                                     <td align="right">&nbsp;Password&nbsp;</td>
                                     <td>&nbsp;:&nbsp;</td>
                                     <td>&nbsp;<input type="password" name="password" id="password" value="" style="width:170px;" class="txtbox1" />&nbsp;</td>
                                </tr>
                                <tr><td height="10"></td></tr>
                                <tr>
                                     <td>&nbsp;&nbsp;</td>
                                     <td>&nbsp;&nbsp;</td>
                                     <td>&nbsp;<input type="submit" name="btnSubmit" value="Login" class="button1" />&nbsp;<input type="button" name="btnReset" value="Clear" class="button1" onclick="clearcontent();"  />&nbsp;</td>
                                </tr>
                                <tr><td height="10"></td></tr>
                                <tr>
                                     <td>&nbsp;&nbsp;</td>
                                     <td>&nbsp;&nbsp;</td>
                                     <td>&nbsp;<input type="checkbox" name="checker" onclick="delMem(this)" />Remember me</td>
                                </tr>
                                <tr><td height="10"></td></tr>
                                <tr>
                                     <td>&nbsp;&nbsp;</td>
                                     <td>&nbsp;&nbsp;</td>
                                     <td>&nbsp;<a href="javascript:void(0);" onclick="window.open('forget.php','ForgetPassword','width=320,height=145,left=350,top=250,toolbar=no,menubar=no,location=no,scrollbars=no,resizable=yes');" style="color:#000000;">Forget Password</a></td>
                                </tr>
                                <tr><td height="10"></td></tr>
                               <!-- <tr>
                                     <td colspan="3" align="center">&nbsp;Important Note: For maximum compatibility, We recommends the use of web 
browser "Internet Explorer ver 8", from this page onwards.&nbsp;</td>
                                </tr>-->
                                <tr><td height="10"></td></tr>
                        </table>
                        </form>
                        <script language="JavaScript" type="text/javascript">
                        <!--
						<?php if(!isset($e_msg) && $e_msg == '')
						{ ?>
						if(readCookie("username") != "")
						{
							document.Login.username.value = readCookie("username");  // Change the names of the fields at right to match the ones in your form.
							document.Login.password.value = readCookie("password");
						}
						<?php
						}
						?>
                        //-->
                        </script>
                    </td>
                </tr>
            </table>
			</div>
        </td>
        
    </tr>
</table>

						</div>
						</td>
						</tr>
				</tbody></table>
				</div>
			</td>
		</tr>
	</tbody></table>
</body>
</html>
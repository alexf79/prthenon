<?php
include('../global.php');
include('../dbopen.php');
include('../include/functions.php');  
mysql_select_db($database, $connect);

//Code for fetching email of master user 26.8.11

$sqlmst = "SELECT * FROM ".$tbname."_user WHERE _LevelID = 1 "; 
$rstmst = mysql_query($sqlmst, $connect) or die(mysql_error());
if(mysql_num_rows($rstmst) > 0)
{
	$fetchmst = mysql_fetch_assoc($rstmst);
	$adminEmail=$fetchmst['_Email'];
}

//End Code for fetching email of master user 26.8.11

$TxtEmail = trim($_REQUEST['TxtEmail']);
$sql = "SELECT * FROM ".$tbname."_user WHERE _Email = '" . replaceSpecialChar($TxtEmail) . "' ";
$rst = mysql_query($sql, $connect) or die(mysql_error());
if(mysql_num_rows($rst) > 0)
{
$rs = mysql_fetch_assoc($rst);


$adminName = $rs['_Fullname'];
$adminUsername = $rs['_Username'];
$Encrypt = "mysecretkey";		
$adminPassword = decrypt($rs['_Password'],$Encrypt);
$to  = $TxtEmail;
$subject = $appname . " Admin Login Password";
$message = '
    <html>
    <head>
    <title>' . $appname . '</title>
    </head>
    <body>
    <table width=500 border=0 cellspacing=0 cellpadding=5 style="border-color:#EEEEEE; border-style:solid; border-width:0; font-size:11px; font-family: Arial, Verdana, sans-serif;">
    <tr><td colspan=3 bgcolor="#CCCCCC" height="30" style="color:#FFFFFF"><b> ' . $appname . ' </b></td></tr>
    <tr><td colspan=3>Dear ' . $adminName . ',<br><br></td></tr>
    <tr><td colspan=3>Your username and password are as follows:<br><br></td></tr>
    <tr><td width=50>Username</td><td width=20>:</td><td width=460>' . $adminUsername . '</td></tr>
    <tr><td>Password</td><td>:</td><td>' . $adminPassword . '</td></tr>
    <tr><td colspan=3><br>Regards, <br> ' . $appname . ' <br><br></td></tr>
    </table>
    </body>
    </html>
';
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "X-Priority: 1\r\n";
$headers .= "X-MSMail-Priority: High\r\n";
$headers .= "From: " . $appname . "<" . $adminEmail . ">\r\n"; 
//echo $message;
//exit;
mail($to, $subject, $message, $headers);
include('../dbclose.php');
echo "<script language='JavaScript'>window.location = 'forget.php?ID=1'</script>";
}
else
{
include('../dbclose.php');
echo "<script language='JavaScript'>window.location = 'forget.php?ID=2'</script>";
}
?>

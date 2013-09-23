<?php
session_start();
include('global.php');
include('include/functions.php');

if(isset($_REQUEST['Submit']))
{
	$fname=trim($_REQUEST['Fname']);
	$lname=trim($_REQUEST['Lname']);
	$username=trim($_REQUEST['Uname']);
	$password=encrypt($_REQUEST['Pwd'],$Encrypt);
	$gender=trim($_REQUEST['gender']);
	$bd=trim($_REQUEST['bdate']);
	if($bd)
	{
		$bd=explode("/",$bd);
		$bdate=$bd[2]."-".$bd[1]."-".$bd[0];
	}
	$email=$username;
	
	
	$subject='New Registration Detail';
	
	$admin_sel="select * from ".$tbname."_user where _ID='1' ";
	$qr_admin=mysql_query($admin_sel);
	$rs_admin=mysql_fetch_array($qr_admin);
	$admin_mail=$rs_admin['_Email'];
	
	$to = $admin_mail;
	$from =$email;
	
	$str="insert into ".$tbname."_member (_Username,_Password,_Fname,_Lname,_Gender,_Birthdate,_Email,_Regdate) values('".replaceSpecialChar($username)."','".replaceSpecialChar($password)."','".replaceSpecialChar($fname)."','".replaceSpecialChar($lname)."','".replaceSpecialChar($gender)."','".replaceSpecialChar($bdate)."','".replaceSpecialChar($email)."','".Date('Y-m-d')."')";
	$qr=mysql_query($str);
	$lastid = mysql_insert_id(); 
	if($qr)
	{	
	$subject='New Registration Detail';
	$subject1='New Registration Detail';
	$body = '<div style="width:450px; font-family:Arial,Helvetica,sans-serif; font-size:12px;">
				<div style="width:440px; background:#3366FF; color:#ffffff; font-weight:bold; font-size:14px; padding:5px;">New Registration Detail</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">First Name : </span>
				<span>'.$fname.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Last Name : </span>
				<span>'.$lname.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Gender : </span>
				<span>'.$gender.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Birthdate : </span>
				<span>'.$bdate.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Username : </span>
				<span>'.$username.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Password : </span>
				<span>'.decrypt($password,$Encrypt).'</span>
				</div>
								
				<br />
				<div style="width:450px; margin:5px 0;">
				Regards,<br />
				'.$fname.' '.$lname.'    
				</div>
			</div>';
		$body1 = '<div style="width:450px; font-family:Arial,Helvetica,sans-serif; font-size:12px;">
				<div style="width:440px; background:#3366FF; color:#ffffff; font-weight:bold; font-size:14px; padding:5px;">Your Login Detail</div><div style="width:440px;">Thanks for Your Registration</div>
				
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Username : </span>
				<span>'.$username.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Password : </span>
				<span>'.decrypt($password,$Encrypt).'</span>
				</div>
							
				<br />
				<div style="width:450px; margin:5px 0;">
				Regards,<br />
				admin   
				</div>
			</div>';
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "X-Priority: 1\r\n";
		$headers .= "X-MSMail-Priority: High\r\n";
		$headers .= "From: ".$from."<" . $from . ">\r\n";
		
		$headersu = "MIME-Version: 1.0\r\n";
		$headersu .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headersu .= "X-Priority: 1\r\n";
		$headersu .= "X-MSMail-Priority: High\r\n";
		$headersu .= "From: ".$admin_mail."<" . $admin_mail . ">\r\n";
		
		
		mail($to, $subject, $body, $headers);
		mail($from, $subject1, $body1, $headersu);
	}
	$_SESSION['userid']=$lastid;
	$_SESSION['fname']=$fname;
	$_SESSION['lname']=$lname;
	$_SESSION['email']=$username;
	echo "<script language='JavaScript'>window.location = 'index.php';</script>";
/*echo "<script language='JavaScript'>window.location = 'registration.php?done=".encrypt(1,$Encrypt)."';</script>";*/
		 
}

?>
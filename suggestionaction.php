<?php
session_start();
include('global.php');
include('include/functions.php');


if(isset($_REQUEST['Submit']))
{
	$name=trim($_REQUEST['Name']);
	$mail=trim($_REQUEST['Email']);
	$subject='Member Suggestion.';
	$message=trim($_REQUEST['Suggestion']);
	
	$admin_sel="select * from ".$tbname."_user where _ID='1' ";
	$qr_admin=mysql_query($admin_sel);
	$rs_admin=mysql_fetch_array($qr_admin);
	$admin_mail=$rs_admin['_Email'];
	
	$to = $admin_mail;
	$from =$mail;
	
	$body = '<div style="width:450px; font-family:Arial,Helvetica,sans-serif; font-size:12px;">
				<div style="width:440px; background:#3366FF; color:#ffffff; font-weight:bold; font-size:14px; padding:5px;">Contact Us Detail</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Name : </span>
				<span>'.$name.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Email : </span>
				<span>'.$mail.'</span>
				</div>
				
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Suggestion : </span>
				<span>'.$message.'</span>
				</div>
							
				<br />
				<div style="width:450px; margin:5px 0;">
				Regards,<br />
				'.$name.'    
				</div>
			</div>';
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "X-Priority: 1\r\n";
		$headers .= "X-MSMail-Priority: High\r\n";
		$headers .= "From: ".$name."<" . $mail . ">\r\n";
		
		
		mail($to, $subject, $body, $headers);
			
echo "<script language='JavaScript'>alert('Your Suggestion has been sent successfully..');
window.location = '".$_SERVER['HTTP_REFERER']."';</script>";
		 
}

?>
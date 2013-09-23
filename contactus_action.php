<?php

session_start();
include('global.php');
include('include/functions.php');

if(isset($_REQUEST['submit']))
{
	$name=$_REQUEST['name'];
	$from=$_REQUEST['email'];
	//$mobile=$_REQUEST['mobile'];
	$notes=$_REQUEST['notes'];
	
	$admin_sel="select * from ".$tbname."_user where _ID='1' ";
	$qr_admin=mysql_query($admin_sel);
	$rs_admin=mysql_fetch_array($qr_admin);
	//$admin_mail=$rs_admin['_Email'];
	$admin_mail='administrator@prthenon.com';
	$to =$admin_mail;
	$subject = 'Contact Detail'; 
	
	$body = '<div style="width:450px">
				<div style="width:440px; background:#3366FF; color:#ffffff; font-weight:bold; font-size:14px; padding:5px;">Contact Detail:-</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Name</span>
				<span style="width:5px; font-weight:bold;">:</span>
				<span style="width:250px;">'.$name.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Email</span>
				<span style="width:5px; font-weight:bold;">:</span>
				<span style="width:250px;">'.$from.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Message</span>
				<span style="width:5px; font-weight:bold;">:</span>
				<span style="width:250px;">'.$notes.'</span>
				</div>
				<br />
				<div style="width:450px margin:5px 0;">
				Regards,<br />
				'.$name.' 
				</div>
			</div>';
		
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "X-Priority: 1\r\n";
		$headers .= "X-MSMail-Priority: High\r\n";
		$headers .= "From: " . $from . "\r\nReply-To: " . $from . "";
		
		
		if (mail($to, $subject, $body, $headers)) {
		  echo "<script language='JavaScript'>window.location = 'contactus.php?done=".encrypt(1,$Encrypt)."';</script>";
		 } else {
		 echo "<script language='JavaScript'>alert('Incorect Email ID.');window.location = 'contactus.php';</script>";
		 }
	
}



?>
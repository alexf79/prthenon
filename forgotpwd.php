<?php
session_start();
include('global.php');
include('include/functions.php');

if (isset($_REQUEST['Submit']) && $_REQUEST['Submit']!="")
{
	$user=trim($_REQUEST['Uname']);
	$mail=trim($_REQUEST['Email']);
	
	$sql="SELECT * FROM ".$tbname."_member where _Username='".$mail."' ";			
	
	$rst1 = mysql_query($sql) or die(mysql_error());

    if(mysql_num_rows($rst1) > 0)
    {
   		$rs = mysql_fetch_assoc($rst1);
		if($rs)
		{	
			$admin_sel="select * from ".$tbname."_user where _ID='1' ";
			$qr_admin=mysql_query($admin_sel);
			$rs_admin=mysql_fetch_array($qr_admin);
			$admin_mail=$rs_admin['_Email'];
			$admin_name=$rs_admin['_Username'];
			
			$to = $rs['_Email'];
			
			$name = $rs['_Username'];
			$pwd = decrypt($rs['_Password'],$Encrypt);	
			$subject = "Your User Detail of parthenon.com";
		
			$body = '<div style="width:450px; font-family:Arial,Helvetica,sans-serif; font-size:12px;">
				<div style="width:440px; background:#3366FF; color:#ffffff; font-weight:bold; font-size:14px; padding:5px;">			
				Your Username and Password detail of parthenon.com</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Name : </span>
				<span>'.$name.'</span>
				</div>
				<div style="width:450px; margin:5px 0;">
				<span style="width:150px; font-weight:bold;">Password : </span>
				<span>'.$pwd.'</span>
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
			$headers .= "From: ".$admin_mail."<" . $admin_mail . ">\r\n";
			
			
			mail($to, $subject, $body, $headers);
				
			echo "<script language='JavaScript'>alert('Your Password has been sent on your email id successfully..');
			window.location = '".$_SERVER['HTTP_REFERER']."';</script>";
					 
			}
	}
	else
	{
		echo "<script language='JavaScript'>alert('Please Enter Correct Email Address.');
			window.location = '".$_SERVER['HTTP_REFERER']."';</script>";
	}
} 

$done=decrypt($_REQUEST['done'],$Encrypt);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<title>Parthenon | Welcome</title>
<?php
	include('topscript.php');
?>

<script language="javascript" type="text/javascript">
						
		function validateForm()
		{			
			var errormsg;
            errormsg = "";
			
			/*if (document.frmforgot.Uname.value == "")
                errormsg += "Please fill in 'User Name'.\n";*/
      		
				
			if (document.frmforgot.Email.value == "")
                errormsg += "Please fill in 'Email ID'.\n";
			else
			{
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				var address =document.frmforgot.Email.value;
				if(reg.test(address) == false ) {
					errormsg += "Please fill in valid email address in 'Email'.\n";
				}
			}
/*						
			var x=document.forms["frmReg"]["Email"].value;
			var atpos=x.indexOf("@");
			var dotpos=x.lastIndexOf(".");
			if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
			{
				alert("Not a valid E-mail Address...");
				errormsg += "Not a valid E-mail Address .\n";
				frmReg.Email.value ="";
				frmReg.Email.focus();
				return false;						
			}
*/							
			
            if ((errormsg == null) || (errormsg == ""))
            {
               // document.Product.btnSubmit.disabled=true;
                return true;
            }
            else
            {
                alert(errormsg);
                return false;
            }
		}
	</script>


</head>

<body>
  <?php
  	include('header.php');
  ?>
  
  <div class="main_login" style="min-height:450px;">
    
  
	<div class="forgot-password" style="height:200px;">
    <form name="frmforgot" action="" method="post" onsubmit="return validateForm();">
      <div class="page-head" align="center">Forgot Password</div>
      	<div style="color:red; font-family:Arial, Helvetica, sans-serif; text-align:center; font-size:12px;">
        <?php
		if(isset($done) && $done==1)
		{
        echo "Your Password Send successfully.";        
		}
		else
		{
			echo "&nbsp;";
		}
		?>
        </div>
          <!--<div class="login_small_box1">
            <div class="login_lt_box1">
              <div class="login_lt_tx">Username</div>
            </div>
            <div class="login_rt_box1">
              <input type="text" class="tx_box1" name="Uname" placeholder="Enter Username" />
            </div>
          </div>-->
          <div class="login_small_box1" style="margin-left: 45px;">
            <div class="login_lt_box2">
              <label for="Email">Email Address</label>
            </div>
            <div class="login_rt_box1">
              <input type="text" class="text-box" name="Email" placeholder="Enter Email" />
            </div>
          </div>
          <div class="login_small_box1">
            <div class="login_lt_box1">
              <div class="login_lt_tx">&nbsp;</div>
            </div>
            <div class="login_rt_box1" style="float:right;">
             	<input type="submit" name="Submit" value="Submit" class="send-button" style="margin-left:270px;"/>&nbsp;
                <!--<input type="reset" name="reset" value="Reset" class="sign_up_bt1" />-->
            </div>
          </div>
     </form>   
	 </div>  
  </div>
  <br clear="all" />
  <div class="clr"></div>
<?php
	include('footer.php');
?>

</body>
</html>
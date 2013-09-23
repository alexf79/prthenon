<?php
session_start();
include('global.php');
include('include/functions.php');

$done=decrypt($_REQUEST['done'],$Encrypt);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>

<script language="javascript" type="text/javascript">

	function validecontact()
	{
		var err="";
		if(document.f1.name.value=="")
		{
			err +="Please Enter Name.\n";
		}
		if(document.f1.email.value=="")
		{
			err +="Please Enter Email.\n";
		}
		else if(checkemail(document.f1.email.value))
		{
			err +="Please Enter Correct Email.\n";
		}
		if(document.f1.mobile.value=="")
		{
			err +="Please Enter Mobile.\n";
		}
		if(document.f1.notes.value=="")
		{
			err +="Please Enter Message.\n";
		}
		if(err !='')
		{
			alert(err);
			return false;
		}
		else
		{
			return true;
		}
	}
	</script>

<?php
	include('topscript.php');
?>
</head>

<body>
  <?php
  	include('header.php');
  ?>

  <div class="contact" style="min-height:450px;">
    <div class="page-head">CONTACT US</div>
    <div class="main_Pillers1">
    <form name="f1" action="contactus_action.php" method="post" onsubmit="return validecontact();">
      	<div class="rating-response" style="text-align: center;
          margin-bottom: 20px;">
        <?php
		if(isset($done) && $done==1)
		{
        echo "Mail has been successfully sent...";        
		}
		else
		{
			echo "&nbsp;";
		}
		?>
        </div>
          <div class="login_small_box1">
            <div class="login_lt_box1">
              <label>Name</label>
            </div>
            <div class="login_rt_box1">
              <input type="text" class="text-box" name="name" placeholder="Enter Name" />
            </div>
          </div>      
          <div class="login_small_box1">
            <div class="login_lt_box1">
              <label>Email</label>
            </div>
            <div class="login_rt_box1">
              <input type="text" class="text-box" name="email" placeholder="Enter Email "/>
            </div>
          </div>
          <!--<div class="login_small_box1">
            <div class="login_lt_box1">
              <label>Mobile</label>
            </div>
            <div class="login_rt_box1">
              <input type="text" class="text-box" name="mobile" onkeypress="return numbersonly(event);" placeholder="Enter Mobile Number"  />
            </div>
          </div>-->
          <div class="login_small_box1" style="height:110px;">
            <div class="login_lt_box1">
              <label>Message</label>
            </div>
            <div class="login_rt_box1">
				<textarea name="notes" class="text-box" style="width: 301px; height:100px;" placeholder="Enter Message"></textarea>
            </div>
          </div>
        
          <div class="login_small_box1">
            <div class="login_lt_box1">
              <div class="login_lt_tx">&nbsp;</div>
            </div>
            <div class="login_rt_box1">
             	<input type="submit" name="submit" value="Submit" class="send-button" style="float:right; width:115px;"/>&nbsp;
                <input type="reset" name="reset" value="Reset" class="reset-button" style="float:right;" />
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
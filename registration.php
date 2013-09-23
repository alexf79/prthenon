<?php
session_start();
include('global.php');
include('include/functions.php');

$done=decrypt($_REQUEST['done'],$Encrypt);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<?php
	include('topscript.php');
?>
<link type="text/css" href="jquery/css/smoothness/jquery-ui-1.8.5.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="jquery/development-bundle/jquery-1.4.2.js"></script>
<script type="text/javascript" src="jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" language="javascript">
$(function(){
	$('.datepicker').datepicker({
	changeDate: true,
	changeMonth: true,
	changeYear: true,
	maxDate: new Date(),
	dateFormat: 'dd/mm/yy',
	yearRange: '-80'
	});			
});
</script>

<style>

.ui-datepicker {
  display: none;
  background: #fff;
  height: 350px;
  width: 400px;
  padding: 20px;
}

.signup-button {
  right: -85px;
  position: relative;
  float: right;
  width: 100px !important;
  height: 42px;
  margin-top: 10px;
  padding: 0px 15px;
  border: 2px solid #429631 !important;
  border-radius: 6px;
  background: #49a637;
  color: white !important;
  font-size: 16px;
  text-align: center;
  text-shadow: 0px 1px 1px #429631;
  cursor: pointer;
}

</style>

</head>
<body>
  <?php
  	include('header.php');
  ?>
  
  <div class="main_login" style="min-height:750px;">
    <div class="philosophy">
    <form name="frmReg" action="registrationaction.php" method="post" onsubmit="return validateRegForm();">
      <h2 class="page-head" align="center">Sign Up</h2>
   	  <div class="rating-response">
        <?php
		if(isset($done) && $done==1)
		{
        echo "You have successfully registered.";        
		}
		else
		{
			echo "&nbsp;";
		}
		?>
        </div>
        <div class="registration-fields">

          <div class="login_small_box1">
            <div class="login_lt_box2">
              <label for="Fname">First Name</label>
            </div>
            <div class="login_rt_box1">
              <input type="text" class="text-box" name="Fname" placeholder="First Name"/>
            </div>
          </div>      
          <div class="login_small_box1">
            <div class="login_lt_box2">
              <label for="Lname" >Last Name</label>
            </div>
            <div class="login_rt_box1">
              <input type="text" class="text-box" name="Lname" placeholder="Last Name"/>
            </div>
          </div>
          <div class="login_small_box1">
            <div class="login_lt_box2">
              <label for="Uname">Email Address</label>
            </div>
            <div class="login_rt_box1">
              <input type="text" class="text-box" name="Uname" placeholder="Email Address"/>
            </div>
          </div>
          <div class="login_small_box1">
            <div class="login_lt_box2">
              <label for="Pwd">Password</label>
            </div>
            <div class="login_rt_box1">
              <input type="password" class="text-box" name="Pwd" placeholder="Password"/>
            </div>
          </div>
          <div class="login_small_box1">
            <div class="login_lt_box2">
              <label for="Rpwd">Re-type Password</label>
            </div>
            <div class="login_rt_box1">
              <input type="password" class="text-box" name="Rpwd" placeholder="Re-type Password"/>
            </div>
          </div>
          <!--<div class="login_small_box1">
            <div class="login_lt_box1">
              <div class="login_lt_tx">Email Address</div>
            </div>
            <div class="login_rt_box1">
              <input type="text" class="tx_box1" name="Email" />
            </div>
          </div>-->
          <div class="login_small_box1">
            <div class="login_lt_box2">
              <div class="login_lt_tx">&nbsp;</div>
            </div>
            <div class="login_rt_box1" style="float:right;">
             	<input type="submit" name="Submit" value="Submit" class="signup-button" style="margin-right: 80px;"/>&nbsp;
                <!--<input type="reset" name="reset" value="Reset" class="sign_up_bt1" />-->
            </div>
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
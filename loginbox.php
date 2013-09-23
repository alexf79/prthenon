<div class="login_box">
<?php
	if(isset($_SESSION['userid']) && $_SESSION['userid'] !='')
	{
		?>
        <div class="login">
        	<h1>Welcome : </h1>
            <p><?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?></p>
            <span><a href="rating.php">Product Category</a></span>
        </div>
        <?php
	}
	else
	{
?>
      <h2>LOGIN</h2>
      <form name="login" method="post" action="loginaction.php" onsubmit="return loginfrm();" >
      <div class="login_small_box"><!--login_small_box st-->
        <div class="login_lt_box"><!--login_lt_box st-->
          <div class="login_lt_tx">NAME</div>
        </div>
        <!--login_lt_box end-->
        <div class="login_rt_box"><!--login_rt_box st-->
          <input type="text" class="tx_box" name="username" />
        </div>
        <!--login_rt_box end--> 
      </div>      
      <div class="login_small_box">
        <div class="login_lt_box">
          <div class="login_lt_tx">PASSWORD</div>
        </div>
        <div class="login_rt_box">
          <input type="password" class="tx_box" name="password" />
        </div>
      </div>
      <div class="login_small_box" style="height:45px;">
      <div class="login_lt_box">
          <div class="login_lt_tx">&nbsp;</div>
        </div>
        <div class="login_rt_box">
      	<input type="submit" name="Submit" value="Submit" class="sign_up_bt1" />
        </div>
      </div>
      </form>
      <div class="forgot_tx"><a href="forgotpwd.php">Forgot your password ? </a><br />
        <a href="registration.php">New user click here</a> </div>
<?php
	}
	?>
</div>
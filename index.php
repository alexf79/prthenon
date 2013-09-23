<?php
session_start();
include('global.php');
include('include/functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
  <?php
  	include('topscript.php');
  ?>
  <script type="text/javascript" src="js/validate.js"></script>
  <script type="text/javascript" src="jquery/development-bundle/jquery-1.4.2.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
  <script language="javascript" type="text/javascript">
  function clearcontent()
  {
  	document.login.username.value="";
  	document.login.password.value="";
  	
  	if(document.login.checker.checked==true)
  	{
  		document.login.checker.checked=false;
  	}
  	
  }
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
      newCookie('username', document.login.username.value); // add a new cookie as shown at left for every
      newCookie('password', document.login.password.value); // field you wish to have the script remember
  }
  function Checker(a) {
      if(document.login.username.value !='' && document.login.password.value !='')
      {
       document.login.checker.checked=true;
      }
  }
  function delMem(a) {		
      if(document.login.checker.checked==false)
      {
         eraseCookie('username');// make sure to add the eraseCookie function for every field
         eraseCookie('password');
      }
  }
  </script>

<!-- Adds Placeholder Text to IE -->
<script type="text/javascript">
/* <![CDATA[ */
$(function() {
  var input = document.createElement("input");
    if(('placeholder' in input)==false) { 
    $('[placeholder]').focus(function() {
      var i = $(this);
      if(i.val() == i.attr('placeholder')) {
        i.val('').removeClass('placeholder');
        if(i.hasClass('password')) {
          i.removeClass('password');
          this.type='password';
        }     
      }
    }).blur(function() {
      var i = $(this);  
      if(i.val() == '' || i.val() == i.attr('placeholder')) {
        if(this.type=='password') {
          i.addClass('password');
          this.type='text';
        }
        i.addClass('placeholder').val(i.attr('placeholder'));
      }
    }).blur().parents('form').submit(function() {
      $(this).find('[placeholder]').each(function() {
        var i = $(this);
        if(i.val() == i.attr('placeholder'))
          i.val('');
      })
    });
  }
});
/* ]]> */
</script>

</head>

<body onload="Checker(this);">
  <?php 
  	include("header.php");    
  ?>
  <div class="main_login">
  	<?php
  	if(isset($_SESSION['userid']) && $_SESSION['userid'] !='')
  	{
  	?>
      <div class="welcome">
      	<h1>Welcome to Prthenon, <?php echo $_SESSION['fname']; ?></h1>
          <h3>Select a category above to begin, or select My Room to set up your room</h3>
      </div>
       <?php
  	}
  	else
  	{
  	?>
    <!--main_login st-->
   <div class="prth-description">
          <h2>Discover reviews you can trust.</h2>
          <p>Prthenon measures the similarity between user ratings in the areas of movies, TV shows, games, and books to bring like-minded people together and provide the most personalized recommendations on the internet. </p> 
        </div>
    <!--main_ct_lt end-->
    



    <form name="login" method="post" action="loginaction.php" onsubmit="return loginfrm();" class="login">
        <table class="login-table">
          <th>Login</th>
          <tr>
            <td colspan="2">
              <img src="images/email-icon.png" class="input-icon">
              <input type="text" name="username" class="text-box email-icon" placeholder="Email Address" />
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <img src="images/password-icon.png" class="input-icon">
              <input type="password" name="password" class="text-box password-icon" placeholder="Password" />
            </td>
          </tr>
          <tr>
            <td>
              <div class="forgot"><input type="checkbox" name="checker" onclick="delMem(this)"/> Keep me logged in</div>
                  <div class="forgot"><a href="forgotpwd.php">Forgot password? </a>
              </div>
            </td>
            <td>
              <input type="submit" name="Submit" value="Login" class="login-button" />
            </td>
          </tr>
        </table>
      </form>

      <div class="clear-footer"></div>


    <script language="JavaScript" type="text/javascript">
  	<!--
  	<?php if(!isset($e_msg) && $e_msg == '')
  	{ ?>
  	if(readCookie("username") != "")
  	{
  		document.login.username.value = readCookie("username");  // Change the names of the fields at right to match the ones in your form.
  		document.login.password.value = readCookie("password");
  	}
  	<?php
  	}
  	?>
  	//-->
  	</script>
    <!--login_box end-->
    <?php
    }
    ?>
  </div>
    <?php
    	include("footer.php");
    ?>
</body>
</html>

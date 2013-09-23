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
</head>
<body>
<?php
	include('header.php');
?>    

<div class="philosophy">
      <h2>Four Pillars of Philosophy</h2>
      <ul>
        <li><span>1</span>Individuals over consensus</li>
        <li><span>2</span>We present facts, users make decisions</li>
        <li><span>3</span>Transparency equals trust</li>
        <li><span>4</span>Usefulness over coolness</li>
      </ul>
</div>

<?php
	include("footer.php");
?>          
</body>
</html>
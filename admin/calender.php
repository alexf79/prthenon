<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script type='text/javascript' language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php');  	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $appname; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />
	<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />	
	<script type="text/javascript" src="../js/validate.js"></script>
    
	<!--<link type="text/css" href="../jquery/css/smoothness/jquery-ui-1.8.5.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="../jquery/development-bundle/jquery-1.4.2.js"></script>
    <script type="text/javascript" src="../jquery/development-bundle/ui/jquery.ui.core.js"></script>
    <script type="text/javascript" src="../jquery/development-bundle/ui/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="../jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>-->   
	
	<link rel='stylesheet' type='text/css' href='calender/calendar_style.css' />
	<script type="text/javascript" src="calender/calendar.js"></script>
	
	<style type="text/css">
		.tooltip {
			border-bottom: 1px dotted #000000; 
			color: #000000; 
			outline: none;
			text-decoration: none;
			position: relative;
		}
		.tooltip span {
			margin-left: -999em;
			position: absolute;
			font-size:9pt;
		}
		.tooltip:hover span {
			border-radius: 5px 5px; 
			-moz-border-radius: 5px; 
			-webkit-border-radius: 5px; 
			box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.1); 
			-webkit-box-shadow: 5px 5px rgba(0, 0, 0, 0.1); 
			-moz-box-shadow: 5px 5px rgba(0, 0, 0, 0.1);
			font-family: Calibri, Tahoma, Geneva, sans-serif;
			position: absolute; left: 1em; top: 2em; z-index: 99;
			margin-left: 0; width: 250px;
		}
		.tooltip:hover img {
			border: 0; margin: -10px 0 0 -55px;
			float: left; position: absolute;
		}
		.tooltip:hover em {
			font-family: Candara, Tahoma, Geneva, sans-serif; font-size: 1.2em; font-weight: bold;
			display: block; padding: 0.2em 0 0.6em 0;
		}
		.classic { padding: 5px 5px 5px 25px; }
		.classic {background: #FFFFAA; border: 1px solid #FFAD33; }
	</style>
</head>
<body onload='navigate("","")'>
	<table align="left" width="1000" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		<tr>
			<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr><td height="10" bgcolor="#C1DEFE"></td></tr>
					<tr>
						<td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
					</tr>
					<tr><td height="10" bgcolor="#C1DEFE"></td></tr>
					<tr>
						<td width="150" align="left" valign="top" bgcolor="#C1DEFE"><?php include('left.php'); ?></td>
						<td width="850" align="center" valign="top">															
						<!--
						Start Contact
						-->
							<table cellpadding="0" cellspacing="0" border="0" width="840">
								<tr>
								  <td align="left" class="TitleStyle"><b>Calendar</b></td>
								</tr>
								<tr><td height="10"></td></tr>
							</table>

							<div>
							

								<div id="calback">
									<div id="calendar"></div>
								</div>

							</div>

							
							<!-- START CODE FOR CALENDER -->
							<?php
								/* local variables */
								$month = 8;
								$year  = 2011;
							?>
							<!-- END CODE FOR CALENDER -->
							
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
<?php		
include('../dbclose.php');
?>
<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script type='text/javascript' language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php');  
	include("fckeditor/fckeditor.php");
			
	$PageStatus = "Add Promotion";	
	$btnSubmit = "Submit";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];	

	if($id != "" && $e_action == 'edit')
	{
		$str = "SELECT * FROM ".$tbname."_promotion WHERE _ID = '".replaceSpecialChar($id)."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$PromotionName = $rs['_PromotionName'];						
			$PublishDate = date("d/m/Y", strtotime($rs['_PublishDate']));			
			$BriefInfo = $rs['_BriefInfo'];	
			$Description = $rs['_Description'];	
			$Status = $rs['_Status'];			
			$PageStatus = "Edit Promotion";
			$btnSubmit = "Update";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $appname; ?></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />			
<script type="text/javascript" src="../js/validate.js"></script>
<link type="text/css" href="../jquery/css/smoothness/jquery-ui-1.8.5.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../jquery/development-bundle/jquery-1.4.2.js"></script>
<script type="text/javascript" src="../jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>  
<script type="text/javascript" language="javascript">
<!--		
function validateForm()
{
	var errormsg;
	errormsg = "";					          
	
	var date1=document.FormName.PublishDate.value;	
	var tmpdate1=date1.split("/");	
				
	if (document.FormName.PromotionName.value == "")
			errormsg += "Please fill in 'Promotion Name'.\n";
	
	if(date1=="" || date1=="DD/MM/YYYY")
	{
		errormsg += "Please choose 'Publish Date'.\n";
	}	
	/*else
	{	
		var currentTime = new Date();
		var month = currentTime.getMonth() + 1;
		var day = currentTime.getDate();
		var year = currentTime.getFullYear();
		if(month == 0 || month == 1 || month == 2 || month == 3 || month == 4 || month == 5 || month == 6 || month == 7 || month == 8 || month == 9 )
		{
			var month1 = "0"+month;
		}
		var curdate = day + "/" + month1 + "/" + year;	
		
		if( date1 < curdate)
		{
			errormsg += "Publish Date must be Future Date.\n";
		}
		
		if (!isDate(tmpdate1[2], tmpdate1[1], tmpdate1[0]))
				errormsg += "Please select a valid 'Publish Date'.\n";
	}*/
			
	if (document.FormName.BriefInfo.value == "")
		errormsg += "Please fill in 'Brief Info'.\n";
								
	var fckEditor = FCKeditorAPI.GetInstance('FCKeditor1');                    
	var sFckEditor = fckEditor.EditorDocument.body.innerHTML;
	
	if(sFckEditor != ""){
		sFckEditor = sFckEditor.replace(/&nbsp;/gi,'');
		sFckEditor = sFckEditor.replace(/<br>/gi,'');
		sFckEditor = sFckEditor.replace(/<br\/>/gi,'');
		sFckEditor = sFckEditor.replace(/<br \/>/gi,'');
		sFckEditor = sFckEditor.replace(/\n/gi,'');
		sFckEditor = sFckEditor.replace(/" "/gi,'');
		sFckEditor = jQuery.trim(sFckEditor);
	}
	if(sFckEditor == '')
		errormsg += "Please fill in 'Description'.\n";	

	if(document.FormName.Status1.checked == false)
	{		
		if(document.FormName.Status2.checked == false)
		{
			errormsg += "Please Select 'Status'.\n";
		}
	}
	if ((errormsg == null) || (errormsg == ""))
	{
		document.FormName.btnSubmit.disabled=true;
		return true;
	}
	else
	{
		alert(errormsg);
		return false;
	}
}

function ClearAll()
{
	for (var i=0;i<document.FormName.elements.length;i++) {
		if (document.FormName.elements[i].type == "text" || document.FormName.elements[i].type == "textarea")
			document.FormName.elements[i].value = "";
		else if (document.FormName.elements[i].type == "select-one")
			document.FormName.elements[i].selectedIndex = 0;
		else if (document.FormName.elements[i].type == "checkbox" || document.FormName.elements[i].type == "radio")
			document.FormName.elements[i].checked = false;
	}
	var fckEditor = FCKeditorAPI.GetInstance('FCKeditor1');
	fckEditor.EditorDocument.body.innerHTML = '<br />';
}

$(function(){
	$('.datepicker').datepicker({
		changeDate: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		yearRange: '1900:+0'
	});			
});
//-->
</script>
</head>
<body>
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
						<td width="850" align="left" style="padding-left:5px;" valign="top">															
						<!--
						Start Contact
						-->
							<table cellpadding="0" cellspacing="0" border="0" width="840">
								<tr>
								  <td align="left" class="TitleStyle"><b><?=$PageStatus?></b></td>
								</tr>
								<tr><td height=""></td></tr>
							</table>							
							<form name="FormName" action="promotionaction.php" method="post" onsubmit="return validateForm();">
							<input type="hidden" name="id" value="<?=$id?>" />
							<input type="hidden" name="e_action" value="<?=($e_action == "" ? "AddNew" : "Edit")?>" />
							<input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />
                            <input type='hidden' name='Content' value="<?=$Description ?>" />
							<table cellpadding="0" cellspacing="0" border="0" width="840">
																							
								<tr><td height="10"></td></tr>
								<tr>
								   <td>Promotion Name&nbsp;</td>
								   <td>&nbsp;:&nbsp;</td>
								   <td width="700">
									<input type="text" autocomplete="off" id="PromotionName" name="PromotionName" value="<?php echo $PromotionName; ?>" size="60" class="txtbox1" />
									<font style="vertical-align: top; color: rgb(255, 0, 0);">*</font>
									</td>
								</tr>
								<tr><td height="10"></td></tr>																								
								<tr>
									<td width="120">Publish Date</td>
									<td width="10">&nbsp;:&nbsp;</td>
									<td>
										<input id="PublishDate"  name="PublishDate" type="text" autocomplete="off" class="datepicker" size="10" readonly="readonly" value="<?=($PublishDate!="" ? $PublishDate : "DD/MM/YYYY")?>" style="font-family: Arial; font-size: 11px; margin-top:2px;" />    
										<font style="vertical-align: top; color: rgb(255, 0, 0);">*</font>
									</td>
								</tr>
								<tr><td height="10"></td></tr>                                        
								<tr>
									<td valign="top">Brief Info&nbsp;</td>
									<td valign="top">&nbsp;:&nbsp;</td>
									<td>
                                    <textarea id="BriefInfo" name="BriefInfo" cols="57" rows="5" class="textarea"><?=$BriefInfo?></textarea>
									<font style="vertical-align: top; color: rgb(255, 0, 0);">*</font>
                                    </td>
								</tr>																
								<tr><td height="10"></td></tr>
								<tr>
                                    <td align="left" valign="top" width="118">Description</td>
                                    <td align="left" valign="top" width="6">:</td>
                                    <td align="left" valign="top" width="700">
                                    <?php
									// Automatically calculates the editor base path based on the _samples directory.
									// This is usefull only for these samples. A real application should use something like this:
									// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
									$sBasePath = 'fckeditor/';
									$oFCKeditor = new FCKeditor('FCKeditor1');
									$oFCKeditor->Width = "650px";
									$oFCKeditor->Height = "450px";
									$oFCKeditor->BasePath = $sBasePath;
									$oFCKeditor->Value = replaceSpecialCharBack($Description);
									$oFCKeditor->Create();
									?>
									<font style="vertical-align: top; color: rgb(255, 0, 0);">*</font>
                                    </td>
                                </tr>
								<tr><td height="10"></td></tr>
                                <tr>
                                    <td width="97">Status</td>
                                    <td width="10">:</td>
                                    <td width="731">
                                        <input name="Status" id="Status1" type="radio" value="S" checked = 'checked'
<?php if($Status=="S") {?> checked = 'checked' <?php } ?> />Show&nbsp;&nbsp;&nbsp;
                                        <input id="Status2" name="Status" type="radio" value="H" <?php if($Status=="H") {?> checked = 'checked' <?php } ?> />Hide&nbsp;   
										<font style="vertical-align: top; color: rgb(255, 0, 0);">*</font>
                                    </td>
                                </tr>
                                <tr><td height="10"></td></tr>	
								<tr>
									<td colspan="2">&nbsp;</td>
									<td>
										<input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />&nbsp;
                                        <input type="button" name="btnClearAll" class="button1" value="Clear All" onclick="ClearAll();" />&nbsp;
										<input type="button" class="button1" name="btnCancel" value="Cancel" onclick="window.location='promotions.php?PageNo=<?=$_GET['PageNo']?>';" />
									</td>
								</tr>
							</table>
							</form>
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
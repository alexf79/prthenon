<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }

	include('../global.php');	
	include('../include/functions.php');  
	include("fckeditor/fckeditor.php");
	
	foreach($_GET as $k=>$v)
	{
	   $_GET[$k] = decrypt($v,$Encrypt);
	}
 	foreach($_REQUEST as $k=>$v)
	{
	   $_REQUEST[$k] = decrypt($v,$Encrypt);
	}
	foreach($_POST as $k=>$v)
	{
	   $_POST[$k] = decrypt($v,$Encrypt);
	}	
	
	$PageStatus = "Add Product Detail";	
	$btnSubmit = "Submit";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];
	
	$AdminProductPicPath = "images/products/";
	$ProductFilePath = "../files/";
	if($id != "" && $e_action == 'edit')
	{
	
		
		
		$str = "SELECT * FROM ".$tbname."_product where _ID= '".replaceSpecialChar($id)."' ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{			
			$rs = mysql_fetch_assoc($rst);
			$catid = $rs["_Catid"];
			$title = $rs["_Title"];				
			$s_des = $rs["_Short_Des"];
			
			

			$PageStatus = "Edit Product Detail";
			$btnSubmit = "Update";
		}	
		
		
	}

	if($_GET['error'] == 1)
	{
		$MenuText = $_GET["mtext"];
	}
	
	if ($CatID == ""){
		$CatID = $_REQUEST['Category'];
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
	<script language="javascript" type="text/javascript">
		<!--
		var valid_imgextensions = /(.jpeg|.JPEG|.jpg|.JPG|.gif|.GIF|.png|.PNG)$/i;
				
		function validateForm()
		{			
			var errormsg;
            errormsg = "";
			var conname="";
			var weburl = /^(((www.){1}))[-a-zA-Z0-9@:%_\+.~#?&//=]+$/;
			
			
			if(document.Product.category.value=="")
				errormsg += "Please Select 'Category'.\n";
			
			if (document.Product.P_title.value == "")
                errormsg += "Please fill in 'Product Title'.\n";
      		
				
			if (document.Product.S_des.value == "")
                errormsg += "Please fill in 'Short Descreption'.\n";
			/*if (document.Product.city.value == "")
                errormsg += "Please fill in 'city'.\n";	*/	
			
			
			
			
            if ((errormsg == null) || (errormsg == ""))
            {
                document.Product.btnSubmit.disabled=true;
                return true;
            }
            else
            {
                alert(errormsg);
                return false;
            }
		}
		
		function title_validate(txtval)
		{
			var flag=0;
			var strText = txtval;
			if (strText!="")
			{
			   var strArr = new Array();
			   strArr = strText.split("");
			  
			   if(strArr[0]==" ") // this's the the key part. you can do whatever you want here....!!
			   {
				 flag=1;
			   }
			}
			
			if(flag == 1 )
			{         
				return false;
			}
			return true;
		}
		
		
		
		//-->
	</script>
</head>
<body >
	<table align="center" width="98%"   border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		<tr>
			<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					<tr>
						<td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
					</tr>
					
					<tr>
						
						<td width="100%" align="left" valign="top" class="TitleStyle toptd" style="padding-left:5px; padding-top:6px;">
						<div class="m">
								 <b><?=$PageStatus?></b><br/><br/>
						<!--
						Start Contact
						-->
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr><td height=""></td></tr>
							</table>							
							<form name="Product" action="productaction.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?=$id?>" />
							<input type="hidden" name="e_action" value="<?=($e_action == "" ? "AddNew" : "Edit")?>" />
							<input type="hidden" name="PageNo" value="<?=$_GET['PageNo']?>" />                          
							<table cellpadding="0" cellspacing="0" border="0" width="100%" >								
                                <tr><td height="10"></td></tr>
                                <tr>
									<td width="120">Select Category</td>
									<td width="10">&nbsp;:&nbsp;</td>			
									<td>
                                    <?php
									$sel_cat="select * from ".$tbname."_category ";
									$qr_cat=mysql_query($sel_cat);
									?>
	                               	<select name="category">
                                    <option value="">Select Category</option>
                                    <?php
									while($rs_cat=mysql_fetch_array($qr_cat))
									{
										?>
                                        <option <?php if($catid == $rs_cat['_ID']) { ?> selected="selected" <?php } ?> value="<?php echo $rs_cat['_ID']; ?>"><?php echo $rs_cat['_Name']; ?></option>
                                        <?php
									}
									?>
                                    </select>
                  					<font style=" vertical-align: top; color: rgb(255, 0, 0);">*</font>								  </td>
								</tr>
                                
                                <tr><td height="10"></td></tr>
								<tr>
									<td width="120">Product Title</td>
									<td width="10">&nbsp;:&nbsp;</td>			
									<td >
	                               	<input class="txtbox1" style="width:255px;" type="text" name="P_title" value="<?=$title;?>" />
                  					<font style=" vertical-align: top; color: rgb(255, 0, 0);">*</font>								  </td>
								</tr>
                                
                                <tr><td height="10"></td></tr>
                                <tr>
									<td valign="top">Short Description</td>
									<td valign="top">&nbsp;:&nbsp;</td>
									<td valign="top"><textarea name="S_des" class="txtbox1" style="height:80px; width:255px;"><?php echo replaceSpecialCharBack($s_des); ?></textarea><font style=" vertical-align: top; color: rgb(255, 0, 0);"> *</font></td>
								</tr>
								<tr><td height="10"></td></tr>
								
								<tr>
									<td colspan="2">&nbsp;</td>
									<td>
										<input type="submit" name="btnSubmit" class="button1" value="<?=$btnSubmit?>" />&nbsp;
										<input type="button" class="button1" name="btnCancel" value="Cancel" onclick="window.location='products.php?PageNo=<?=encrypt($_GET['PageNo'],$Encrypt)?>';" />									</td>
								</tr>
							</table>
							</form>
							</div>
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
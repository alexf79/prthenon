<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']=="")
	{
		echo "<script language='javascript'>window.location='login.php';</script>";
	}
	else
	{
		include('../global.php');
    	include('../include/functions.php');
    	include("fckeditor/fckeditor.php");
		mysql_select_db($database, $connect) or die(mysql_error());
		
		$HomePageImagePath1 = "../images/bottomleft/";
		
	$TypeID = decode(trim($_GET['typeid']));
	
	$str = "SELECT * FROM ".$tbname."_home_cms WHERE _TypeID = '".replaceSpecialChar($TypeID)."' ";
		
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);					
			$ID = $rs["_ID"];	
			$TypeID = $rs["_TypeID"];
			$Display = $rs["_Display"];	
			$HTMLContent = $rs["_HTMLContent"];				
			$Hyperlink = replaceSpecialCharBack($rs["_Hyperlink"]);		
			$brifinfo = $rs["_brifInfo"];	
			$NewIcon = $rs["_Image1"];	
			$withLogin = $rs['_withLogin'];
		    $withoutLogin = $rs['_withoutLogin'];
		}
		
		$strTypeName = "SELECT ".$tbname."_hometypes._ID AS ID, _TypeName FROM ".$tbname."_hometypes WHERE _ID='" . replaceSpecialChar($TypeID) . "'";
		$rstTypeName = mysql_query($strTypeName, $connect) or die(mysql_error());
		if(mysql_num_rows($rstTypeName) > 0)
		{
			  $rsTypeName = mysql_fetch_assoc($rstTypeName);			
			  $TypeName=$rsTypeName["_TypeName"]; 			
		}		
 
?>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title><?php echo $appname; ?></title>
		<link rel="stylesheet" type="text/css" href="../css/admin.css" />
		<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="../js/validate.js"></script>
    
		<script language="javascript">
		<!--
		function validateForm()
		{						
			var errormsg;
            errormsg = "";	
				
			if (document.FormName.PageTitle1.value == "" && document.FormName.PageTitle2.value == "")
            	errormsg += "Please fill in 'Page Title'.\n";
			
			if (document.FormName.RedirectURL.value == "")     
			{
            var fckEditor = FCKeditorAPI.GetInstance('FCKeditor1');                    
            if(fckEditor.EditorDocument.body.innerHTML=='<BR>' ||  fckEditor.EditorDocument.body.innerHTML=='<br>' || fckEditor.EditorDocument.body.innerHTML=='&nbsp;' || fckEditor.EditorDocument.body.innerHTML=='')
                errormsg += "Please fill in 'HTML Content'.\n";
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
		
		function SubmitForm()
                {                  
                    document.FormName.e_action.value = "EditPreview";                       
					document.FormName.btnPreview.disabled=true;
					document.FormName.submit();
										              
                }						
		
		function showhidediv(type)
		{
			eval("document.getElementById('Div1').style.display = 'none'");
			eval("document.getElementById('Div2').style.display = 'none'");					

			if(type=="1")
			{
				eval("document.getElementById('Div2').style.display = 'block'");	
				eval("document.getElementById('Div1').style.display = 'none'");		
				document.getElementById('PageTitle1').value =''; 			
			}
			else if(type=="2")
			{
				//document.FormName.btnPreview.disabled=true;
				document.getElementById('btnPreview').style.visibility='hidden';
			}
			else if(type=="3")
			{
				//document.FormName.btnPreview.disabled=true;
				document.getElementById('btnPreview').style.visibility='hidden';
			}
			else
			{
				eval("document.getElementById('Div1').style.display = 'block'");	
				eval("document.getElementById('Div2').style.display = 'none'");		
				document.getElementById('PageTitle2').value =''; 
				//document.FormName.btnPreview.disabled=false;		
				document.getElementById('btnPreview').style.visibility='visible';
			}
		}	
		
		function FormLoad(val)
		{					
			if(val=="Home" || val=="Static")
			{
				//document.FormName.btnPreview.disabled=true;
				document.getElementById('btnPreview').style.visibility='hidden';
			}
		}		
		//-->
		</script>
		</head>
		<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" onLoad="FormLoad('<?=$Type?>');">
			<table align="left" width="1000" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
				<tr>
					<td valign="top">
						<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
							<tr><td height="10" bgcolor="#c1defe"></td></tr>
							<tr>
								<td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
							</tr>
							<tr><td height="10" bgcolor="#c1defe"></td></tr>
							<tr>
								<td width="150" align="left" valign="top" bgcolor="#c1defe"><?php include('left.php'); ?></td>
								<td width="850" align="left" style="padding-left:5px;" valign="top">
									<table width="835" border="0" cellspacing="0" cellpadding="0">
										<tr><td align="left" class="TitleStyle"><b>Web Pages CMS - Home - <?php echo $TypeName; ?></b></td></tr>
										<tr><td height="10"></td></tr>
										
										<tr>
											<td>
												<?php
													if($ID != "")
													{
												?>
														<form name="FormName" method="post" action="homeleftbottom_action.php?typeid=<?php echo $TypeID; ?>" onSubmit="return validateForm();" enctype="multipart/form-data">
								  						<table width="100%" border="0" cellspacing="0" cellpadding="2">							
															
                                                                <tr>
																	<td width="115">1st Level</td>
																	<td width="6">:</td>
																	<td width="703">Home
                                                                    	<input type="hidden" name="id" value="<?php echo $ID;?>">																			
                                                                        <input type="hidden" name="typeID" value="<?php echo $TypeID;?>">	
                                                                        <input type="hidden" name="e_action" value="edit">
                                                                        <input type='hidden' name='Content' value="<?=$HTMLContent ?>">
                                                                    </td>
																																		</tr>
																																		<tr>
																																			<td colspan="3">                                                                
                                                                        <table cellpadding="0" cellspacing="0" border="0">
                                                                        <tr>
                                                                            <td width="120">Type Name</td>
                                                                            <td width="10">:</td>
                                                                            <td width="703"><?php echo $TypeName; ?></td>
                                                                        </tr>
                                                                        <tr><td>&nbsp;</td></tr>
                                                                        <tr>
				                                                                    <td width="120" valign="top">Brief Info</td>
				                                                                    <td width="10" valign="top">:</td>
				                                                                    <td width="703"><textarea name="brifinfo" id="brifinfo" cols="25" rows="5"><?php echo $brifinfo; ?></textarea></td>
				                                                                </tr>
                                                                        </table>                                                                   
                                                                    </td>
																															</tr>                                                            
																																										
																															<tr>
                                                                    <td align="left" valign="top" width="118">Image</td>
                                                                    <td align="left" valign="top" width="6">:</td>
                                                                    <td align="left" valign="top" width="700">                                                         
					                                                    <?php 
					                                                    	if(file_exists($HomePageImagePath1.$NewIcon) && $NewIcon != "") {
																																?>
																																	<a href="<?php echo $HomePageImagePath1.$NewIcon;?>" target="_blank" style="color:#FF0000; font-family:arial; font-size:11px;"><?php echo $NewIcon; ?></a>&nbsp;
																																	<a href="homeleftbottom_action.php?id=<?php echo $ID;?>&value=_NewIcon&e_action=objdelete&typeid=<?php echo $TypeID; ?>" onclick="if(confirm('Are you sure you want to delete this Image?')) return true; else return false;" onMouseOver="write_it('Delete File');return true;" class="link1">[<img src="../images/delfilepic.gif" border="0" alt="Delete File"> Delete File]</a>
																																<?php
																																}else{
																																?>
																																	<input type="file" name="NewIcon" class="txtbox1" />										
																																<?php
																																}
																																?>
																																</tr>											
								   <tr>
										<td align="left" valign="top" width="118">HTML Content</td>
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
										$oFCKeditor->Value = replaceSpecialCharBack($HTMLContent);
										$oFCKeditor->Create();
										
										?>
								  </tr>   
								  
								  <tr>
										<td align="left" valign="top" width="118">After Login</td>
										<td align="left" valign="top" width="6">:</td>
										<td align="left" valign="top" width="700">
										<input type="checkbox" name="withlogin" value="1" <?php if(isset($withLogin) && $withLogin == "1") { ?> checked="checked" <?php } ?> >
										</td>
								  </tr>
								  
								   <tr>
										<td align="left" valign="top" width="118">Before Login</td>
										<td align="left" valign="top" width="6">:</td>
										<td align="left" valign="top" width="700">
										<input type="checkbox" name="withoutlogin" value="1" <?php if(isset($withoutLogin) && $withoutLogin == "1") { ?> checked="checked" <?php } ?> >
										</td>
								  </tr>
                                                             
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td align="left"><input type="submit" class="button1" name="btnSubmit" value="Submit">&nbsp;<input type="button" class="button1" name="btnCancel" value="Cancel" onClick="window.location='2ndlvlhomecms.php';"><!--&nbsp;<input type="button" class="button1" id="btnPreview" name="btnPreview" value="Preview" onClick="window.open('<?=$httpAddress?>','mywindow');SubmitForm();">--></td>
                                                        </tr>
														<tr><td height="5"></td></tr>														
														</table>
                                                        </form>
											  <?php
													}
													else
													{
														echo "<table width='100%' border='0' cellspacing='0' cellpadding='2'><tr><td align='center' height='25'>&nbsp;<b><font color='#FF0000'>No Record Found.</font></b>&nbsp;</td></tr></table>";
													}
												?>
											</td>
									  </tr>
									</table>
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
	}
?>
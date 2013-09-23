<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    echo "<script language='javascript'>window.location='login.php';</script>";
} else {
    include('../global.php');
    include('../include/functions.php');
    include("fckeditor/fckeditor.php");    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            <title><?=$appname?></title>
            <link rel="stylesheet" type="text/css" href="../css/admin.css" />
			<link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />
            <script language="javascript" type="text/javascript" src="../js/validate.js"></script>
			<script type="text/javascript" src="../jquery/development-bundle/jquery-1.4.2.js"></script>
            <script type="text/javascript" language="javascript">
                <!--
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

				
                function validateForm()
                {                    
					
						
                    var errormsg;
                    errormsg = "";
    
                    if (document.FormName.PageTitle.value == "")
					{
                        errormsg += "Please fill in 'Menu/Page Title'.\n";
					}else{
							
							 if(!title_validate(document.FormName.PageTitle.value))
							   {
								errormsg += "Please Enter Valid 'Menu/Page Title'.\n";
							   }
  					}
					
					if (document.FormName.RedirectURL.value == "")     
					{
					
					
					/*var fckEditor = FCKeditorAPI.GetInstance('TitleFCKeditor');                    
					var sFckEditor = fckEditor.EditorDocument.body.innerHTML;
					
					if(sFckEditor != ""){
						sFckEditor = sFckEditor.replace(/&nbsp;/gi,'');
						sFckEditor = sFckEditor.replace(/<br>/gi,'');
						sFckEditor = sFckEditor.replace(/<br\/>/gi,'');
						sFckEditor = sFckEditor.replace(/<br \/>/gi,'');
						sFckEditor = sFckEditor.replace(/\n/gi,'');
						sFckEditor = sFckEditor.replace(/" "/gi,'');
						sFckEditor = jQuery.trim(sFckEditor);
					}*/
		
					if(document.FormName.TitleFCKeditor.value == '')
						errormsg += "Please fill in 'Sort Description'.\n";
					
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
                    document.FormName.e_action.value = "AddPreview";                       
					document.FormName.btnPreview.disabled=true;
					document.FormName.submit();					              
                }
				               
                //-->
            </script>
        </head>
        <body>
            <table align="center" width="98%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            
                            <tr>
                                <td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
                            </tr>
                            
                            <tr>
                               
                                <td class="toptd" width="100%" align="left" style="padding-left:5px;" valign="top">
								<div class="m">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td align="left" class="TitleStyle"><b>Add Page</b></td></tr>
                                        <tr><td height="10"></td></tr>
                                        <tr><td align="right"><!--<a href="1stlvlcms.php" class="TitleLink"><b>List 1st Level</b></a>--></td></tr>
										<?php
                                            if ($_GET["id"] != "") {
												 $str = "SELECT * FROM " . $tbname . "_cms WHERE _ID = '" . replaceSpecialChar($_GET["id"]) . "' ";

												$rst = mysql_query($str, $connect) or die(mysql_error());
												if (mysql_num_rows($rst) > 0) {
													$rs = mysql_fetch_assoc($rst);
													$ID = $rs["_ID"];
													$PageTitle = $rs["_PageTitle"];
													$RedirectURL = $rs["_RedirectURL"];
													$Title = $rs["_Title"];
													$HTMLContent = $rs["_HTMLContent"];
													$Hyperlink = $rs["_Hyperlink"];
													$MetaTitle = $rs['_MetaTitle'];
													$MetaDec = $rs['_MetaDescription'];
													$MetaKey = $rs['_MetaKeyWords'];
													$MetaAdd = $rs['_MetaAdditional'];
													$withLogin = $rs['_withLogin'];
													$withoutLogin = $rs['_withoutLogin'];
													$Status = $rs['_Status'];
												}
                                               echo "<script language='JavaScript'>window.open('".$httpAddress."/page.php?n=".str_replace(" ","+",$PageTitle)."&id=".encode($ID)."','mywindow')</script>";
                                            }
                                        ?>
                                    <tr>
                                        <td>
										<form name="FormName" method="post" action="1stlvlcms_action.php" onsubmit="return validateForm();" enctype="multipart/form-data">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                    <tr>
                                                        <td width="118">Menu/Page Title
														<input type="hidden" name="PID" value="0" />
                                                    <input type="hidden" name="Level" value="1" />
                                                    <input type="hidden" name="e_action" value="AddNew" />
                                                    <input type='hidden' name='Content' />
                                                    <input type='hidden' name='PreviewID' value="<?=$ID?>" />
														</td>
                                                        <td width="6">:</td>
                                                        <td width="700"><input type="text"  autocomplete="off" id="PageTitle" name="PageTitle" value="<?=$PageTitle?>" size="100" class="txtbox1" /><font style="vertical-align: top; color: rgb(255, 0, 0);"> *</font></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Redirect URL</td>
                                                        <td>:</td>
                                                        <td><input type="text" autocomplete="off" id="RedirectURL" name="RedirectURL" value="<?=$RedirectURL?>" size="100" class="txtbox1" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="top" width="118">Sort Description</td>
                                                        <td align="left" valign="top" width="6">:</td>
                                                        <td align="left" valign="top" width="700">
                                                        <?php
                                                            // Automatically calculates the editor base path based on the _samples directory.
                                                            // This is usefull only for these samples. A real application should use something like this:
                                                            // $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.
                                                            
                                                        ?>
														<textarea name="TitleFCKeditor" class="txtbox1" style="width:647px; height:150px;"><?php echo replaceSpecialCharBack($Title); ?></textarea>
														<font style="vertical-align: top; color: rgb(255, 0, 0);">*</font>
                                                        </td>
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
															if($HTMLContent=="")
															{
                                                            	$oFCKeditor->Value = '<br />';
															}
															else
															{
																$oFCKeditor->Value = replaceSpecialCharBack($HTMLContent);
															}
                                                            $oFCKeditor->Create();
                                                        ?>
                                                      <font style="vertical-align: top; color: rgb(255, 0, 0);">*</font></td>
                                                    </tr>
                                                    
													
												<tr>
													<td align="left" valign="top">Status</td>
													<td align="left" valign="top">:</td>
													<td align="left">
													<select name="Status" class="dropdown1">
														<option value="Live" <?=($Status=="Live" ? "selected" : "")?>>Live</option> 
														<option value="Draft" <?=($Status=="Draft" ? "selected" : "")?>>Draft</option>
													</select>
													</td>
												</tr>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td align="left">
														<input type="submit" class="button1" name="btnSubmit" value="Submit" />
														&nbsp;<input type="button" class="button1" name="btnCancel" value="Cancel" onclick="window.location='1stlvlcms.php?PageNo=<?=$_GET['PageNo']?>';" />
														&nbsp;</td>
                                                    </tr>
                                                    <tr><td height="5"></td></tr>
                                               
                                            </table>
											 </form>
                                        </td>
                                    </tr>
                                </table>
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
}
?>
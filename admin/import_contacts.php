<?php
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');
	include('../dbopen.php');
	include('../include/functions.php');  
	mysql_select_db($database, $connect) or die(mysql_error());
		
	$PageStatus = "Add New Contact";	
	$btnSubmit = "Submit";
	$btnAdd = "Add";
	$btnUpdate = "Update";
	$id = $_GET['id'];
	$e_action = $_GET['e_action'];	
	if($e_action=="")
	   $e_action = "add";
	 if(isset($_REQUEST['maxtempid']) && trim($_REQUEST['maxtempid'])!="")
		  {
		  	
		  	
		  	$Maxid=trim($_REQUEST['maxtempid']);
		  	
		  	if(isset($_SESSION["'".$Maxid."'"]))
		  	{
		  		if(isset($_SESSION["'".$Maxid."'"]['RadioButContactType']))
		  		{
				  	$ContactTypeID=$_SESSION["'".$Maxid."'"]['RadioButContactType'];
				  }
				  if(isset($_SESSION["'".$Maxid."'"]['ContactGroup']))
		  		{
				  	$ContactGroupID =$_SESSION["'".$Maxid."'"]['ContactGroup'];
				  }
				  
					if(isset($_SESSION["'".$Maxid."'"]['CompanyName']))
		  		{
				  	$CompanyName=$_SESSION["'".$Maxid."'"]['CompanyName'];
				  }
				  
					if(isset($_SESSION["'".$Maxid."'"]['RegNo']))
		  		{
				  	$RegNo=$_SESSION["'".$Maxid."'"]['RegNo'];
				  }
				  	if(isset($_SESSION["'".$Maxid."'"]['Salutation']))
		  		{
				  	$SalutationID=$_SESSION["'".$Maxid."'"]['Salutation'];
				  }
				  if(isset($_SESSION["'".$Maxid."'"]['ContactName']))
		  		{
				  	$ContactName=$_SESSION["'".$Maxid."'"]['ContactName'];
				  }
				  if(isset($_SESSION["'".$Maxid."'"]['NRIC']))
		  		{
				  	$NRIC=$_SESSION["'".$Maxid."'"]['NRIC'];
				  }
				  if(isset($_SESSION["'".$Maxid."'"]['OfficeAddress']))
		  		{
				  	$OfficeAddress=$_SESSION["'".$Maxid."'"]['OfficeAddress'];
				  }
				  if(isset($_SESSION["'".$Maxid."'"]['OfficeTel1']))
		  		{
				  	$OfficeTel1=$_SESSION["'".$Maxid."'"]['OfficeTel1'];
				  }
				    if(isset($_SESSION["'".$Maxid."'"]['OfficeTel2']))
		  		{
				  	$OfficeTel2=$_SESSION["'".$Maxid."'"]['OfficeTel2'];
				  }
				    if(isset($_SESSION["'".$Maxid."'"]['OfficeFax1']))
		  		{
				  	$OfficeFax1=$_SESSION["'".$Maxid."'"]['OfficeFax1'];
				  }
				    if(isset($_SESSION["'".$Maxid."'"]['OfficeFax2']))
		  		{
				  	$OfficeFax2=$_SESSION["'".$Maxid."'"]['OfficeFax2'];
				  }
				    if(isset($_SESSION["'".$Maxid."'"]['OfficeEmail1']))
		  		{
				  	$OfficeEmail1=$_SESSION["'".$Maxid."'"]['OfficeEmail1'];
				  }
				    if(isset($_SESSION["'".$Maxid."'"]['OfficeEmail2']))
		  		{
				  	$OfficeEmail2=$_SESSION["'".$Maxid."'"]['OfficeEmail2'];
				  }
				    if(isset($_SESSION["'".$Maxid."'"]['URL']))
		  		{
				  	$URL=$_SESSION["'".$Maxid."'"]['URL'];
				  }
				    if(isset($_SESSION["'".$Maxid."'"]['Remarks']))
		  		{
				  	$Remarks=$_SESSION["'".$Maxid."'"]['Remarks'];
				  }
				   
				}
		  	$blnAddData=true;
		}
	/*$str = "SELECT max(_ID) AS maxID FROM ".$tbname."_contacts ";
	$rst = mysql_query($str, $connect) or die(mysql_error());
	if(mysql_num_rows($rst) > 0)
	{
		$rs = mysql_fetch_assoc($rst);
		if($id=="")
		{
			$TempID = $rs["maxID"]+1;				
		}
		else 
		{
			$TempID = $id;
		}		
	}*/
	
	$Fullname = $_REQUEST["Fname"];	
	$Company = $_REQUEST["Cname"];	
	
	if($e_action == 'add' || $e_action == ""){
		
		if(isset($_REQUEST['maxtempid']) && trim($_REQUEST['maxtempid'])!="")
		  {
		  	$Maxid=trim($_REQUEST['maxtempid']);
		  	
		  }
		  else
		  {
		  	$Maxid=strtotime("now");
		  }
		  $blnAddData=true;
		 
		}
	if($id != "" || $e_action == 'edit')
	{
		$Maxid = $id;
		$str = "SELECT * FROM ".$tbname."_contacts WHERE _ID = '".replaceSpecialChar($id)."' ";
		$rst = mysql_query("set names 'utf8';");	
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{			
			$rs = mysql_fetch_assoc($rst);		
			$ContactGroupID = $rs["_ContactGroupID"];			
			$CompanyName = $rs["_CompanyName"];		
			$ContactName = $rs["_FullName"];				
			$OfficeTel1 = $rs["_Tel"];				
			$OfficeFax1 = $rs["_Fax"];					
			$OfficeEmail1 = $rs["_Email"];		
			$country = $rs["_Country"];	
			$postcode = $rs["_Postcode"];	
			$address = $rs["_Address"];	
			$subject = $rs["_EmailSubject"];	
			$comments = $rs["_Comments"];	
			$where = $rs["_Where"];	
			//echo $where;exit;
			
    			
			
			/*if($where != "Google Search" || $where != "Yahoo Search" || $where != "MSN Search" || $where != "Business Associates" || $where != "Friends"){
			   $explode = explode("-",$where);
			   $where= $explode[1];
			}else {			    
			   $where = $where; 
			}*/
			$type = $rs["_EnquiryType"];	
			
			$PageStatus = "Edit Contact";
			$btnSubmit = "Update";
		}
		
	}

	if($_GET['error'] == 1)
	{
		$MenuText = $_GET["mtext"];
	}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $appname; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/admin.css" />	
     <link href="../css/adminmenubar.css" type="text/css" rel="stylesheet" />	
	<script type="text/javascript" src="../js/validate.js"></script>
	<script type="text/javascript" src="../js/calendar.js"></script>
	<script language="javascript">
		<!--
		function getCheckBoxGroupsValues(CheckboxGrps)
{
	var strReturnVal="";
	var chks =document.getElementsByName(CheckboxGrps);	
	for(intCounter=0;intCounter<chks.length;intCounter++)
	{
				if (chks[intCounter].checked)
				{
					if(strReturnVal=="")
					{
						strReturnVal=chks[intCounter].value;
					}
					else
					{
						strReturnVal = strReturnVal + ","+chks[intCounter].value;						
					}	
				}
	}
	return strReturnVal;
}
		function write_it(text){ }

		function validateForm()
		{
			var errormsg;
            errormsg = "";					
			
            if (document.Contact.ContactName.value == "")
                errormsg += "Please fill in 'Name'.\n";
	
			if (document.Contact.OfficeFax1.value == "")
                errormsg += "Please fill in 'Mobile'.\n";
		
			if (document.Contact.OfficeEmail1.value == "")
			{
				errormsg += "Please fill in 'Email'.\n";
            }   
            else
            {
                if (!isEmail(document.Contact.OfficeEmail1.value))
                    errormsg += "Please fill in valid email address in 'Email'.\n";        
            }
			
            
										
			if(document.Contact.hidstatus1.value=="Y")
			{				
				return false;
			}								
            else if ((errormsg == null) || (errormsg == ""))
            {
                document.Contact.btnSubmit.disabled=true;
                return true;
            }
            else
            {
                alert(errormsg);
                return false;
            }
		}	
		
		/* Form Validation Start Here ***********/
		function validate_upload_form()
		{
 			if(document.getElementById('file1_atrex') .value == '')
			{
			  alert("Please choose file to import contact");
			  return false;
			}
			 else if(!valid_extensions.test(document.getElementById('file1_atrex') .value))
			{
			    alert("Only csv file is allowed to import");
				return false;
			}
         }
		/* Form Validation End Here ***********/
		
		var valid_extensions = /(.csv|.CSV)$/i;
 
		
		// Removes leading whitespaces
		 
		
		function nameStateChanged() 
		{ 
			
			if (xmlHttp.readyState==4)
			{ 					
				if(xmlHttp.responseText=='Yes')
				{
					document.Contact.hidstatus1.value="Y";
					var answer = confirm ("Duplicate contacts found. Are you want to add duplicate contact?")
						
					if (!answer)	
					{										
						document.Contact.Fullname.value = "";
						document.Contact.Fullname.focus();						
					}	
					else
					{
						document.Contact.FullnameChinese.focus();			
						eval("document.getElementById('dupli').style.display = 'inline-block'");	
					}
				}
				else
				{
					document.Contact.hidstatus1.value="";
				}
			}
		}
		
		function removehid()
		{
			document.Contact.hidstatus1.value="";
		}
		
		function validateForm3()
		{
			if(checkSelected('Contact','CustCheckbox', document.Contact.cntCheck.value) == false)
			{
				alert("Please select at least one record.");
				document.Contact.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to archive the selected Item?') == true)
				{
					document.forms.Contact.action = "inventory_pr_action.php?e_action=archive";
					document.forms.Contact.submit();
				}
			}
		}
		
		function validateForm4()
		{
			if(checkSelected('Contact','CustCheckbox', document.Contact.cntCheck.value) == false)
			{
				alert("Please select at least one record.");
				document.Contact.AllCheckbox.focus();
				return false;
			}
			else
			{
				if(confirm('Are you sure you want to delete the selected Item?') == true)
				{
					document.Contact.action = "contactperson_action.php?e_action=delete";
					document.Contact.e_action.value="delete";
					document.Contact.submit();
				}
			}
		}
		
		function checkSelected(formname, msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document." + formname + "." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document." + formname + "." + msgtype + i + ".checked") == true)
					{
						return true;
					}
				}
			}
			return false;
		}

		function CheckUnChecked(msgType, count, chkbxName)
		{
			if (chkbxName.checked==true)
			{
				for (var i = 1; i<=count; i++)
				{
					 eval("document.Contact."+msgType+i+".checked = true");
				}
			}
			else
			{
				for (var i = 1; i<=count; i++)
				{
					 eval("document.Contact."+msgType+i+".checked = false");
				}
			}
		}
		//-->
	</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0">
	<table align="left" width="1000" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
		<tr>
			<td valign="top">
				<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
					<tr><td height="10" bgcolor="#C1DEFE" class="leftmenubgcolor"></td>
				  </tr>
					<tr>
						<td align="left" height="62" colspan="2"><?php include('top.php'); ?></td>
					</tr>
					<tr><td height="10" bgcolor="#C1DEFE" class="leftmenubgcolor"></td>
				  </tr>
					<tr>
						<td width="150" align="left" valign="top" bgcolor="#C1DEFE" class="leftmenubgcolor"><?php include('left.php'); ?></td>
					  <td width="850" align="center" valign="top">															
						<!--
						Start Contact
						-->
							  <div>
							<table cellpadding="0" cellspacing="0" border="0" width="840">
								<tr>
								  <td align="left" class="TitleStyle"><b>Import Contacts</b></td>
								</tr>
							</table>
							</div>
							<div style="padding-top:20px;"><form onsubmit="return validate_upload_form();" action="upload_contact.php" method="post" enctype="multipart/form-data" >
							<table cellpadding="0" cellspacing="0" border="0" width="840">
							<tr>
								<td>
									
									<b>CSV File : </b>
									<input type="file" name="file1_1"  id="file1_atrex" size="44" />
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>
									<input type="submit" name="submitBtn" value="Upload File" class="button1"  />
									<input type="button" class="button1" name="btnCancel" value="Cancel" onclick="window.location='contacts.php'" />
								</td>
							</tr>
							</table></form>
							</div>
							<div style="padding-top:20px;">
							<table cellpadding="0" cellspacing="0" border="0" width="840">
							<tr>
								<td>
									Download Sample CSV File <a href="contact.csv">here</a>
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
?>
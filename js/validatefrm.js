function validateRegForm()
{			
	var errormsg;
	errormsg = "";
	if (document.frmReg.Fname.value == "")
		errormsg += "Please fill in 'First Name'.\n";
	
		
	if (document.frmReg.Lname.value == "")
		errormsg += "Please fill in 'Last Name'.\n";
	if (document.frmReg.gender.value == "")
		errormsg += "Please fill in 'Gender'.\n";
	if (document.frmReg.bdate.value == "" || document.frmReg.bdate.value == "DD/MM/YYYY")
		errormsg += "Please Select 'Birthdate'.\n";
	if (document.frmReg.Uname.value == "")
		errormsg += "Please fill in 'Email ID'.\n";
	else
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	   	var address =document.frmReg.Uname.value;
	   	if(reg.test(address) == false ) {
		  	errormsg += "Please fill in valid email address in 'Email'.\n";
		}
	}
		
	if (document.frmReg.Pwd.value == "")
		errormsg += "Please fill in 'Password'.\n";
		
	if (document.frmReg.Rpwd.value == "")
		errormsg += "Please fill in 'Re-type Password'.\n";
		
	if (document.frmReg.Pwd.value != document.frmReg.Rpwd.value)
		errormsg += "Password does not Match .\n";
	
		
	/*if (document.frmReg.Email.value == "")
	{
		errormsg += "Please fill in 'Email ID'.\n";
	}
	else
	{
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	   	var address =document.frmReg.Email.value;
	   	if(reg.test(address) == false ) {
		  	errormsg += "Please fill in valid email address in 'Email'.\n";
		}
	}*/
	
	if ((errormsg == null) || (errormsg == ""))
	{
	   // document.Product.btnSubmit.disabled=true;
		return true;
	}
	else
	{
		alert(errormsg);
		return false;
	}
}
function loginfrm()
{			
	var errormsg;
	errormsg = "";
	
	if (document.login.username.value == "")
		errormsg += "Please fill in 'User Name'.\n";	
		
	if (document.login.password.value == "")
		errormsg += "Please fill in 'Password'.\n";
	
	if ((errormsg == null) || (errormsg == ""))
	{
	   // document.Product.btnSubmit.disabled=true;
	    if (document.login.checker.checked){ toMem(this);}
		return true;
	}
	else
	{
		alert(errormsg);
		return false;
	}
}
function validesugg()
{			
	var errormsg;
	errormsg = "";
	
	if (document.suggetionfrm.Name.value == "")
		errormsg += "Please fill in 'Name'.\n";	
		
	if (document.suggetionfrm.Email.value == "")
		errormsg += "Please fill in 'Email'.\n";
	if (document.suggetionfrm.Suggestion.value == "")
		errormsg += "Please fill in 'Suggestion'.\n";
	
	if ((errormsg == null) || (errormsg == ""))
	{
	   // document.Product.btnSubmit.disabled=true;
		return true;
	}
	else
	{
		alert(errormsg);
		return false;
	}
}
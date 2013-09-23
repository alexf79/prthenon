var xmlHttp

function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
  	{
		xmlHttp=new XMLHttpRequest();
  	}
	catch (e)
	{
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}

function checkusername()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	
	var url="checkexisted.php?CheckValue="+document.FormName.Username.value+"&Types=Username&TName=member&sid="+Math.random();

	xmlHttp.onreadystatechange=UsernameStateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function UsernameStateChanged() 
{ 
	if (xmlHttp.readyState==4)
	{
		document.FormName.UsernameExisted.value=xmlHttp.responseText;
	}
}

function CheckAvailability(UserName)
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url="checkavailability.php?userid="+UserName+"";
	xmlHttp.onreadystatechange=CheckAvailStateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function CheckAvailStateChanged()
{
	if (xmlHttp.readyState==4)
	{
		var userstatus = document.getElementById("userstatus");
		document.getElementById('ajax_load').style.display = 'none';
		userstatus.innerHTML = xmlHttp.responseText;
	}
}

function admincheckusername()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url="checkexistedadmin.php?CheckValue="+document.Member.TempUsername.value+"&Types=Username&TName=member&sid="+Math.random();

	xmlHttp.onreadystatechange=AdminUsernameStateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function AdminUsernameStateChanged() 
{ 
	
	if (xmlHttp.readyState==4)
	{ 
		document.Member.TempUsernameExisted.value=xmlHttp.responseText;
	}
}

function admincheckemail()
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url="checkexistedadmin.php?CheckValue="+document.Member.Email.value+"&Types=Email&TName=member&sid="+Math.random();

	xmlHttp.onreadystatechange=AdminEmailStateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function AdminEmailStateChanged() 
{ 
	if (xmlHttp.readyState==4)
	{ 
		document.Member.EmailExisted.value=xmlHttp.responseText;
	}
}

function validateLogin()
{
	var errormsg;
	errormsg = "";

	if (document.Login.Username.value == "")
		errormsg += "Please fill in 'Username'.\n";
		
	if (document.Login.Password.value == "")
		errormsg += "Please fill in 'Password'.\n";

	if ((errormsg == null) || (errormsg == ""))
	{
		if (document.Login.checker.checked) { toMem(this); }
		return true;
	}
	else
	{
		alert(errormsg);
		return false;
	}
}

function validateLoginBox()
{
	var errormsg;
	errormsg = "";

	if (document.LoginBox.Username.value == "")
		errormsg += "Please fill in 'Username'.\n";
		
	if (document.LoginBox.Password.value == "")
		errormsg += "Please fill in 'Password'.\n";

	if ((errormsg == null) || (errormsg == ""))
	{
		if (document.LoginBox.checker.checked) { toMemLoginBox(this); }
		return true;
	}
	else
	{
		alert(errormsg);
		return false;
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////
function newCookie(name,value,days) 
{
	var days = 1;
	if (days) {
	var date = new Date();
	date.setTime(date.getTime()+(days*24*60*60*1000));
	var expires = "; expires="+date.toGMTString(); }
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/"; 
}

function readCookie(name)
{
	var nameSG = name + "=";
	var nuller = '';
	if (document.cookie.indexOf(nameSG) == -1)
		return nuller;
	
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameSG) == 0) return c.substring(nameSG.length,c.length); 
	}
	return null; 
}

function eraseCookie(name)
{
	newCookie(name,"",1);
}

function toMem(a)
{
	newCookie('username', document.Login.Username.value);
	newCookie('password', document.Login.Password.value);
}

function Checker(a)
{
	if(document.Login.Username.value != '' && document.Login.Password.value != '')  
	{  	
		document.Login.checker.checked=true;
	}
}

function delMem(a)
{
	if(document.Login.checker.checked==false)
	{
		eraseCookie('username');
		eraseCookie('password');
	}	
}

function toMemLoginBox(a)
{	
	newCookie('username', document.LoginBox.Username.value);
	newCookie('password', document.LoginBox.Password.value);
}

function CheckerLoginBox(a)
{
	if(document.LoginBox.Username.value != '' && document.LoginBox.Password.value != '')  
	{  	
		document.LoginBox.checker.checked=true;
	}
}

function delMemLoginBox(a)
{
	if(document.LoginBox.checker.checked==false)
	{
		eraseCookie('username');
		eraseCookie('password');
	}	
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////

function ShowTopCMS(strRec)
{ 
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url="gettopcms_xml.php";
	url=url+"?strRec="+strRec;
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=ShowTopCMSStateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
function ShowTopCMSStateChanged() 
{ 
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById("topcmspicgroup").innerHTML=xmlHttp.responseText;
	}
}

function ShowBottomCMS(strRec)
{ 
	xmlHttp2=GetXmlHttpObject();
	if (xmlHttp2==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url="getbottomcms_xml.php";
	url=url+"?strRec="+strRec;
	url=url+"&sid="+Math.random();
	xmlHttp2.onreadystatechange=ShowBottomCMSStateChanged;
	xmlHttp2.open("GET",url,true);
	xmlHttp2.send(null);
}
function ShowBottomCMSStateChanged() 
{ 
	if (xmlHttp2.readyState==4 || xmlHttp2.readyState=="complete")
	{
		document.getElementById("bottomcmspicgroup").innerHTML=xmlHttp2.responseText;
	}
}

function validateQuickSearch()
{
	var errormsg;
	errormsg = "";
	
	if (document.QuickSearch.txtQuickSearch.value == "" || document.QuickSearch.txtQuickSearch.value == "Enter Keywords Here")
		errormsg += "Please fill in 'Quick Search'.\n";

	if ((errormsg == null) || (errormsg == ""))
	{
		return true;
	}
	else
	{
		alert(errormsg);
		return false;
	}
}

function validateNews() 
{
	var errormsg;
	errormsg = "";
		
	if (document.Newsletters.newsName.value == "" || document.Newsletters.newsName.value == "Name")
		errormsg += "Please fill in 'Name'.\n";
		
	if (document.Newsletters.newsEmail.value == "" || document.Newsletters.newsEmail.value == "Email")
		errormsg += "Please fill in 'Email'.\n";
	else
	{
		if (!isEmail(document.Newsletters.newsEmail.value))
			errormsg += "Please fill in a valid Email address.\n";
	}
	
	if ((errormsg == null) || (errormsg == ""))
	{
		xmlHttp=GetXmlHttpObject();
		if (xmlHttp==null)
		{
			alert ("Your browser does not support AJAX!");
			return;
		}
		var url="mailinglist.php?newsName="+document.Newsletters.newsName.value+"&newsEmail="+document.Newsletters.newsEmail.value+"&sid="+Math.random();

		xmlHttp.onreadystatechange=NewsStateChanged;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
	else
	{
		alert(errormsg);
		return false;
	}
}

function NewsStateChanged() 
{ 
	if (xmlHttp.readyState==4)
	{
		document.getElementById("msg").innerHTML=xmlHttp.responseText;
		document.getElementById("newsName").value="";
		document.getElementById("newsEmail").value="";
	}
}

function NewsTextDisappear(formname, fieldname, fieldvalue)
{
	if (eval("document."+formname+"."+fieldname+".value") == fieldvalue)
	{
		eval("document."+formname+"."+fieldname+".value = ''");
	}
	else if (eval("document."+formname+"."+fieldname+".value") == '')
	{
		eval("document."+formname+"."+fieldname+".value = '"+fieldvalue+"'");
	}
}

/*Password Text Begin*/
function PasswordChangeBox() 
{
  document.getElementById('PasswordDiv1').style.display='none';
  document.getElementById('PasswordDiv2').style.display='';
  document.getElementById('Password').focus();
}
function PasswordRestoreBox() 
{
	if(document.getElementById('Password').value=='')
	{
	  document.getElementById('PasswordDiv1').style.display='';
	  document.getElementById('PasswordDiv2').style.display='none';
	}
}
/*Password Text End*/

function MyPopUpWin(pic, picWidth, picHeight) 
{
	var iMyWidth;
	var iMyHeight;
	if(parseFloat(window.screen.width) > parseFloat(picWidth))
		iMyWidth = (parseFloat(window.screen.width) - parseFloat(picWidth))/2;
	else
		iMyWidth = 0;
	if(parseFloat(window.screen.height) > parseFloat(picHeight))
		iMyHeight = (parseFloat(window.screen.height) - parseFloat(picHeight))/2;
	else
		iMyHeight = 0;
	var win2 = window.open(pic,"Window2","height=" + (parseFloat(picHeight) + 20) + ",width=" + (parseFloat(picWidth) + 10) + ",left=" + iMyWidth + ",top=" + iMyHeight + ",status=no,resizable=no,toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
	win2.focus();
}

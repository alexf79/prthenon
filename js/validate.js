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

function isDate (year, month, day) {
   month = month - 1;
   var tempDate = new Date(year,month,day);
   if ( (tempDate.getFullYear() == year) &&
        (month == tempDate.getMonth()) &&
        (day == tempDate.getDate()) ){
       return true;
   }else{
      return false;
   }
}

function isNotFuture (year,month,day ){
   month = month - 1;
   var today = new Date;
   var tempDate = new Date(year,month,day);
   if ( tempDate < today ){
       return true;
   }else{
      return false;
   }
}

function isValidDate(dateStr, resultDate) {
  var datePat = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{2}|\d{4})$/;
  var matchArray = dateStr.match(datePat);
  if (matchArray == null) {
    alert("Date is not in a valid format.")
    return false;
  }
  
  day = matchArray[1];
  month = matchArray[3];
  year = matchArray[4];
  
  if (day < 1 || day > 31) {
    alert("Day must be between 1 and 31.");
    return false;
  }

  if (month < 1 || month > 12) {
    alert("Month must be between 1 and 12.");
    return false;
  }
  
  if ((month==4 || month==6 || month==9 || month==11) && day==31) {
    alert("Month "+month+" doesn't have 31 days!")
    return false
  }
  if (month == 2) {
    var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
    if (day>29 || (day==29 && !isleap)) {
      alert("February " + year + " doesn't have " + day + " days!");
      return false;
     }
  }
  resultDate.value = month + "/" + day + "/" + year
  return true;
}

function isEmpty(data)
{
  var i;

  for (i=0; i < data.length; i++) {
    if (data.charAt(i) != ' ') {
      return false;
    }
  }
  return true;
}

function isAlphaNumeric(data, specialStr)
{
  var numStr = "0123456789"
  var alphaStr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
  var currChar
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if ((numStr.indexOf(currChar) == -1) &&
        (alphaStr.indexOf(currChar) == -1) && 
        (specialStr.indexOf(currChar) == -1)) {
      return false;
    }
  }
  return true;
}

function isAlphabet(data)
{
  var numStr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
  var currChar
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if (numStr.indexOf(currChar) == -1) {
      return false;
    }
  }
  return true;
}

function isInteger(data)
{
  var numStr = "0123456789"
  var currChar
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if (numStr.indexOf(currChar) == -1) {
      return false;
    }
  }
  return true;
}

function isFloat(data)
{
  var numStr = "0123456789"
  var currChar
  var decpt = 0
  var i

  if (isEmpty(data)) {
    return false;
  }

  for (i=0; i < data.length; i++) {
    currChar = data.charAt(i)
    if (numStr.indexOf(currChar) == -1) {
      if ((currChar == '.' ) && (decpt == 0)) {
        decpt++
      } else {
        return false;
      }
    }
  }
  return true;
}

function isEmail(email)
{
  var posOfAt = email.indexOf("@")
  var lastPosOfAt = email.lastIndexOf("@")
  var lastPosOfDot = email.lastIndexOf(".")
  var currChar

  if (isEmpty(email) || email.length < 5 || posOfAt != lastPosOfAt ||
      (posOfAt < 1) || (email.indexOf(" ") != -1) || 
      (lastPosOfDot <= posOfAt) || (lastPosOfDot == email.length - 1))  {
    return false;
  }
  return true;
}

function isValidNRIC(strData)
{
  var intLen = strData.length
  var intWeights = new Array(2, 7, 6, 5, 4, 3, 2)
  var strChkAlpha = new Array("A", "B", "C", "D", "E", "F", "G", "H", "I", "Z", "J")
	
  var strDigits
  var strValidAlpha
  var strCardType
  var strCardAlpha
  var i
  var strCurrDigit
  var j = 0

  if ((intLen < 8) || (intLen > 9)) {
    return false;
  }
  
  strCardAlpha = strData.charAt(intLen - 1).toUpperCase()
  
  
  strCardType = strData.charAt(0).toUpperCase()
  if ((strCardType != "S") && strCardType != "T") {
    return false;
  }
  
  strDigits = strData.substring(intLen - 8, intLen - 1)
  if (!isInteger(strDigits)) {
    return false;
  }

	for (i=0; i < strDigits.length; i++) {
	  strCurrDigit = parseInt(strDigits.charAt(i))
	  j = j + (strCurrDigit * intWeights[i]) 
	}
	
	if (strCardType == "T") {
		j = j + 4
	}
	
	j = j % 11

	j = 11 - j
	
	if (strCardAlpha == strChkAlpha[j - 1]) {
	   return true;
	} else {
	   return false;
	}	
}

function isValidFIN(strData)
{
  var intLen = strData.length
  var intWeights = new Array(2, 7, 6, 5, 4, 3, 2)
  var strChkAlpha = new Array("K", "L", "M", "N", "P", "Q", "R", "T", "U", "W", "X")
	
  var strDigits
  var strValidAlpha
  var strCardType
  var strCardAlpha
  var i
  var strCurrDigit
  var j = 0

  if ((intLen < 8) || (intLen > 9)) {
    return false;
  }
  
  strCardAlpha = strData.charAt(intLen - 1).toUpperCase()
  
  
  strCardType = strData.charAt(0).toUpperCase()
  if ((strCardType != "F") && strCardType != "G") {
    return false;
  }
  
  strDigits = strData.substring(intLen - 8, intLen - 1)
  if (!isInteger(strDigits)) {
    return false;
  }

	for (i=0; i < strDigits.length; i++) {
	  strCurrDigit = parseInt(strDigits.charAt(i))
	  j = j + (strCurrDigit * intWeights[i]) 
	}
	
	if (strCardType == "G") {
		j = j + 4
	}
	
	j = j % 11

	j = 11 - j
	
	if (strCardAlpha == strChkAlpha[j - 1]) {
	   return true;
	} else {
	   return false;
	}	
}

function Right(String, Length)
{
	if (String == null)
		return (false);

	var dest = '';
	for (var i = (String.length - 1); i >= 0; i--)
		dest = dest + String.charAt(i);

	String = dest;
	String = String.substr(0, Length);
	dest = '';

	for (var i = (String.length - 1); i >= 0; i--)
		dest = dest + String.charAt(i);

	return dest;
}

function ImageExtOk(fieldvalue) 
{
	var extension = new Array();
	extension[0] = ".png";
	extension[1] = ".gif";
	extension[2] = ".jpg";
	extension[3] = ".jpeg";
	var thisext = fieldvalue.substr(fieldvalue.lastIndexOf('.'));
	for(var i = 0; i < extension.length; i++) 
	{
		if(thisext == extension[i]) { return true; }
	}
	return false;
}

function VideoExtOk(fieldvalue) 
{
	var extension = new Array();
	extension[0] = ".mpg";
	extension[1] = ".avi";
	extension[2] = ".wmv";	
	var thisext = fieldvalue.substr(fieldvalue.lastIndexOf('.'));
	for(var i = 0; i < extension.length; i++) 
	{
		if(thisext == extension[i]) { return true; }
	}
	return false;
}

function limitText(limitField, limitCount, limitNum)
{
	if (limitField.value.length > limitNum)
	{
		limitField.value = limitField.value.substring(0, limitNum);
	}
	else
	{
		limitCount.value = limitNum - limitField.value.length;
	}
}

function numbersonly(e){
	var unicode=e.keyCode? e.keyCode : e.charCode
	
	if (unicode!=8)
	{ //if the key isn't the backspace key (which we should allow)
		if (unicode<48||unicode>57) //if not a number
			if(unicode!=43 && unicode!=9)//+ key allow
			{
			return false //disable key press
			}
			
	}
}

function numbersonlyNew(e){
	var unicode=e.keyCode? e.keyCode : e.charCode
	
	if (unicode!=8)
	{ //if the key isn't the backspace key (which we should allow)
		if ((unicode<48||unicode>57) && unicode!=46) //if not a number
			if(unicode!=43 && unicode!=9)//+ key allow
			{
			return false //disable key press
			}
			
	}
}

function currenciesonly(e){
	var unicode=e.keyCode? e.keyCode : e.charCode
	if (unicode!=8)
	{ //if the key isn't the backspace key (which we should allow)
		if (unicode<48||unicode>57) //if not a number
			if(unicode!=46 && unicode!=9)//+ key allow
			{
			return false //disable key press
			}
	}
}

function testKey(e)
{
	chars= "0123456789.";
	e    = window.event;
	if(chars.indexOf(String.fromCharCode(e.keyCode))==-1) 
	window.event.keyCode=0;
}

function testKey2(e)
{
	chars= "0123456789";
	e    = window.event;
	if(chars.indexOf(String.fromCharCode(e.keyCode))==-1) 
	window.event.keyCode=0;
}

function testKey3(e)
{
	chars= "0123456789+ ";
	e    = window.event;
	if(chars.indexOf(String.fromCharCode(e.keyCode))==-1) 
	window.event.keyCode=0;
}

function write_it(status_text)
{
	window.status=status_text;
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

function validateQuickSearch()
{
	var errormsg;
	errormsg = "";
	
	if (document.QuickSearch.txtQuickSearch.value == "")
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

function daysBetween(first, second) {

    // Copy date parts of the timestamps, discarding the time parts.
    var one = new Date(first.getFullYear(), first.getMonth(), first.getDate());
    var two = new Date(second.getFullYear(), second.getMonth(), second.getDate());

    // Do the math.
    var millisecondsPerDay = 1000 * 60 * 60 * 24;
    var millisBetween = two.getTime() - one.getTime();
    var days = millisBetween / millisecondsPerDay;

    // Round down.
    return Math.floor(days);
}


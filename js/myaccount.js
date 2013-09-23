	//Phone Validation
function isPhoneFax(strvalue)
{  
  var str = strvalue;
  var checkOK = "0123456789()+- ";
  var checkStr = str;
  var allValid = true;
  var decPoints = 0;
  var allNum = "";
  for (i = 0;  i < checkStr.length;  i++)
  {
    ch = checkStr.charAt(i);
    for (j = 0;  j < checkOK.length;  j++)
      if (ch == checkOK.charAt(j))
        break;
     if (j == checkOK.length)
     {
       allValid = false;
       break;
     }
    allNum += ch;
  }
  
  if (!allValid)
  { 
    return false;
  }
 return true;
}	
	function validateForm()
	{
		var errormsg;
		errormsg = "";		
  
  	if (document.registration.Salutation.value == "")
			errormsg += "Please select 'Salutation'.\n";
	
		if (document.registration.Surname.value == "")
			errormsg += "Please fill in 'Surname'.\n";
	
		if (document.registration.Fullname.value == "")
			errormsg += "Please fill in 'Given Name'.\n";
					
			
		if (document.registration.Email.value == "")
			errormsg += "Please fill in 'Your Email'.\n";
		else
		{
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			var email = document.registration.Email.value;
			if(reg.test(email) == false) {
				errormsg += "Please fill in valid email address in 'Your Email'.\n";
			}
		}	
		/*
		if (document.registration.Password.value == "")
			errormsg += "Please fill in 'Password'.\n";
				
		if (document.registration.RetypePassword.value == "")
			errormsg += "Please fill in 'Re-enter password'.\n";
			
			
		if (document.registration.Password.value != "" || document.registration.RetypePassword.value != "")
		{
			if (document.registration.Password.value != document.registration.RetypePassword.value)
				errormsg += "Please ensure 'Password' is the same as 'Re-enter password'.\n";
		}
		*/
		if(document.registration.CPhone.value != ""){
				var flag = isPhoneFax(document.registration.CPhone.value);
				if(flag == false){
					errormsg += "Please fill in valid Phone Number in 'Company Phone'.\n";
				}
			}
			if(document.registration.CHandphone.value != ""){
				var flag = isPhoneFax(document.registration.CHandphone.value);
				if(flag == false){
					errormsg += "Please fill in valid Handphone in 'Company Handphone'.\n";
				}
			}
			if(document.registration.CFax.value != ""){
				var flag = isPhoneFax(document.registration.CFax.value);
				if(flag == false){
					errormsg += "Please fill in valid Fax Number in 'Company Fax'.\n";
				}
			}
			if (document.registration.CEmail.value != "")
			{
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				var email1 = document.registration.CEmail.value;
				if(reg.test(email1) == false) {
					errormsg += "Please fill in valid email address in 'Company Email'.\n";
				}
			}
			 if(document.registration.CPostalCode.value != ""){
				var flag = isPhoneFax(document.registration.CPostalCode.value);
				if(flag == false){
					errormsg += "Please fill in valid Postal code Number in 'Company PostalCode'.\n";
				}
			}
			if(document.registration.DPhone.value != ""){
				var flag = isPhoneFax(document.registration.DPhone.value);
				if(flag == false){
					errormsg += "Please fill in valid Phone Number in 'Delivery Phone'.\n";
				}
			}
			if(document.registration.DHandphone.value != ""){
				var flag = isPhoneFax(document.registration.DHandphone.value);
				if(flag == false){
					errormsg += "Please fill in valid Handphone Number in 'Delivery Handphone'.\n";
				}
			}
			if(document.registration.DFax.value != ""){
				var flag = isPhoneFax(document.registration.DFax.value);
				if(flag == false){
					errormsg += "Please fill in valid Fax Number in 'Delivery Fax'.\n";
				}
			}
			if (document.registration.DEmail.value != "")
			{
				var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				var email2 = document.registration.DEmail.value;
				if(reg.test(email2) == false) {
					errormsg += "Please fill in valid email address in 'Delivery Email'.\n";
				}
			} 	
			if(document.registration.DPostalCode.value != ""){
				var flag = isPhoneFax(document.registration.DPostalCode.value);
				if(flag == false){
					errormsg += "Please fill in valid Postal code Number in 'Delivery PostalCode'.\n";
				}
			}
		
		if(document.getElementById('terms').checked == false)
		{
			errormsg += "Please check Terms & Conditions";
		}
		
		if ((errormsg == null) || (errormsg == ""))
		{       
			var xmlhttp1;
			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp1=new XMLHttpRequest();
			}
			else {// code for IE6, IE5
			  xmlhttp1=new ActiveXObject("Microsoft.XMLHTTP");
			}

			xmlhttp1.onreadystatechange=function(){
			  if (xmlhttp1.readyState==4 && xmlhttp1.status==200){
				//document.getElementById("address").value=xmlhttp1.responseText;
				errormsg = xmlhttp1.responseText;
				if (errormsg == "")
				{					
					submitform();   
				}
				else
				{
					alert (errormsg);
				}
			  }
			}
			xmlhttp1.open("GET","getmail.php?q="+document.registration.Email.value,true);
			xmlhttp1.send();
			
			return false;
		}
		else
		{
			alert(errormsg);
			return false;
		}
	}	
		
		function submitform()
		{
		
			document.registration.action = "registrationaction.php";
			document.registration.e_action.value="add";
			document.registration.submit();
		
		}
		
		function filldata()
		{
			if(document.getElementById('checkbox').checked == true)
			{
				document.registration.DPhone.value = document.registration.CPhone.value;
				document.registration.DHandphone.value = document.registration.CHandphone.value;
				document.registration.DFax.value = document.registration.CFax.value;
				document.registration.DEmail.value = document.registration.CEmail.value;
				document.registration.DAddress.value = document.registration.CAddress.value;
				document.registration.DAddress1.value = document.registration.CAddress1.value;
				document.registration.DCountryID.value = document.registration.CCountryID.value;
				document.registration.DPostalCode.value = document.registration.CPostalCode.value;
			}
			else
			{
				document.registration.DPhone.value = '';
				document.registration.DHandphone.value = '';
				document.registration.DFax.value = '';
				document.registration.DEmail.value = '';
				document.registration.DAddress.value = '';
				document.registration.DAddress1.value = '';
				document.registration.DCountryID.value = '';
				document.registration.DPostalCode.value = '';
			}
		}

function make_disabled(element_name)
{
		document.form_update_user_profile.element_name.disabled=true;
		return true;	
}

function edit_companyprofile()
{
		document.getElementById('box_cphone1').style.display="block";
		document.getElementById('box_cphone2').style.display="block";
		document.getElementById('box_chandphone1').style.display="block";
		document.getElementById('box_chandphone2').style.display="block";
		document.getElementById('box_cemail').style.display="block";
		document.getElementById('box_cfax1').style.display="block";
		document.getElementById('box_cfax2').style.display="block";
	  document.getElementById('cphone_span').style.display="block";
	  document.getElementById('chandphone_span').style.display="block";
	  document.getElementById('cfax_span').style.display="block";
		document.getElementById('box_caddress').style.display="block";
		document.getElementById('box_caddress1').style.display="block";
		document.getElementById('box_ccountry').style.display="block";
		document.getElementById('box_cpostalcode').style.display="block";

		document.getElementById('cphone1').style.display="none";
		document.getElementById('cphone2').style.display="none";
		document.getElementById('chandphone1').style.display="none";
		document.getElementById('chandphone2').style.display="none";
		document.getElementById('cemail').style.display="none";
		document.getElementById('cfax1').style.display="none";
		document.getElementById('cfax2').style.display="none";
		document.getElementById('caddress').style.display="none";
		document.getElementById('caddress1').style.display="none";
		document.getElementById('ccountry').style.display="none";
		document.getElementById('cpostalcode').style.display="none";
		document.getElementById('edit_company_profile_btn').style.display="none";
		document.getElementById('save_company_profile_btn').style.display="block";
		
		return true;
}	

function edit_deleveryprofile()
{
		document.getElementById('box_dphone1').style.display="block";
		document.getElementById('box_dphone2').style.display="block";
		document.getElementById('box_dhandphone1').style.display="block";
		document.getElementById('box_dhandphone2').style.display="block";
		document.getElementById('box_demail').style.display="block";
		document.getElementById('box_dfax1').style.display="block";
		document.getElementById('box_dfax2').style.display="block";
		document.getElementById('box_daddress').style.display="block";
		document.getElementById('box_daddress1').style.display="block";
		document.getElementById('box_dcountry').style.display="block";
		document.getElementById('box_dpostalcode').style.display="block";
		document.getElementById('dphone_span').style.display="block";
	  document.getElementById('dhandphone_span').style.display="block";
	  document.getElementById('dfax_span').style.display="block";
		document.getElementById('dphone1').style.display="none";
		document.getElementById('dphone2').style.display="none";
		document.getElementById('dhandphone1').style.display="none";
		document.getElementById('dhandphone2').style.display="none";
		document.getElementById('demail').style.display="none";
		document.getElementById('dfax1').style.display="none";
		document.getElementById('dfax2').style.display="none";
		document.getElementById('daddress').style.display="none";
		document.getElementById('daddress1').style.display="none";
		document.getElementById('dcountry').style.display="none";
		document.getElementById('dpostalcode').style.display="none";

		document.getElementById('edit_delevery_profile_btn').style.display="none";
		document.getElementById('save_delevery_profile_btn').style.display="block";
	
	return true;


}

function edit_userprofile()
{	
		document.getElementById('box_surname').style.display="block";
		document.getElementById('box_fullname').style.display="block";
		document.getElementById('box_email').style.display="block";
		document.getElementById('box_companyname').style.display="block";
		document.getElementById('box_designation').style.display="block";
		document.getElementById('box_industrytype').style.display="block";
		//document.getElementById('box_password').style.display="block";
		
		document.getElementById('surname').style.display="none";
		document.getElementById('fullname').style.display="none";
		document.getElementById('email').style.display="none";
		document.getElementById('companyname').style.display="none";
		document.getElementById('designation').style.display="none";
		document.getElementById('industrytype').style.display="none";
		//document.getElementById('user_password').style.display="none";
		document.getElementById('edit_user_profile_btn').style.display="none";
		document.getElementById('save_user_profile_btn').style.display="block";
		return true;

}
		


		$(document).ready(function(){
						$("#box_industrytype").change(function() {
							  var i_text = $(this).find("option:selected").text();
							  if(i_text != '--select--')
							  {
						     document.getElementById('industrytype').innerHTML = i_text;
						    }else{
						    	document.getElementById('industrytype').innerHTML = '';
						    }
						});
        $("#save_user_profile_btn").click(function() {  
        
		var surname = $('#box_surname').attr('value');  
        var fullname = $('#box_fullname').attr('value');  
        var email = $('#box_email').attr('value');  	
		var company = $('#box_companyname').attr('value');  
        var designation = $('#box_designation').attr('value');  
        
        var industrytype = $('#box_industrytype').attr('value');  
        
        //var industryvalue = $("#box_industrytype  option:selected").text();
       
		//var user_password = $('#box_password').attr('value');  
		
		
		var errormsg= "";
		if(surname == "")
		{ errormsg += "Please fill in 'Surname'\n";}
		
		if(fullname == "")
		{
			errormsg += "Please fill in 'Give Name'\n";
		}

		if(email == "")
		{
			errormsg += "Please fill in 'Email'\n";
		}
		else
		{
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			
			if(reg.test(email) == false) {
				 
				alert("Please fill valid email address in 'Your Email'");
				return false;
			}
		}
		/*if(user_password == "")
		{
			errormsg += "Please fill in 'Email'\n";
		}
		
			
			
			
			
			
			
		
			
			if(errormsg!="") { alert(errormsg);	return false; }
			
		var user_id = $('#user_id').attr('value');  
		var save_user_data="";
		var user_password_astrict="";
		for(var i=0;i<user_password.length;i++)
		{
			user_password_astrict=user_password_astrict + "*";
		}
		
		  data: "surname="+ surname +"&save_user_data="+ save_user_data +"&fullname="+ fullname +"&email="+ email+"&company="+ company+"&designation="+ designation+"& industrytype="+ industrytype+"& user_password="+ user_password+"&user_id=" + user_id,
		*/
		if(errormsg!="") { alert(errormsg);	return false; }
		var user_id = $('#user_id').attr('value'); 
		
		var save_user_data="save";
            $.ajax({  
                type: "POST",  
                url: "update_user_profile.php",  
             data: "surname="+ surname +"&save_user_data="+ save_user_data +"&fullname="+ fullname +"&email="+email+"&company="+ company+"&designation="+ designation+"& industrytype="+ industrytype+"&user_id=" + user_id,
                success: function(data){  
					document.getElementById('box_surname').style.display="none";
					document.getElementById('box_fullname').style.display="none";
					document.getElementById('box_email').style.display="none";
					document.getElementById('box_companyname').style.display="none";
					document.getElementById('box_designation').style.display="none";
					document.getElementById('box_industrytype').style.display="none";
					//document.getElementById('box_password').style.display="none";
		
					document.getElementById('surname').style.display="block";
					document.getElementById('fullname').style.display="block";
					document.getElementById('email').style.display="block";
					
					document.getElementById('companyname').style.display="block";
					document.getElementById('designation').style.display="block";
					document.getElementById('industrytype').style.display="block";
					//document.getElementById('user_password').style.display="block";

					
					
					var alldata = data;
					
					alldata = alldata.split('||');
					data1 = alldata[0];
					data2 = alldata[1];
					if(data1=="User Email Address Already Exist" && data2!=null && (document.getElementById('email').innerHTML!=email))
					{
					
					$('#user_update_msg').html(data1);
					document.getElementById('box_email').value = data2; 
					document.getElementById('box_surname').value=surname;
					document.getElementById('box_fullname').value=fullname;
					document.getElementById('box_companyname').value=company;
					document.getElementById('box_designation').value=designation;
					//document.getElementById('box_password').value=user_password_astrict;
				
					document.getElementById('surname').style.display="none";
					document.getElementById('fullname').style.display="none";
					document.getElementById('email').style.display="none";
					document.getElementById('companyname').style.display="none";
					document.getElementById('designation').style.display="none";
					document.getElementById('industrytype').style.display="none";
					//document.getElementById('user_password').style.display="none";
					
					document.getElementById('box_surname').style.display="block";
					document.getElementById('box_fullname').style.display="block";
					document.getElementById('box_email').style.display="block";
					document.getElementById('box_companyname').style.display="block";
					document.getElementById('box_designation').style.display="block";
					document.getElementById('box_industrytype').style.display="block";
					//document.getElementById('box_password').style.display="block";
					
					document.getElementById('edit_user_profile_btn').style.display="none";
					document.getElementById('save_user_profile_btn').style.display="block";
					
					}
					else
					{ 
					$('#user_update_msg').html('User Profile Updated Successfully');
					document.getElementById('email').innerHTML = data2; 
					document.getElementById('surname').innerHTML=surname;
					document.getElementById('fullname').innerHTML=fullname;
					document.getElementById('companyname').innerHTML=company;
					document.getElementById('designation').innerHTML=designation;
					 
				 // document.getElementById('industrytype').value=industryvalue;
					//document.getElementById('user_password').innerHTML=user_password_astrict;
					document.getElementById('edit_user_profile_btn').style.display="block";
					document.getElementById('save_user_profile_btn').style.display="none";
					}
						 
						// $('#user_update_msg').html('<script>document.getElementById('user_update_msg').style.display="block";</script>');
					
					//$('#user_profile_portion').html(data);
					
                }  
            });  
        return false;  
        }); 
    });  

	
	
$(document).ready(function(){

 $("#save_company_profile_btn").click(function() {          
		var cphone1 = $('#box_cphone1').attr('value');  
			var cphone2 = $('#box_cphone2').attr('value'); 
        	var chandphone1 = $('#box_chandphone1').attr('value');  
			var chandphone2 = $('#box_chandphone2').attr('value'); 
        	var cemail1 = $('#box_cemail').attr('value');  	
		var caddress1 = $('#box_caddress').attr('value');  
        	var caddress11 = $('#box_caddress1').attr('value');  
       	var cfax1 = $('#box_cfax1').attr('value');  
		var cfax2 = $('#box_cfax2').attr('value');  
        	var cpostalcode1= $('#box_cpostalcode').attr('value');  
        	var ccountry1 = $('#box_ccountry').attr('value');  
        	 
		var user_id1 = $('#user_id').attr('value');  
		var save_company_data="";
		
		var errormsg= "";
		
				var flag = isPhoneFax(cphone1);
				if(flag == false){
					errormsg += "Please fill in a valid Country code in 'Company Phone'.\n";
				}		
				var flag = isPhoneFax(cphone2);
				if(flag == false){
					errormsg += "Please fill in valid Phone Number in 'Company Phone'.\n";
				}	
				var flag = isPhoneFax(chandphone1);
				if(flag == false){
					errormsg += "Please fill in a valid Country code in 'Company Handphone'.\n";
				}
				
				var flag = isPhoneFax(chandphone2);
				if(flag == false){
					errormsg += "Please fill in valid Handphone in 'Company Handphone'.\n";
				}
				
				var flag = isPhoneFax(cfax1);
				if(flag == false){
					errormsg += "Please fill in a valid Country code in 'Company Fax'.\n";
				}
				
				var flag = isPhoneFax(cfax2);
				if(flag == false){
					errormsg += "Please fill in valid Fax Number in 'Company Fax'.\n";
				}
				if(cemail1 != '')
				{
					var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
					//var email1 = document.registration.CEmail.value;
					if(reg.test(cemail1) == false) {
						errormsg += "Please fill in valid email address in 'Company Email'.\n";
					}
				}
					var flag = isPhoneFax(cpostalcode1);
				if(flag == false){
					errormsg += "Please fill in valid Postal code Number in 'Company PostalCode'.\n";
				}
			
			if(errormsg!="") { alert(errormsg);	return false; }
		
		
		
		$.ajax({  
                type: "POST",  
                url: "update_user_profile.php", 

                data: "cphone="+cphone1+"#"+cphone2+"&save_company_data="+save_company_data+"&chandphone="+chandphone1+'#'+chandphone2+"&cemail="+cemail1+"&caddress="+caddress1+"&caddress1="+caddress11+"&cfax="+cfax1+'#'+cfax2+"&cpostalcode="+cpostalcode1+"&ccountry="+ccountry1+"&user_id="+user_id1,
                success: function(data){ $('#company_update_msg1').html(data);
		document.getElementById('box_cphone1').style.display="none";
		document.getElementById('box_cphone2').style.display="none";
		document.getElementById('box_chandphone1').style.display="none";
		document.getElementById('box_chandphone2').style.display="none";
		document.getElementById('box_cemail').style.display="none";
		document.getElementById('box_cfax1').style.display="none";
		document.getElementById('box_cfax2').style.display="none";
		document.getElementById('box_caddress').style.display="none";
		document.getElementById('box_caddress1').style.display="none";
		document.getElementById('box_ccountry').style.display="none";
		document.getElementById('box_cpostalcode').style.display="none";
		
		document.getElementById('cphone1').style.display="block";
		document.getElementById('cphone2').style.display="block";
		document.getElementById('chandphone1').style.display="block";
		document.getElementById('chandphone2').style.display="block";
		document.getElementById('cemail').style.display="block";
		document.getElementById('cfax1').style.display="block";
		document.getElementById('cfax2').style.display="block";
		document.getElementById('caddress').style.display="block";
		document.getElementById('caddress1').style.display="block";
		document.getElementById('ccountry').style.display="block";
		document.getElementById('cpostalcode').style.display="block";
		 
		document.getElementById('cphone1').innerHTML = '&nbsp;'+cphone1;
		document.getElementById('cphone2').innerHTML = '&nbsp;'+cphone2;
		if(cphone1 != "" || cphone2 != "")
		{
			 
		}else{
			document.getElementById('cphone_span').style.display="none";
		}
		
		if(chandphone1 != "" || chandphone2 != "")
		{
		 
		}else{
 			document.getElementById('chandphone_span').style.display="none";
		}
		
		if(cfax1 != "" || cfax1 != "")
		{
			 
		}else{
 			document.getElementById('cfax_span').style.display="none";
		}
		
		document.getElementById('chandphone1').innerHTML = '&nbsp;'+chandphone1;
		document.getElementById('chandphone2').innerHTML = '&nbsp;'+chandphone2;
		document.getElementById('cemail').innerHTML = cemail1;
		document.getElementById('cfax1').innerHTML = '&nbsp;'+cfax1;
		document.getElementById('cfax2').innerHTML = '&nbsp;'+cfax2;
		document.getElementById('caddress').innerHTML = caddress1;
		document.getElementById('caddress1').innerHTML = caddress11;
		document.getElementById('cpostalcode').innerHTML = cpostalcode1;
		document.getElementById('edit_company_profile_btn').style.display="block";
		document.getElementById('save_company_profile_btn').style.display="none";
		//document.getElementById('ccountry').innerHTML = ccountry1;		
			countryname(ccountry1);
		//location.reload();
		
		
		
		
		}  
            });  
        return false;  
        });  
});

function countryname(cname)
{	
	var pars;
	var url='countryname.php?';	
	pars =  'cname=' + cname ;	
	//alert(url+pars);
	$.ajax({ url: url+ pars, type: "POST", success: function(msg){		
		//alert(msg);
    document.getElementById('ccountry').innerHTML = msg;
  }});
  
}

function countryname1(cname)
{	
	var pars;
	var url='countryname.php?';	
	pars =  'cname=' + cname ;	
	//alert(url+pars);
	$.ajax({ url: url+ pars, type: "POST", success: function(msg){		
		//alert(msg);
    document.getElementById('dcountry').innerHTML = msg;
  }});
  
}


 $(document).ready(function(){

 $("#save_delevery_profile_btn").click(function() {          
		var dphone1 = $('#box_dphone1').attr('value');  
		var dphone2 = $('#box_dphone2').attr('value');  
        	var dhandphone1 = $('#box_dhandphone1').attr('value'); 
			var dhandphone2 = $('#box_dhandphone2').attr('value'); 
        	var demail1 = $('#box_demail').attr('value');  	
		var daddress1 = $('#box_daddress').attr('value');  
        	var daddress11 = $('#box_daddress1').attr('value');  
       	var dfax1 = $('#box_dfax1').attr('value');  
		var dfax2 = $('#box_dfax2').attr('value'); 
        	var dpostalcode1= $('#box_dpostalcode').attr('value');  
        	var dcountry1 = $('#box_dcountry').attr('value');  
		var user_id1 = $('#user_id').attr('value');  
		var save_delevery_data="";
		
		
		var errormsg= "";
		
				var flag = isPhoneFax(dphone1);
				if(flag == false){
					errormsg += "Please fill in a valid Country code in 'Delivery Address Phone'.\n";
				}
				var flag = isPhoneFax(dphone2);
				if(flag == false){
					errormsg += "Please fill in valid Phone Number in 'Delivery Address Phone'.\n";
				}				
				var flag = isPhoneFax(dhandphone1);
				if(flag == false){
					errormsg += "Please fill in a valid Country code in 'Delivery Address Handphone'.\n";
				}
				
				var flag = isPhoneFax(dhandphone2);
				if(flag == false){
					errormsg += "Please fill in valid Handphone in 'Delivery Address Handphone'.\n";
				}
				
				var flag = isPhoneFax(dfax1);
				if(flag == false){
					errormsg += "Please fill in a valid Country code in 'Delivery Address Fax'.\n";
				}	
				
				var flag = isPhoneFax(dfax2);
				if(flag == false){
					errormsg += "Please fill in valid Fax Number in 'Delivery Address Fax'.\n";
				}
				
				if(demail1 != '')
				{
					var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
					//var email1 = document.registration.CEmail.value;
					if(reg.test(demail1) == false) {
						errormsg += "Please fill in valid email address in 'Delivery Address Email'.\n";
					}
				}
					var flag = isPhoneFax(dpostalcode1);
				if(flag == false){
					errormsg += "Please fill in valid Postal code Number in 'Delivery Address PostalCode'.\n";
				}
			
			if(errormsg!="") { alert(errormsg);	return false; }
		
		$.ajax({  
                type: "POST",  
                url: "update_user_profile.php", 

                data: "dphone="+dphone1+"#"+dphone2+"&save_delevery_data="+save_delevery_data+"&dhandphone="+dhandphone1+'#'+dhandphone2+"&demail="+demail1+"&daddress="+daddress1+"&daddress1="+daddress11+"&dfax="+dfax1+'#'+dfax2+"&dpostalcode="+dpostalcode1+"&dcountry="+dcountry1+"&user_id="+user_id1,
                success: function(data){ $('#delevery_update_msg1').html(data);
				
				

		document.getElementById('box_dphone1').style.display="none";
		document.getElementById('box_dphone2').style.display="none";
		document.getElementById('box_dhandphone1').style.display="none";
		document.getElementById('box_dhandphone2').style.display="none";
		document.getElementById('box_demail').style.display="none";
		document.getElementById('box_dfax1').style.display="none";
		document.getElementById('box_dfax2').style.display="none";
		document.getElementById('box_daddress').style.display="none";
		document.getElementById('box_daddress1').style.display="none";
		document.getElementById('box_dcountry').style.display="none";
		document.getElementById('box_dpostalcode').style.display="none";

		document.getElementById('dphone1').style.display="block";
		document.getElementById('dphone2').style.display="block";
		document.getElementById('dhandphone1').style.display="block";
		document.getElementById('dhandphone2').style.display="block";
		document.getElementById('demail').style.display="block";
		document.getElementById('dfax1').style.display="block";
		document.getElementById('dfax2').style.display="block";
		document.getElementById('daddress').style.display="block";
		document.getElementById('daddress1').style.display="block";
		document.getElementById('dcountry').style.display="block";
		document.getElementById('dpostalcode').style.display="block";
//location.reload();
		document.getElementById('edit_delevery_profile_btn').style.display="block";
		document.getElementById('save_delevery_profile_btn').style.display="none";
		
	  if(dphone1 != "" || dphone2 != "")
		{
			 
		}else{
			document.getElementById('dphone_span').style.display="none";
		}
		
		if(dhandphone1 != "" || dhandphone2 != "")
		{
		 
		}else{
 			document.getElementById('dhandphone_span').style.display="none";
		}
		
		if(dfax1 != "" || dfax2 != "")
		{
			 
		}else{
 			document.getElementById('dfax_span').style.display="none";
		}
		
		document.getElementById('dphone1').innerHTML = '&nbsp;'+dphone1;
		document.getElementById('dphone2').innerHTML = '&nbsp;'+dphone2;
		document.getElementById('dhandphone1').innerHTML = '&nbsp;'+dhandphone1;
		document.getElementById('dhandphone2').innerHTML = '&nbsp;'+dhandphone2;
		document.getElementById('demail').innerHTML = demail1;
		document.getElementById('dfax1').innerHTML = '&nbsp;'+dfax1;
		document.getElementById('dfax2').innerHTML = '&nbsp;'+dfax2;
		document.getElementById('daddress').innerHTML = daddress1;
		document.getElementById('daddress1').innerHTML = daddress11;
		//document.getElementById('dcountry').innerHTML = dcountry;
		document.getElementById('dpostalcode').innerHTML = dpostalcode1;

countryname1(dcountry1);
			}  
            });  
        return false;  
        });  
});	
	
	
	/*$(document).ready(function() {
		//bind tracking to all links with class = trackit
		$("#save_user_profile_btn").click(function(){
		
		var errormsg="";
		var surname=$('#box_surname').attr('value');
		if(surname=="")
		{ errormsg += "Please fill in 'Surname'.\n";}
		var fullname=$('#box_fullname').attr('value');
		if(fullname=="")
		{
		errormsg += "Please fill in 'Give Name'.\n";
		}
		
		var email= $('#box_email').attr('value');
		if(email=="")
		{
		errormsg += "Please fill in 'Email'.\n";
		}
		
		var passwrod=$('#box_password').attr('value');
		if(passwrod=="")
		{
			errormsg += "Please fill in 'Email'.\n";
		}
			
		
			if(errormsg=="")
			{ return true;}
			else { alert(errormsg);	return false; }
			
		
		});
		});*/
	
		
		
		
		
	
	
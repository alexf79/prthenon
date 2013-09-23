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
			  
					if (document.registration.Firstname.value == "")
						errormsg += "Please fill in 'First Name'.\n";
					
					if (document.registration.Lastname.value == "")
						errormsg += "Please fill in 'Last Name'.\n";
				
					if (document.registration.Email.value == "")
						errormsg += "Please fill in 'Email'.\n";
					else
					{
						var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
						var email = document.registration.Email.value;
						if(reg.test(email) == false) {
							errormsg += "Please fill in valid email address in 'Email'.\n";
						}
					}

					
					
					if (document.registration.Phone1.value == "")
						errormsg += "Please fill in 'Phone Number'.\n";
						
					if (document.registration.dPhone1.value == "")
						errormsg += "Please fill in 'Delivery Phone Number'.\n";
					
					if (document.registration.Address.value == "")
						errormsg += "Please fill in 'Address'.\n";
					/*if (document.registration.Password.value == "")
						errormsg += "Please fill in 'Password'.\n";
					
					if (document.registration.RetypePassword.value == "")
						errormsg += "Please fill in 'Re-enter password'.\n";
						*/
					
					if (document.registration.dAddress.value == "")
						errormsg += "Please fill in 'Delivery Address'.\n";
					
					if (document.registration.password.value != "" || document.registration.repassword.value != "")
					{
						if (document.registration.password.value != document.registration.repassword.value)
							errormsg += "Please ensure 'Password' is the same as 'Re-enter password'.\n";
					}
					
					if ((errormsg == null) || (errormsg == ""))
					{       
						document.registration.action = "registrationaction1.php";
						//document.registration.e_action.value="add";
						document.registration.submit();
						
						return true;
					}
					else
					{
						alert(errormsg);
						return false;
					}
				}	
					
					function submitform()
					{
					
						document.registration.action = "registrationaction1.php";
						//document.registration.e_action.value="add";
						document.registration.submit();
					
					}
					
					function resetForm()
					{
						document.registration.reset();
					}
				function sameaddr(frm,field)
				{	
					var chk=field.checked;
					if(chk == true)
					{
						var ph1=frm.Phone1.value;
						
						var mo1=frm.mobile1.value;
						
						var f1=frm.Fax1.value;
						
						var eml=frm.Email.value;
						var ad1=frm.Address.value;
						var ad2=frm.Address1.value;
						var pc1=frm.PostalCode.value;
						var con=frm.CCountryID.selectedIndex;

						frm.dPhone1.value=ph1;
						
						frm.dmobile1.value=mo1;
						
						frm.dFax1.value=f1;
						
						
						frm.dAddress.value=ad1;
						frm.dAddress1.value=ad2;
						frm.dCCountryID.selectedIndex=con;
						frm.dPostalCode.value=pc1;
					}
					else
					{
						/*frm.dPhone1.value="";
						frm.dPhone2.value="";
						frm.dmobile1.value="";
						frm.dmobile2.value="";
						frm.dFax1.value="";
						frm.dFax2.value="";
						frm.dAddress.value="";
						frm.dAddress1.value="";
						frm.dCCountryID.selectedIndex=0;
						frm.dPostalCode.value="";*/
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
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

function paging(intpageno)
		{
			document.getElementById('PageNo').value=intpageno;
			document.pagination.submit();
		}
		
		function checkSelected(msgtype, count)
		{
			for(var i=1 ; i<=count; i++)
			{
				if(eval("document.order." + msgtype + i + ".type") == "checkbox")
				{
					if(eval("document.order." + msgtype + i + ".checked") == true)
					{
						return true;
					}
				}
			}
			return false;
		}
		
		function validateForm()
		{			
			var blank = '';
			var errormsg;
			errormsg = "";
			var flag ="";		
			var num = document.getElementById('hd_num1').value;
			
			for(var z=0; z < num; z++)
			{				
				if(document.getElementById('qty'+z).value == '')
				{
					flag = 1;
					break;
					//alert("1");
				}
				else if(document.getElementById('qty'+z).value == 0){
					flag = 2;
					break;
				}
				else
				{
					flag = "";
					//alert("0");
				}
			}
	  	
	  	if(flag == 1)
	  	{
	  		errormsg += "Please fill in 'Quantity'.\n";
	  	}
	  	if(flag == 2)
	  	{
	  		errormsg += "Please fill in valid 'Quantity'.\n";
	  	}
	  	
	  	if(num > 0)
	  	{
				if ((errormsg == null) || (errormsg == ""))
				{       
					document.order.action = "orderaction.php?eaction=edit";   			   
					document.order.submit();
					return true;
				}
				else
				{
					alert(errormsg);
					return false;
				}
			} else {
				alert("Please select any product.");
				return false;
			}
		}
		
		

		function validateForm1()
		{	
			var errormsg;
			errormsg = "";		
	 		var num = document.getElementById('hd_num1').value;
	 		if(num > 0){
				if ((errormsg == null) || (errormsg == ""))
				{       
					document.order.action = "orderaction.php?eaction=add";   
					document.order.submit();
					return true;
				}
				else
				{
					alert(errormsg);
					return false;
				}
			} else {
				alert("Please select any product.");
				return false;
			}
		}
		
		function validateForm2()
		{
			var blank = '';
			var errormsg;
			errormsg = "";
			var flag ="";		
			var num = document.getElementById('hd_num1').value;
			
			for(var z=0; z < num; z++)
			{				
				if(document.getElementById('qty'+z).value == '')
				{
					flag = 1;
					break;
					//alert("1");
				}
				else if(document.getElementById('qty'+z).value == 0){
					flag = 2;
					break;
				}
				else
				{
					flag = "";
					//alert("0");
				}
			}
	  	
	  	if(flag == 1)
	  	{
	  		errormsg += "Please fill in 'Quantity'.\n";
	  	}
	  	if(flag == 2)
	  	{
	  		errormsg += "Please fill in valid 'Quantity'.\n";
	  	}
	  	
	  	if(num > 0)
	  	{
				if ((errormsg == null) || (errormsg == ""))
				{       
					document.order.action = "ordersummary.php";   			   
					document.order.submit();
					return true;
				}
				else
				{
					alert(errormsg);
					return false;
				}
			} else {
				alert("Please select any product.");
				return false;
			}
		}
		
		function addCommas(nStr)
		{
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}	
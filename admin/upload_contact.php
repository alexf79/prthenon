<?php ini_set('display_errors',1); 
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user']=="")
    {
        echo "<script language='javascript'>window.location='login.php';</script>";
    }
	include('../global.php');	
	include('../include/functions.php');  	 	
	$filename =strtolower(basename($_FILES['file1_1']['name']));
	
	$ext = substr($filename, strrpos($filename, '.') + 1);
	if(($ext == "csv")||($ext == "CSV"))
	{ 
		if($_FILES["file1_1"]["name"] != "")
		{	
			$tmpName = genRandomString().'.csv';
			$path = "upload/$tmpName";
			if(move_uploaded_file($_FILES["file1_1"]["tmp_name"], $path))
			{
			  $fileName = $path;
			}			 
			if($fileName)
			{					
	
				$handle = fopen($fileName,"r");
				$counter = 0;
				$i = 1;
				$rec = 0;	
				$errorROW = "";
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
				{
				
					// SKIPPING FIRST ROW BECAUSE OF COLUMN NAMES
					
 					if($counter == 0){
						$counter++;
						continue;
					}
					
					$UserID= trim($_SESSION['userid']);
					
					$Name = $data[0]; 
					$Company = $data[1];
					$Group = rtrim($data[2]);
					$Tel = $data[3];
					$Mobile = $data[4];
					$Email = $data[5]; 
					$Country = $data[6];
					$Postal =  $data[7];
					$Address =$data[8]; 
					$Etype = $data[9];
					$Esubject = $data[10]; 
					$Comments = $data[11]; 
					$Where = $data[12];
					$Live = $data[13];
					$status	= '1';
					
					/* START CODE FOR SERVER VALIDATION */
					$flagValid = "no";
					
					if($Name == "" || $Mobile == "" || $Email == ""){
						 $flagValid = "no";
					}
					else{
						if($Name != ""){
							if (eregi('^[A-Za-z ]{0,255}$',$Name))
							{
								 $flagValid = "yes";
								//echo $Name;
							}
							else
							{
								$flagValid = "no";
							}
						}
						
						if($Mobile != "" && $flagValid == "yes"){
							if (eregi('^[0-9 ]{0,15}$',$Mobile))
							{
								$flagValid = "yes";
							}
							else
							{
								$flagValid = "no";
								
							}
						}
						
						if($Tel != "" && $flagValid == "yes"){
							if (eregi('^[0-9 ]{0,15}$',$Tel))
							{
								$flagValid = "yes";
							}
							else
							{
								$flagValid = "no";
								
							}
						}
						
						 				
						if($Country != "" && $flagValid == "yes"){
							if (eregi('^[A-Za-z ]{0,255}$',$Country))
							{
								 $flagValid = "yes";
							}
							else
							{
								 $flagValid = "no";
							}
						}
						
 						if($Email != "" && $flagValid == "yes"){
							if (eregi('^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$', $Email))
							{
								  $flagValid = "yes" ;
							}
							else
							{
								 $flagValid = "no";
							}
						}
						 
					}
				 
 					/*					
						NAME,COUNTRY,CITY MA CHAR J ALLOW
						TELEPH MA NUM J ALLOW
						EMAIL VALID					
					*/
					
					/* END CODE FOR SERVER VALIDATION */
					
					if($flagValid == "yes"){
						 
						//Select Email and comper to Csv FIle
						$select="Select _Email from ".$tbname."_contacts where _Email ='".$Email."' AND _UserID='".$UserID."' "; 
						$selectEmail=mysql_query($select);
						$num_rows = mysql_num_rows($selectEmail);
						
					    $sel_group="Select _ID from ".$tbname."_contactgroup where _ContactGroupName  ='".replaceSpecialChar($Group)."'"; 
						$selectGroup=mysql_query($sel_group);
						$group_rows = mysql_num_rows($selectGroup);
						$fetch_group = mysql_fetch_assoc($selectGroup);
						
					    $sel_con="select country_id from ".$tbname."_country where country ='".replaceSpecialChar($Country)."'"; 
						$selectCon=mysql_query($sel_con);
						$con_rows = mysql_num_rows($selectCon);
						$fetch_con = mysql_fetch_assoc($selectCon);
						
						 //print_r($fetch_con);
 
						if($group_rows > 0)
						{
							$GroupId = $fetch_group['_ID'];
						}else{
							$GroupId = 'NULL';
						}
						
						if($con_rows > 0)
						{
							$Country = $fetch_con['country_id'];
						}else{
							$Country = 'NULL';
						}
						
						
						//echo $GroupId;
						if($num_rows > 0)
						{
						    $update="Update ".$tbname."_contacts set _UserID='".replaceSpecialChar($UserID)."', _FullName='" . replaceSpecialChar($Name) . "', _Fax='" . replaceSpecialChar($Mobile ) . "',_Tel='" . replaceSpecialChar($Tel ) . "',_Fax='" . replaceSpecialChar($Mobile) . "', _Country = '" . replaceSpecialChar($Country) . "',_Postcode = '" . replaceSpecialChar($Postal) . "',_LastUpdatedDate= '" . date('Y-m-d'). "',_IPAddress = '" . $_SERVER['REMOTE_ADDRESS']. "',_Address = '" . replaceSpecialChar($Address) . "', _EmailSubject = '" . replaceSpecialChar($Esubject) . "', _Comments = '" . replaceSpecialChar($Comments) . "', _ContactGroupID = '" . replaceSpecialChar($GorupId) . "', _Where = '" . replaceSpecialChar($Where) . "', _EnquiryType= '" . replaceSpecialChar($Etype) . "', _Status = '" . replaceSpecialChar($Live) . "' ";
							
							$update.=" where _Email = '".$Email."' AND _UserID='".$UserID."'"; 
							mysql_query($update) or die(mysql_error());
							
						}
						else
						{
							
						 $qry = "INSERT INTO ".$tbname."_contacts (_ContactGroupID,_FullName, _CompanyName, _Tel, _Fax, _Email, _Status, _UserID, _UpdatedDate, _LastUpdatedByID,  _LastUpdatedDate, _IPAddress, _Country,_Postcode, _Address, _EnquiryType,  _EmailSubject,  _Comments, _Where) VALUES('".$GroupId."','".$Name."', '".$Company."','".$Tel."','".$Mobile."','".$Email."','".$Live."','".$UserID."','".date('Y-m-d')."','".$UserID."','".date('Y-m-d')."','".$_SERVER['REMOTE_ADDRESS']."','".$Country."','".$Postal."','".$Address."', '".$Etype."', '".$Esubject."', '".$Comments."', '".$Where."')";
						
						mysql_query($qry) or die(mysql_error());
						}
					}
					else{
						 $errorROW .= $i.",";
					}
					$i++;
				}				
				fclose($handle); 		
			}	
			else
			{
 				$rec = 2;		  
 			}
		}		
	}  
	else
	{
		$rec = 4;
	}
  sleep(1);
  $errorROW = substr($errorROW,0,strlen($errorROW)-1);
  header("Location:contacts.php?rec=".$rec."&error=".$errorROW); 
 ?>
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
	$emailString = "";
	$table = 'kbo_pr';
  $file = 'contact';
	$cntCheck = $_POST["cntCheck"];
	$id_string='';
  for ($j=1; $j<=$cntCheck; $j++)
		{
			if ($_POST["CustCheckbox".$j] != "")
			{
			$emailString = $emailString . "con._ID = '" . $_POST["CustCheckbox".$j] . "' OR ";
				if($j==1)
				{
					$id_string.="'".$_POST["CustCheckbox".$j]."'";
				}else{
					$id_string.=",'".$_POST["CustCheckbox".$j]."'";
				}
			}
		}
    $emailString = substr($emailString, 0, strlen($emailString)-4);
     
     $str2 = "SELECT con._ID AS  NO, 
       con._FullName AS ContactName,
       con._CompanyName AS CompanyName,
	   con._ContactGroupID AS Groupname,
	   con._Tel AS Telephone,
	   con._Fax AS Mobile,
       con._Email AS Email,
	   con._Country AS Country,
	   con._Postcode AS Postcode,
	   con._Address AS Address,
	   con._EnquiryType AS EnquiryType,
	   con._EmailSubject AS EmailSubject,
	   con._Comments AS EmailComments,
       con._UpdatedDate AS UpdatedDate,
       con._Status AS Status FROM ".$tbname."_contacts con INNER JOIN ".$tbname."_contactgroup gp  ON  con._ContactGroupID = gp._ID  where (" . $emailString . ")";     
				
		
				$strr = mysql_query($str2);
				$num_fields = mysql_num_fields($strr);
						
                for ($i=0; $i < $num_fields; $i++)                
               	{
               		$csv_output.= "\"" . mysql_field_name($strr, $i)."\"".",";
               	}
               	
                $csv_output .= "\n";
     
	
           

       $str3 = "SELECT con._ID AS  NO, 
       con._FullName AS ContactName,
       con._CompanyName AS CompanyName,
	   gp._ContactGroupName AS Groupname,
	   con._Tel AS Telephone,
	   con._Fax AS Mobile,
       con._Email AS Email,
	   cun.country AS Country,
	   con._Postcode AS Postcode,
	   con._Address AS Address,
	   con._EnquiryType AS EnquiryType,
	   con._EmailSubject AS EmailSubject,
	   con._Comments AS EmailComments,
       con._UpdatedDate AS UpdatedDate,
       con._Status AS Status FROM ".$tbname."_contacts con LEFT JOIN ".$tbname."_contactgroup gp  ON  con._ContactGroupID = gp._ID LEFT JOIN ".$tbname."_country  cun  ON  con._Country = cun.country_id  where  con._ID IN (".$id_string.")";     
                $strrr = mysql_query($str3); 
            //echo  mysql_num_rows($strrr);			   
               $oldID=0;
			   $n=0;
                 while ($rowr = mysql_fetch_array($strrr)) {                
  
									      /*$blnAdd=false;
									      if($oldID!=$rowr['_ID'])
									      {
									      	$oldID=$rowr['_ID'];
									      	$blnAdd=true;
									      }*/
					$n++;				                 	
                 for ($j=0;$j < $num_fields;$j++) {
                 				
                 				/*$strInserValue=$rowr[$j];
                 				
                 				if($blnAdd==false && $j<=15)
                 				{
                 					$strInserValue="";
                 				}
                        $csv_output .="\"" . $strInserValue."\"" .",";*/
						 if($j == 0)
						 {
						 $csv_output .="\"" . $n."\"" .",";
						 }else{
                         $csv_output .="\"" . $rowr[$j]."\"" .",";
						 }
                        
                      
                         }
						 //$csv_output = trim($csv_output ,"");
                       $csv_output .= "\n";
					   
                   }
                       
				 
       
				 
			$filename = $file."_".date("Y-m-d_H-i",time());
                header("Content-type: application/vnd.ms-excel");
                header("Content-disposition: csv" . date("Y-m-d") . ".csv");
                  header( "Content-disposition: filename=".$filename.".csv");
               print $csv_output;
                  exit;
			
             
				  
?>
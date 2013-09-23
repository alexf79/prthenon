<?php
	function GetCMSFirstID($PID, $connect, $tbname, $LinkURL)
	{
		$str = "SELECT _Level, _PageTitle FROM ".$tbname."_cms_category WHERE _ID = '".$PID."' AND _CategoryDeleted IS NULL ";
		$rst = mysql_query($str, $connect) or die(mysql_error());
		if(mysql_num_rows($rst) > 0)
		{
			$rs = mysql_fetch_assoc($rst);
			$Level = $rs['_Level'];
			$PageTitle = $rs['_PageTitle'];
		}
	
		$tempID = trim($PID);
		for ($i = 1; $i<$Level; $i++)
		{
			$str = "SELECT * FROM ".$tbname."_cms_category WHERE _ID = '".$tempID."' AND _CategoryDeleted IS NULL ";
			$rst = mysql_query($str, $connect) or die(mysql_error());
			if(mysql_num_rows($rst) > 0)
			{
				$rs = mysql_fetch_assoc($rst);
				$tempID = $rs['_PID'];
			}
		}
		
		return $tempID;
	}
	function genRandomString() {
		$length = 10;
		$characters = �0123456789abcdefghijklmnopqrstuvwxyz�;
		$string = '';    

		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}

		return $string;
	}
	function getmicrotime()
	{
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}
	
	function generateNumStr($length)
	{
		$random_str = "";
		for ($i = 0; $i < $length; $i++)
		{ 
			srand( (double)microtime() * 1000000 );
			$random_chr = floor(rand(48, 57));
			$random_str .= chr($random_chr);
		} 
		$random_str = htmlentities($random_str);
		return ($random_str);
	}
	
	function generateCode($characters) {
		$possible = '23456789bcdfghjkmnpqrstvwxyz'; 
		$code = '';
		$i = 0;
		while ($i < $characters) { 
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}		
	//
	function generaterand ($gSize=24)
	{
		mt_srand ((double) microtime() * 1000000);
		for ($i=1; $i<=$gSize; $i++)
		{
			$gRandom = mt_rand(1,30);
			if ($gRandom <= 10)
			{
				$capsString .= chr(mt_rand(65,90));
			}
			elseif ($gRandom <= 20)
			{
				$capsString .= mt_rand(0,9);
			}
			else 
			{
				$capsString .= chr(mt_rand(97,122));
			}
		}		
		return $capsString;
	}
	//
	function getLastDayOfMonth($month, $year)
	{
		return idate('d', mktime(0, 0, 0, ($month + 1), 0, $year));
	}
	//
	function replaceSpecialChar($specialString)
	{
		if($specialString != "")
		{
			$special_str = $specialString;
			$special_str = trim($special_str);
			$special_str = str_replace("\'", '&#39;', $special_str);
			$special_str = str_replace('\"', '&quot;', $special_str);
			$special_str = str_replace("\\\\", '&#92;', $special_str);
			$special_str = str_replace("'", '&#39;', $special_str);
			$special_str = str_replace('"', '&quot;', $special_str);
		}
		else
		{
			$special_str = "";
		}
		return ($special_str);
	}
	//
	function replaceSpecialCharBack($specialString)
	{
		if($specialString != "")
		{
			$special_str = $specialString;
			$special_str = trim($special_str);
			$special_str = str_replace('&#92;', "\\\\", $special_str);
			$special_str = str_replace('&#39;', "'", $special_str);
			$special_str = str_replace('&quot;', '"', $special_str);
		}
		else
		{
			$special_str = "";
		}
		return ($special_str);
	}
	//
	function FormatDBColumnName($str)
	{
		if($str == "" || is_null($str))
		{
			$temp = "";
		}
		else
		{
			$str = str_replace('_', '', $str);
			$str = str_replace('OldNew', 'Status', $str);
			$temp = array();
			for ($i=0; $i<strlen($str); $i++)
			{
				if(ctype_lower($str[$i-1]) && ctype_upper($str[$i]))
					$temp[$i] = ' '.$str[$i];
				else
					$temp[$i] = $str[$i];
			}
			$temp = implode('', $temp);
			$temp = str_replace(' ', '&nbsp;', $temp);
		}
		return $temp;
	}
	//
	function FormatDigitString($strText, $strLength)
	{
		if(trim($strText) != "")
		{
			$strText = trim($strText);
			$zeroStr = "";
			for($i=1;$i<=(int)$strLength-strlen($strText);$i++)
			{
				$zeroStr = $zeroStr . "0";
			}
			$special_str = $zeroStr . $strText;
		}
		else
		{
			$special_str = "";
		}
		return ($special_str);
	}
	//
	function ExtractInitialLetters($strText, $caseOption)
	{
		if(trim($strText) != "")
		{
			$ConCatStr = "";
			$elements = explode(" ", $strText);
			for ($i = 0; $i < count($elements); $i++)
			{
				if(trim($elements[$i]) != "")
				{
					$ConCatStr = $ConCatStr . substr(trim($elements[$i]), 0, 1);
				}
			}
			if($caseOption == 1)
				$special_str = strtoupper($ConCatStr);
			elseif($caseOption == 2)
				$special_str = strtolower($ConCatStr);
			elseif($caseOption == 3)
				$special_str = $ConCatStr;
		}
		else
		{
			$special_str = "";
		}
		return ($special_str);
	}
	//
	function DateAdd($interval, $number, $date)
	{
		$date_time_array = getdate($date);
		$hours = $date_time_array["hours"];
		$minutes = $date_time_array["minutes"];
		$seconds = $date_time_array["seconds"];
		$month = $date_time_array["mon"];
		$day = $date_time_array["mday"];
		$year = $date_time_array["year"];
		
		switch ($interval) 
		{
			case "yyyy":
				$year+=$number;
				break;
			case "q":
				$year+=($number*3);
				break;
			case "m":
				$month+=$number;
				break;
			case "y":
			case "d":
				$day+=$number;
				break;
			case "w":
				$day+=$number;
				break;
			case "ww":
				$day+=($number*7);
				break;
			case "h":
				$hours+=$number;
				break;
			case "n":
				$minutes+=$number;
				break;
			case "s":
				$seconds+=$number; 
				break;            
		}
	   	$timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);
		return $timestamp;
	}
	//
	function encode($strcode)
	{
		if (!$strcode && $strcode != "0")
		{
			return false;
			exit;
		}

		$kr = keyresult("30djsk");
		$strenc = "";
		
    	for ($i=0; $i<strlen($strcode); $i++) 
		{
			$n = ord(substr($strcode, $i, 1));
			$n = $n + $kr[1];
			$n = $n + $kr[2];
			(double)microtime()*1000000;
			$nstr = chr(rand(65, 90));
			$strenc .= "$nstr$n";
		}

		return $strenc;
	}
	//
	function decode($strcode)
	{
		if (!$strcode && $strcode != "0")
		{
			return false;
			exit;
		}

		$kr = keyresult("30djsk");
		$strenc = "";
		$strtemp = "";

		for ($i=0; $i<strlen($strcode); $i++) 
		{
			if ( ord(substr($strcode, $i, 1)) > 64 && ord(substr($strcode, $i, 1)) < 91 ) 
			{
				if ($strtemp != "") 
				{
					$strtemp = $strtemp - $kr[2];
					$strtemp = $strtemp - $kr[1];
					$strenc .= chr($strtemp);
					$strtemp = "";
				}
			} 
			else 
			{
				$strtemp .= substr($strcode, $i, 1);
			}
		}

		$strtemp = $strtemp - $kr[2];
		$strtemp = $strtemp - $kr[1];
		$strenc .= chr($strtemp);

		return $strenc;
	}
	//
	function keyresult($key)
	{
		$keyresult = "";
		$keyresult[1] = "0";
		$keyresult[2] = "0";
		for ($i=1; $i<strlen($key); $i++) 
		{
			$strchar = ord(substr($key, $i, 1));
			$keyresult[1] = $keyresult[1] + $strchar;
			$keyresult[2] = strlen($key);
		}
		return $keyresult;
	}
	//
	function encrypt($string, $key) 
	{ 
		$result = ''; 
		for($i=0; $i<strlen($string); $i++) { 
		$char = substr($string, $i, 1); 
		$keychar = substr($key, ($i % strlen($key))-1, 1); 
		$char = chr(ord($char)+ord($keychar)); 
		$result.=$char; 
		} 

		return base64_encode($result); 
	} 
	//
	function decrypt($string, $key) 
	{ 
		$result = ''; 
		$string = base64_decode($string); 
		
		for($i=0; $i<strlen($string); $i++) { 
		$char = substr($string, $i, 1); 
		$keychar = substr($key, ($i % strlen($key))-1, 1); 
		$char = chr(ord($char)-ord($keychar)); 
		$result.=$char; 
		} 
	
		return $result; 
	}
	//
	function truncateString($str, $maxChars=40, $holder="...") {
	// check string length
	// truncate if necessary
		if (strlen($str) > $maxChars) {
		return trim(substr($str, 0, $maxChars)) . $holder;
		} else {
		return $str;
		}
	}
	
	function getWeekRange(&$start_date, &$end_date, $offset=0)
	{ 
        $start_date = ''; 
        $end_date = '';    
        $week = date('W'); 
        $week = $week - $offset; 
        $date = date('Y-m-d'); 
        
        $i = 0; 
        while(date('W', strtotime("-$i day")) >= $week) 
		{                        
            if($week == 1)
			{
				if(date('W', strtotime("-$i day")) == 53)       
					$week = 54;
			}
			$start_date = date('Y-m-d', strtotime("-$i day")); 
            $i++;        
        }    
            
        list($yr, $mo, $da) = explode('-', $start_date);    
        $end_date = date('Y-m-d', mktime(0, 0, 0, $mo, $da + 6, $yr)); 
	} 
    
    function getMonthRange(&$start_date, &$end_date, $offset=0) 
	{ 
        $start_date = ''; 
        $end_date = '';    
        $date = date('Y-m-d'); 
        
        list($yr, $mo, $da) = explode('-', $date); 
        $start_date = date('Y-m-d', mktime(0, 0, 0, $mo - $offset, 1, $yr)); 
        
        $i = 2; 
        
        list($yr, $mo, $da) = explode('-', $start_date); 
        
        while(date('d', mktime(0, 0, 0, $mo, $i, $yr)) > 1) 
		{ 
            $end_date = date('Y-m-d', mktime(0, 0, 0, $mo, $i, $yr)); 
            $i++; 
        } 
	}
	
	function getNumberSplit($num, &$whole, &$decimal)
	{ 
        $numRound = round($num,1);
		$numSplit = explode(".", $numRound);
		$numSplit1 = $numSplit[0];
		$numSplit2 = $numSplit[1];
		
		if($numSplit1 == "")
		{
			$numSplit1 = 0;
		}
		
		if($numSplit2 == "")
		{
			$numSplit2 = 0;
		}
		else
		{
			if($numSplit2 < 3)
			{
				$numSplit2 = 0;
			}
			elseif($numSplit2 >= 3 && $numSplit2 < 7)
			{
				$numSplit2 = 5;
			}
			elseif($numSplit2 >= 7)
			{
				$numSplit1 +=1;
				$numSplit2 = 0;
			}
		}
		$whole = $numSplit1;
		$decimal = $numSplit2;
	}
	
	function UserDataProfile($uid)
	{ 
	//				$sql1 = "SELECT _ID,_Fullname,_Surname ,_Username,_Password,_Email,_CompanyName,_Designation,_Industrytype FROM owl_member where _ID ='".$uid."'";	
					$sql1 = "SELECT * FROM owl_member where _ID ='".replaceSpecialChar($uid)."'";	
					$rst1 = mysql_query($sql1) or die(mysql_error());
					$row=mysql_fetch_array($rst1);
					return $row;
	}
	function get_country($cid)
	{		
		if(empty($cid))
		{ 
			$sql_country1 = "SELECT * FROM owl_country";
		}
		else
		{
			$sql_country1 = "SELECT * FROM owl_country WHERE country_id='".replaceSpecialChar($cid)."'"; 
		}		
		$res_country1 = mysql_query($sql_country1) or die(mysql_error());
		$row_country=mysql_fetch_array($res_country1);		
		return $row_country['country'];
	}
	
	function get_mail($uid)
	{
		$sql_mailid="SELECT * FROM 	owl_member where _ID='".replaceSpecialChar($uid)."'";
		$res_mailid=mysql_query($sql_mailid);
		$mail=mysql_fetch_array($res_mailid);
		return $mail['_Email'];
		
	}
	function curPageName() {
 		return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	}
?>
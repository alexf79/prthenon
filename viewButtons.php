<?php

$catCnt = 4;

for($i = 1; $i <= $catCnt; $i++)
{
    $r_sql = "SELECT 
			  pn_userrates._ID as rateID, pn_userrates._Prodid as prodID, pn_userrates._Uid as userID,
			  pn_product._Catid as catID, 
			  pn_category._Name as catName
			  FROM pn_userrates, pn_product, pn_category
			  WHERE 
			  	pn_userrates._Uid = '".$_SESSION['userid']."' AND
				pn_userrates._Prodid = pn_product._ID AND
			  	pn_category._ID = '".$i."' AND
				pn_product._Catid = pn_category._ID
			  ORDER BY pn_category._Name ASC";
    $r_qry = mysql_query($r_sql, $connect)or die(mysql_error());	
    $num_rate = mysql_num_rows($r_qry);
    if($num_rate > 0){ $rates = $num_rate; }else{ $rates = 0; }
	

    $c_sql = "SELECT 
			  pn_comment._ID as commID, pn_comment._PID as prodID, pn_comment._UID as userID, pn_comment._CID as catID, 
			  pn_category._Name as catName
			  FROM pn_comment, pn_category
			  WHERE 
			  	pn_comment._UID = '".$_SESSION['userid']."' AND
			  	pn_category._ID = '".$i."' AND
				pn_comment._CID = pn_category._ID
			  ORDER BY pn_category._Name ASC";
    $c_qry = mysql_query($c_sql, $connect)or die(mysql_error());	
    $num_comm = mysql_num_rows($c_qry);    
    if($num_comm > 0){ $comms = $num_comm; }else{ $comms = 0; }
		
	$reviews = $rates + $comms;
	
	while($rate_res = mysql_fetch_assoc($r_qry))
	{
		$cat = $rate_res['catName'];
		if($reviews > 0)
		{
			echo '<div class="view-button"><a href="rating.php?catall=all&CID='.encrypt($rate_res['catID'],$Encrypt).'&myratings='.encrypt('yes',$Encrypt).'">View '.$reviews.' '.substr($cat, 0, -1).' Ratings</a></div><br>';
		}
		else
		{
			//do nothing. no need to print a button that goes nowhere..
		}
		unset($reviews);
	}


}
	

?>
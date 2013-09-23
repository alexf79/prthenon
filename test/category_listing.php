<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}

include('global.php');
include('include/functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<?php
	include('topscript.php');
?>
</head>

<body>
  <?php
  	include('header.php');
  ?>
	<br />
    <?php
	$sel_cat="select * from ".$tbname."_category ";
	$qr_cat=mysql_query($sel_cat);
	while($rs_cat=mysql_fetch_array($qr_cat))
	{
	?>
	<div class="cat-list"><h3>YOUR TOP TEN IN <?php echo  strtoupper($rs_cat['_Name']); ?></h3>
		<div class="cat-sublist">
			<ul>
            <?php
				
				$catarray=array();
				//fetch user
				$sel_other_user="select ur._Uid as _Uid,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID !='".$_SESSION['userid']."' group by _Uid ";
				$qr_other_user=mysql_query($sel_other_user);
				while($rs_other_user=mysql_fetch_array($qr_other_user))
				{
					
					$totalrate="";
					$no=0;
					$avgrate="";
				//fetch rate of selected user
				
				$sel_mv="select ur.*,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and ur._Uid ='".$rs_other_user['_Uid']."' ";
				$qr_mv=mysql_query($sel_mv);
				while($rs_users=mysql_fetch_array($qr_mv))
				{
					$no++;
					$user_rate=$rs_users['_Rate'];
					
					$sel_mrate="select ur.*,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['userid']."' AND p._ID='".$rs_users['_Prodid']."' ";
					$qr_mrate=mysql_query($sel_mrate);
					
					if(mysql_num_rows($qr_mrate) > 0)
					{
										
						$rs_my_rate=mysql_fetch_array($qr_mrate);
						$my_rate=$rs_my_rate['_Rate'];
						if($my_rate > 0.00 && $my_rate < 2.00)
						{
							$my_grad="F";
							$my_grad_value=5;
						}
						if($my_rate >= 2.00 && $my_rate < 4.00)
						{
							$my_grad="D";
							$my_grad_value=4;
						}
						if($my_rate >= 4.00 && $my_rate < 6.00)
						{
							$my_grad="C";
							$my_grad_value=3;
						}
						if($my_rate >= 6.00 && $my_rate < 8.00)
						{
							$my_grad="B";
							$my_grad_value=2;
						}
						if($my_rate >= 8.00 && $my_rate <= 10.00)
						{
							$my_grad="A";
							$my_grad_value=1;
						}
						
					}
					else
					{
						$my_grad="F";
						$my_grad_value=5;
					}
					
					/*other rate*/
					if($user_rate > 0.00 && $user_rate < 2.00)
					{
						$user_grad="F";
						$user_grad_value=5;
					}
					if($user_rate >= 2.00 && $user_rate < 4.00)
					{
						$user_grad="D";
						$user_grad_value=4;
					}
					if($user_rate >= 4.00 && $user_rate < 6.00)
					{
						$user_grad="C";
						$user_grad_value=3;
					}
					if($user_rate >= 6.00 && $user_rate < 8.00)
					{
						$user_grad="B";
						$user_grad_value=2;
					}
					if($user_rate >= 8.00 && $user_rate <= 10.00)
					{
						$user_grad="A";
						$user_grad_value=1;
					}
					
					
					$user_diff=abs($my_grad_value-$user_grad_value);
					$Z=($user_diff * 0.25);
					
					$formula = ((10 - ($diff + ($diff * $Z)))/10)*100;
					$totalrate =$totalrate + $formula;
					}
					if($no !=0)
					{
						
					$avgrate=$totalrate/$no;
					}
				
					$catarray[$rs_other_user['_Uid']]=ceil($avgrate);
					
					
					
			}
			
			arsort($catarray);
			$final_arr=array_slice( $catarray, 0, 10, TRUE );
			$final_key = array_keys($final_arr);
			$user_array=implode(",",$final_key);
			if($user_array)
			{
			$sel_other_user="select ur._Uid as _Uid,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID !='".$_SESSION['userid']."' group by _Uid order by FIELD(ur._Uid, ".$user_array.") ";
				$qr_other_user=mysql_query($sel_other_user);
				while($rs_other_user=mysql_fetch_array($qr_other_user))
				{
					$str_other_user_p="select * from ".$tbname."_userrates as ur left join ".$tbname."_member as m on m._ID=_Uid join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' AND ur._Uid ='".$_SESSION['userid']."' ";
					$qr_other_user_p=mysql_query($str_other_user_p);
					
					$count_common_prod=mysql_num_rows($qr_other_user_p);
					
					if($rs_cat['_ID']==1)
					{
						$common_cat=10;
					}
					if($rs_cat['_ID']==2)
					{
						$common_cat=10;
					}
					if($rs_cat['_ID']==3)
					{
						$common_cat=10;
					}
					if($rs_cat['_ID']==4)
					{
						$common_cat=10;
					}
					
					if($count_common_prod >= $common_cat)
					{
					
					$totalrate="";
					$no=0;
					$avgrate="";
				
				$sel_mv="select ur.*,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and ur._Uid ='".$rs_other_user['_Uid']."' and ur._Prodid in (select ur._Prodid from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['userid']."' group by ur._Prodid) ";
				$qr_mv=mysql_query($sel_mv);
				while($rs_users=mysql_fetch_array($qr_mv))
				{
					$no++;
					$user_rate=$rs_users['_Rate'];
					
					$sel_mrate="select ur.*,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['userid']."' AND p._ID='".$rs_users['_Prodid']."' ";
					$qr_mrate=mysql_query($sel_mrate);
					
					if(mysql_num_rows($qr_mrate) > 0)
					{
										
						$rs_my_rate=mysql_fetch_array($qr_mrate);
						$my_rate=$rs_my_rate['_Rate'];
						if($my_rate > 0.00 && $my_rate < 2.00)
						{
							$my_grad="F";
							$my_grad_value=5;
						}
						if($my_rate >= 2.00 && $my_rate < 4.00)
						{
							$my_grad="D";
							$my_grad_value=4;
						}
						if($my_rate >= 4.00 && $my_rate < 6.00)
						{
							$my_grad="C";
							$my_grad_value=3;
						}
						if($my_rate >= 6.00 && $my_rate < 8.00)
						{
							$my_grad="B";
							$my_grad_value=2;
						}
						if($my_rate >= 8.00 && $my_rate <= 10.00)
						{
							$my_grad="A";
							$my_grad_value=1;
						}
						
					}
					else
					{
						$my_grad="F";
						$my_grad_value=5;
					}
					
					/*other rate*/
					if($user_rate > 0.00 && $user_rate < 2.00)
					{
						$user_grad="F";
						$user_grad_value=5;
					}
					if($user_rate >= 2.00 && $user_rate < 4.00)
					{
						$user_grad="D";
						$user_grad_value=4;
					}
					if($user_rate >= 4.00 && $user_rate < 6.00)
					{
						$user_grad="C";
						$user_grad_value=3;
					}
					if($user_rate >= 6.00 && $user_rate < 8.00)
					{
						$user_grad="B";
						$user_grad_value=2;
					}
					if($user_rate >= 8.00 && $user_rate <= 10.00)
					{
						$user_grad="A";
						$user_grad_value=1;
					}
					
					
					$diff=abs($my_rate-$user_rate);
					$user_diff=abs($my_grad_value-$user_grad_value);
					$Z=($user_diff * 0.25);
					
					$formula = ((10 - ($diff + ($diff * $Z)))/10)*100;
					$totalrate =$totalrate + $formula;
					}
					if($totalrate > 0)
					{
					$avgrate=$totalrate/$no;
					}
					
				?>
            	<li><a href="rate_percentile.php?UID=<?php echo encrypt($rs_other_user['_Uid'],$Encrypt); ?>&CatID=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>"><?php echo $rs_other_user['username']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="browsepost.php?UID=<?php echo encrypt($rs_other_user['_Uid'],$Encrypt); ?>&CatID=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>">(Browse Post)</a> <span>
				<?php
					if($avgrate < 0)
					{
						echo "0"."%";
					}
					else
					{
						echo ceil($avgrate)."%";
					}
					
				?></span></li>
            	<?php
					}
			}
			}
			?>           
			</ul>
            <div><a class="viewall" href="rate_detail.php?CatId=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>">Click here to view all</a></div>		
		</div>	
	</div>
    <?php
		if($rs_cat['_ID']==2)
		{
			echo '<div class="clr"></div>';
		}
	}
	?>
	
	<div class="clr"></div>

<?php
	include('footer.php');
?>


</body>
</html>

<?php
	session_start();
	if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
	{
		echo "<script language='javascript'>window.location='index.php';</script>";
	}
	
	include('global.php');
	include('include/functions.php');
	
	$CatId=decrypt($_REQUEST['CatId'],$Encrypt);
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
  <div style="min-height:400px; margin-top:60px;">
	
		<?php
	$sel_cat="select * from ".$tbname."_category where _ID='".$CatId."' ";
	$qr_cat=mysql_query($sel_cat);
	while($rs_cat=mysql_fetch_array($qr_cat))
	{
	?>
	<div class="cat-list"><h3>Your Full Rankings in <?php echo  strtoupper($rs_cat['_Name']); ?></h3>
		<div class="cat-sublist">
			<ul>
            <?php
				
				$catarray=array();
				$data = array();
				
				$sel_other_user="select ur._Uid as _Uid,m._Username as username,m._Fname as _Fname,m._Lname as _Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID !='".$_SESSION['userid']."' group by _Uid ";
				$qr_other_user=mysql_query($sel_other_user);
				$inx = 0;
				while($rs_other_user=mysql_fetch_array($qr_other_user))
				{
					$str_other_user_p="select * from ".$tbname."_userrates as ur left join ".$tbname."_member as m on m._ID=_Uid join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' AND ur._Uid ='".$_SESSION['userid']."' AND ur._Prodid in(select ur._Prodid from ".$tbname."_userrates as ur left join ".$tbname."_member as m on m._ID=_Uid join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' AND ur._Uid ='".$rs_other_user['_Uid']."') ";
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
				
						$sel_mv="select ur.*,m._Username as username,m._Fname as _Fname,m._Lname as _Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and ur._Uid ='".$rs_other_user['_Uid']."' and ur._Prodid in (select ur._Prodid from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['userid']."' group by ur._Prodid) ";
						$qr_mv=mysql_query($sel_mv);
						
						while($rs_users=mysql_fetch_array($qr_mv))
						{
							$no++;
							$user_rate=$rs_users['_Rate'];
							
							$sel_mrate="select ur.*,m._Username as username,m._Fname as _Fname,m._Lname as _Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['userid']."' AND p._ID='".$rs_users['_Prodid']."' order by ur._Rate DESC ";
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
						
						$avgrate=$totalrate/$no;
						$catarray[] = ceil($avgrate);
						$data[$inx]["rate"] = ceil($avgrate);
						$data[$inx]["_Uid"] = $rs_other_user['_Uid'];
						$data[$inx]["_name"] = $rs_other_user['_Fname']." ".$rs_other_user['_Lname'];
						$inx++;
					}
				}
			array_multisort($catarray,SORT_DESC, $data);
			$inx = 0;
			foreach($data as $rs_user){
				$inx++;
		?>
			<li><span style="width:20px;float:left;text-align:right;padding-right:5px;"><?php echo $inx.".";?></span><a href="rate_percentile.php?UID=<?php echo encrypt($rs_user['_Uid'],$Encrypt); ?>&CatID=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>"><?php echo $rs_user['_name']; ?></a><span style="color:<?php if($rs_user['rate'] >= 0 && $rs_user['rate'] <= 64){?>#800080;<?php } if($rs_user['rate']>=65 && $rs_user['rate']<=74){?>#0000FF;<?php } if($rs_user['rate']>=75 && $rs_user['rate']<=79){?>#008000;<?php } if($rs_user['rate']>=80 && $rs_user['rate']<=89){?>#FFA500;<?php } if($rs_user['rate']>=90 && $rs_user['rate']<=100){?>#FF0000;<?php }?>">
		<?php
				if($rs_user['rate'] < 0)
				{
					echo "0"."%";
				}
				else
				{
					echo $rs_user['rate']."%";
				}
				echo "</span></li>";
			}
			?>           
			</ul>
            		
		</div>	
	</div>
    <?php
	}
	?>	
	<div class="clr"></div>
	</div>
<?php
	include('footer.php');
?>
</body>
</html>
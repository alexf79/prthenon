<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}

include('global.php');
include('include/functions.php');

$view_userID = decrypt($_REQUEST['UID'],$Encrypt);

$user_id = $view_userID;
if($_SESSION['userid'] == $view_userID)
{
	echo "<script language='javascript'>window.location='category_listing.php';</script>";
}
else
{
	//get user data for the user to show their profile
	if($view_userID != '')
	{
		$sel_mem="select * from ".$tbname."_member where _ID='".$view_userID."' AND _Username != '' AND _Password != '' ORDER BY `_Regdate` ASC LIMIT 1";
		$qr_mem=mysql_query($sel_mem);
	
		$res_mem=mysql_fetch_array($qr_mem);
		if($res_mem)
		{
			$_SESSION['view_user']['userid'] = $res_mem['_ID'];		
			$_SESSION['view_user']['username'] = $res_mem['_Username'];
			$_SESSION['view_user']['fname'] = $res_mem['_Fname'];
			$_SESSION['view_user']['lname'] = $res_mem['_Lname'];
			$_SESSION['view_user']['gender'] = $res_mem['_Gender'];
			$_SESSION['view_user']['birthdate'] = $res_mem['_Birthdate'];
			$_SESSION['view_user']['email'] = $res_mem['_Email'];
			$_SESSION['view_user']['photo'] = $res_mem['_Photo'];
			$_SESSION['view_user']['answers'] = $res_mem['_QAanswers'];
			$_SESSION['view_user']['regdate'] = $res_mem['_Regdate'];
			$_SESSION['view_user']['lastlog'] = $res_mem['_Lastlog'];
			$_SESSION['view_user']['logno'] = $res_mem['_Logno'];
		}
	}
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
	<head>
	<?php include('topscript.php'); ?>
	</head>
	
	<body>
		<?php include('header.php');?>
	
		<div class="profile-info">
			<?php
			if($_SESSION['view_user']['photo'] == '')
			{
				?>
				<img src="images/profile-pic.jpg" class="profile-pic">
				<?php
			}
			else
			{
				?>
				<img width="120px" height="120px" src="images/profiles/<?php echo $_SESSION['view_user']['photo'];?>" class="profile-pic">
				<?php
			}
			?>
			<span><?php echo $_SESSION['view_user']['fname'] .' '. $_SESSION['view_user']['lname']; ?></span>
			<p><?php echo $_SESSION['view_user']['gender'];?></p>
			<p><?php echo $_SESSION['view_user']['birthdate'];?></p>
			<p><?php echo $_SESSION['view_user']['location'];?></p>	
			<div class="clr"></div>
			
			<?php //include('viewButtons.php');?>
			<?php //include('view_user_questions.php');?>
			<?php include('wall_block.php');?>
		</div>
	
		<br />
		<div class="top-lists">
			<?php
			$sel_cat="select * from ".$tbname."_category ";
			$qr_cat=mysql_query($sel_cat);
			while($rs_cat=mysql_fetch_array($qr_cat))
			{
				?>
				<div class="cat-list">
					<h3>YOUR TOP TEN IN <?php echo  strtoupper($rs_cat['_Name']); ?></h3>
					<div class="cat-sublist">
						<ul>
							<?php
					
						$catarray=array();
						//fetch user
					
						//$sel_other_user="select ur._Uid as _Uid,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID !='".$_SESSION['userid']."' group by _Uid ";
					
						$sel_other_user="select ur._Uid as _Uid,m._Fname,m._Lname,m._Photo from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID !='".$_SESSION['view_user']['userid']."' group by _Uid ";
						$qr_other_user=mysql_query($sel_other_user);
						
						while($rs_other_user=mysql_fetch_array($qr_other_user))
						{
							$totalrate="";
							$no=0;
							$avgrate="";
							//fetch rate of selected user
					
							$sel_mv="select ur.*,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and ur._Uid ='".$rs_other_user['_Uid']."' and ur._Prodid in (select ur._Prodid from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['view_user']['userid']."' group by ur._Prodid) ";
							$qr_mv=mysql_query($sel_mv);
							
							while($rs_users=mysql_fetch_array($qr_mv))
							{
								$no++;
								$user_rate=$rs_users['_Rate'];
						
								$sel_mrate="select ur.*,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['view_user']['userid']."' AND p._ID='".$rs_users['_Prodid']."' ";
								$qr_mrate=mysql_query($sel_mrate);
								
								if(mysql_num_rows($qr_mrate) > 0)
								{
													
									$rs_my_rate=mysql_fetch_array($qr_mrate);
									if($rs_my_rate['_Rate'])
									{
										$my_rate=$rs_my_rate['_Rate'];
									}
									
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
								
							}//while
							
							if($totalrate !=0)
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
							$sel_other_user="select ur._Uid as _Uid,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID !='".$_SESSION['view_user']['userid']."' group by _Uid order by FIELD(ur._Uid, ".$user_array.") ";
							$qr_other_user=mysql_query($sel_other_user);
							 $a=mysql_num_rows($qr_other_user);
							while($rs_other_user=mysql_fetch_array($qr_other_user))
							{
							
								$str_other_user_p="select * from ".$tbname."_userrates as ur left join ".$tbname."_member as m on m._ID=_Uid join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' AND ur._Uid ='".$_SESSION['view_user']['userid']."' ";
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
					
									$sel_mv="select ur.*,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and ur._Uid ='".$rs_other_user['_Uid']."' and ur._Prodid in (select ur._Prodid from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['view_user']['userid']."' group by ur._Prodid)  ";
									$qr_mv=mysql_query($sel_mv);
									
									while($rs_users=mysql_fetch_array($qr_mv))
									{
										$no++;
										$user_rate=$rs_users['_Rate'];
						
										$sel_mrate="select ur.*,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['view_user']['userid']."' AND p._ID='".$rs_users['_Prodid']."' ";
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
									
									$c=0;
			  
									$sel_list="select ur.*,m._Fname,m._Lname,p._Title as ProductName from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$rs_other_user['_Uid']."' ";
									$qr_list=mysql_query($sel_list);
				
									while($rs_list=mysql_fetch_array($qr_list))
									{	
										
										$sel_myrate="select * from ".$tbname."_userrates where _Prodid='".$rs_list['_Prodid']."' and _Uid='".$_SESSION['view_user']['userid']."'";
										$qr_myrate=mysql_query($sel_myrate);
										
										$rs_myrate=mysql_fetch_array($qr_myrate);
											
										$my_prate=$rs_myrate['_Rate'];
										if($my_prate>0)
										{
											$c++;
										}
									}
									
									if($c>=10)
									{   
										//query the viewlog table to find out if our user 
										//has ever visited the other user's percentile comparison 
										//page for this particular category. 
										$vl_query = "SELECT _DATE FROM  ".$tbname."_viewlog 
													 WHERE _UID = '".$_SESSION['view_user']['userid']."' 
													 AND _MID = '".$rs_other_user['_Uid']."' 
													 AND _CID = '".$rs_cat['_ID']."'
													 ORDER BY _DATE DESC LIMIT 1";
										$vl_result = mysql_query($vl_query);									
										$num_vl = mysql_num_rows($vl_result);   
										
										//if our user has visited the other user's percentile comparison page.. 
										if($num_vl > 0)
										{
											while($num_row = mysql_fetch_assoc($vl_result))
											{
												$row_date = $num_row['_DATE'];
												
												//get only a count of all ratings/comments since our user
												//last visited the other user's percentile comparison page
												$new_c = "SELECT _UID FROM ".$tbname."_comment WHERE _UID = '".$rs_other_user['_Uid']."' AND _DateAdded > '".$row_date."'";
												$new_cr = mysql_query($new_c);
												$num_new_c = mysql_num_rows($new_cr);	
	
												$new_r = "SELECT _Uid FROM ".$tbname."_userrates WHERE _Uid = '".$rs_other_user['_Uid']."' AND _DateAdded > '".$row_date."'";
												$new_rr = mysql_query($new_r);
												$num_new_r = mysql_num_rows($new_rr);	
												$total_new = $num_new_c + $num_new_r;	
											}
										}
										else
										{
											//get count of ALL ratings/comments for the other
											//user since the beginning of time
											$rq = mysql_query("SELECT _Uid FROM ".$tbname."_userrates WHERE _Uid = '".$rs_other_user['_Uid']."'");
											$cq = mysql_query("SELECT _UID FROM ".$tbname."_comment WHERE _UID = '".$rs_other_user['_Uid']."'");
											$num_r = mysql_num_rows($rq);
											$num_c = mysql_num_rows($cq);
											$total_new = $num_r + $num_c;
										}
										?>         
										<li>
											<a href="user_profile.php?UID=<?php echo encrypt($rs_other_user['_Uid'],$Encrypt); ?>&CatID=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>">
											<?php
											if($rs_other_user['_Photo'] != '' && is_file('/images/profiles/'.$rs_other_user['_Photo']))
											{
												?>
												<img width="32px" height="32px" src="images/profiles/<?php echo $rs_other_user['_Photo'];?>" class="profile-pic-small" style="border-radius: 6px;">
												<?php
											}
											else
											{
												?>
												<img width="32px" height="32px" src="images/profile-pic.jpg" class="profile-pic-small" style="border-radius: 6px;">                                          
												<?php
											}
											?>
											<?php echo $rs_other_user['_Fname']." ".$rs_other_user['_Lname']; ?>
											</a>
											&nbsp;&nbsp;&nbsp;&nbsp;
											<!--<a href="browsepost.php?UID=<?php echo encrypt($rs_other_user['_Uid'],$Encrypt); ?>&CatID=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>">(Browse Post)</a>--> 
											<a href="rate_percentile.php?UID=<?php echo encrypt($rs_other_user['_Uid'],$Encrypt); ?>&CatID=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>">
	
											<span style="margin-top:10px;color:<?php if(ceil($avgrate)>=0 && ceil($avgrate)<=64){?>#800080;<?php } if(ceil($avgrate)>=65 && ceil($avgrate)<=74){?>#0000FF;<?php } if(ceil($avgrate)>=75 && ceil($avgrate)<=79){?>#008000;<?php } if(ceil($avgrate)>=80 && ceil($avgrate)<=89){?>#FFA500;<?php } if(ceil($avgrate)>=90 && ceil($avgrate)<=100){?>#FF0000;<?php }?>">
												<?php
												if($avgrate < 0)
												{
													echo "0"."%";
												}
												else
												{
													echo ceil($avgrate)."%";
												}
												
												if($total_new != 0)
												{
													echo "<font color='#000000' size='-1'>&nbsp;&nbsp;".$total_new." New Ratings</font>";
												}
												?>
											</span>
											</a>
										</li>
										<?php
										unset($total_new);
									}
								}
							}
						}
						?>           
						</ul>
						<div>
							<?php
								if($a>10)
								{
							 ?>
							<a class="viewall" href="rate_detail.php?CatId=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>">Full Rankings</a>
						<?php }?>
						</div>		
					</div>	
				</div>
				<?php
				if($rs_cat['_ID']==2)
				{
					echo '<div class="clr"></div>';
				}
			}
			?>
		</div>
	
		<div class="clr"></div>
	
		<?php include('footer.php');?>
	</body>
	</html>
	<? 
} 
?>
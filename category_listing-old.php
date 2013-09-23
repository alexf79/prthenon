<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}

include('global.php');
include('include/functions.php');

if($_POST['submit-pic'] == 'Upload')
{
	//
	//$picName = $_POST['profile-pic'];
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$extension = end(explode(".", $_FILES["file"]["name"]));
	if 
	((  ($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		//&& ($_FILES["file"]["size"] < 1000000)
		&& in_array($extension, $allowedExts
	))
  	{
  		if ($_FILES["file"]["error"] > 0)
    	{
			$imageError = 1;
    		$imageResult = "Return Code: " . $_FILES["file"]["error"] . "<br>";
    	}
  		else
    	{
   			if (file_exists("images/profiles" . $_FILES["file"]["name"]))
   			{
				$imageError = 1;
   				$imageResult = $_FILES["file"]["name"] . " already exists. ";
   			}
   			else
   			{
   				move_uploaded_file($_FILES["file"]["tmp_name"],"images/profiles/" . $_FILES["file"]["name"]);
				$imageResult = "Profile pic uploaded successfully!";
				$imageError = 0;
				$sql = "UPDATE ".$tbname."_member SET _Photo = '".$_FILES["file"]["name"]."' WHERE _ID = '".$_SESSION['userid']."'";
				$rst = mysql_query($sql,$connect) or die(mysql_error());	
				$_SESSION['photo'] = $_FILES['file']['name'];			
  			}
   		}
	}
	else
	{
		$imageResult = "Invalid file";
		$imageError = 1;
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
		if($_SESSION['photo'] == '')
		{
        	?>
			<img src="images/profile-pic.jpg" class="profile-pic">
        	<?php
		}
		else
		{
			?>
            <img width="120px" height="120px" src="images/profiles/<?php echo $_SESSION['photo'];?>" class="profile-pic">
			<?php
        }
        ?>
        <span><?php echo $_SESSION['fname'] .' '. $_SESSION['lname']; ?></span>
        <p>Male</p>
        <p>April 11, 2013</p>
        <p>Boise, Idaho</p>	
        <div class="clr"></div>
        <form name='upload-pic' id='upload-pic' action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        	<div class="view-button">
            Upload Profile Image:
            <input name="file" id='file' type="file" size="25" />
        	
            <input name="submit-pic" type="submit" value="Upload" />
            <?php 
			if($imageError == 1)
			{
				?>
                <br />
                <span style="color:red; font-size:14px;">
					<?php echo $imageResult;?><br />
                    <?php echo "File Name: ".$_FILES["file"]["name"];?><br />
                    <?php echo "File Temp Name: ".$_FILES["file"]["tmp_name"];?><br />
                    <?php echo "File Type: ".$_FILES["file"]["type"];?><br />
                    <?php echo "File Size: ".$_FILES["file"]["size"];?><br />
                    <?php echo "File Error: ".$_FILES["file"]["error"];?><br />

                </span>
                <?php
			}
			elseif($imageError == 0)
			{
				?>
                <br /><span style="color:green; font-size:14px;"><?php echo $imageResult;?></span>
				<?php
			}
			?>
        	</div><br />
        </form>
        <div class="view-button">View 220 Movie Reviews</div><br>
        <div class="view-button">View 96 Movie Reviews</div><br>
        <div class="view-button">View 34 Movie Reviews</div><br>
        <div class="view-button">View 88 Movie Reviews</div><br />
		<?php include('prof_questions.php');?>
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
				
					$sel_other_user="select ur._Uid as _Uid,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID !='".$_SESSION['userid']."' group by _Uid ";
					$qr_other_user=mysql_query($sel_other_user);
					while($rs_other_user=mysql_fetch_array($qr_other_user))
					{
						$totalrate="";
						$no=0;
						$avgrate="";
						//fetch rate of selected user
				
						$sel_mv="select ur.*,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and ur._Uid ='".$rs_other_user['_Uid']."' and ur._Prodid in (select ur._Prodid from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['userid']."' group by ur._Prodid) ";
						$qr_mv=mysql_query($sel_mv);
						
						while($rs_users=mysql_fetch_array($qr_mv))
						{
							$no++;
							$user_rate=$rs_users['_Rate'];
					
							$sel_mrate="select ur.*,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['userid']."' AND p._ID='".$rs_users['_Prodid']."' ";
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
						$sel_other_user="select ur._Uid as _Uid,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID !='".$_SESSION['userid']."' group by _Uid order by FIELD(ur._Uid, ".$user_array.") ";
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
				
								$sel_mv="select ur.*,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and ur._Uid ='".$rs_other_user['_Uid']."' and ur._Prodid in (select ur._Prodid from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['userid']."' group by ur._Prodid)  ";
								$qr_mv=mysql_query($sel_mv);
								
								while($rs_users=mysql_fetch_array($qr_mv))
								{
									$no++;
									$user_rate=$rs_users['_Rate'];
					
									$sel_mrate="select ur.*,m._Fname,m._Lname from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$rs_cat['_ID']."' and m._ID ='".$_SESSION['userid']."' AND p._ID='".$rs_users['_Prodid']."' ";
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
									
									$sel_myrate="select * from ".$tbname."_userrates where _Prodid='".$rs_list['_Prodid']."' and _Uid='".$_SESSION['userid']."'";
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
          							?>         
            						<li>
                                    	<a href="rate_percentile.php?UID=<?php echo encrypt($rs_other_user['_Uid'],$Encrypt); ?>&CatID=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>"><?php echo $rs_other_user['_Fname']." ".$rs_other_user['_Lname']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;<!--<a href="browsepost.php?UID=<?php echo encrypt($rs_other_user['_Uid'],$Encrypt); ?>&CatID=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>">(Browse Post)</a>--> 
                                        <span style="color:<?php if(ceil($avgrate)>=0 && ceil($avgrate)<=64){?>#800080;<?php } if(ceil($avgrate)>=65 && ceil($avgrate)<=74){?>#0000FF;<?php } if(ceil($avgrate)>=75 && ceil($avgrate)<=79){?>#008000;<?php } if(ceil($avgrate)>=80 && ceil($avgrate)<=89){?>#FFA500;<?php } if(ceil($avgrate)>=90 && ceil($avgrate)<=100){?>#FF0000;<?php }?>">
										<?php
										if($avgrate < 0)
										{
											echo "0"."%";
										}
										else
										{
											echo ceil($avgrate)."%";
										}
										?>
                                    	</span>
                                    </li>
            						<?php
								}
							}
						}
					}
					?>           
					</ul>
        	    	<div>
        	    		<a class="viewall" href="rate_detail.php?CatId=<?php echo encrypt($rs_cat['_ID'],$Encrypt); ?>">Click here to view all</a>
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
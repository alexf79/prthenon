<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}

include('global.php');
include('include/functions.php');

$CatID=decrypt($_REQUEST['CatID'],$Encrypt);
$UID=decrypt($_REQUEST['UID'],$Encrypt);


$sel_mem="select * from ".$tbname."_member where _ID='".$UID."' ";
$qr_mem=mysql_query($sel_mem);
$rs_mem=mysql_fetch_array($qr_mem);

$sel_cat="select * from ".$tbname."_category where _ID='".$CatID."' ";
$qr_cat=mysql_query($sel_cat);
$rs_cat=mysql_fetch_array($qr_cat);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<?php
	include('topscript.php');
?>
<link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php
  	include('header.php');
  ?>
<div class="cat-menu" style="min-height:350px;">
 
  <div class="cat-title">
  <h3 style="text-align:center;">Your similarity to <?php echo ucfirst($rs_mem['_Username']); ?> in <?php echo  strtoupper($rs_cat['_Name']); ?> is..</h3>
  		<?php
			$totalrate=0;
			$no=0;
			$avgrate=0;
			
			$sel_mv="select ur.*,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$CatID."' and ur._Uid ='".$_SESSION['userid']."' ";
			$qr_mv=mysql_query($sel_mv);
			
			while($rs_users=mysql_fetch_array($qr_mv))
			{
					$no++;
					$user_rate=$rs_users['_Rate'];
					
					$sel_mrate="select ur.*,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$CatID."' and m._ID ='".$UID."' AND p._ID='".$rs_users['_Prodid']."' ";
					$qr_mrate=mysql_query($sel_mrate);
					
					if(mysql_num_rows($qr_mrate) > 0)
					{
										
						$rs_my_rate=mysql_fetch_array($qr_mrate);
						$my_rate=$rs_my_rate['_Rate'];
						if($my_rate > 0.00 && $my_rate <= 2.00)
						{
							$my_grad="F";
							$my_grad_value=5;
						}
						if($my_rate > 2.00 && $my_rate <= 4.00)
						{
							$my_grad="D";
							$my_grad_value=4;
						}
						if($my_rate > 4.00 && $my_rate <= 6.00)
						{
							$my_grad="C";
							$my_grad_value=3;
						}
						if($my_rate > 6.00 && $my_rate <= 8.00)
						{
							$my_grad="B";
							$my_grad_value=2;
						}
						if($my_rate > 8.00 && $my_rate <= 10.00)
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
					if($user_rate > 0.00 && $user_rate <= 2.00)
					{
						$user_grad="E";
						$user_grad_value=5;
					}
					if($user_rate > 2.00 && $user_rate <= 4.00)
					{
						$user_grad="D";
						$user_grad_value=4;
					}
					if($user_rate > 4.00 && $user_rate <= 6.00)
					{
						$user_grad="C";
						$user_grad_value=3;
					}
					if($user_rate > 6.00 && $user_rate <= 8.00)
					{
						$user_grad="B";
						$user_grad_value=2;
					}
					if($user_rate > 8.00 && $user_rate <= 10.00)
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
				
				    if($no > 0)
					{
						$avgrate=$totalrate / $no;
					}
					

			
			
		?>
  
  		<div style="text-align:center;"><h1><span style="background:#000000;color:#FF9900; padding:10px 20px;border-radius:10px;"><?php

		if($avgrate < 0)
		{
			echo "0"."%";
		}
		else
		{
			echo ceil($avgrate)."%";
		}

		?></span></h1></div>
        <table width="700" border="0" align="center" cellpadding="5" cellspacing="0">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr style="font-size:20px;">
            <td width="33%" align="left"><strong>Title</strong></td>
            <td width="33%" align="center"><strong>Rating</strong></td>
            <td width="34%" align="center"><strong>My Rating</strong></td>
          </tr>
          <?php
		  	$sel_list="select ur.*,m._Username as username,p._Title as ProductName from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$CatID."' and m._ID ='".$UID."'  ";
			$qr_list=mysql_query($sel_list);
			$i=1;
			while($rs_list=mysql_fetch_array($qr_list))
			{	
				if($i%2 == 0)
				  {
					  $classname="tr-color-gray";
				  }
				  else
				  {
					  $classname="tr-color-white"; 
				  }
				$sel_myrate="select * from ".$tbname."_userrates where _Prodid='".$rs_list['_Prodid']."' and _Uid='".$_SESSION['userid']."'";
				$qr_myrate=mysql_query($sel_myrate);
				if(mysql_num_rows($qr_myrate) > 0)
				{
					$rs_myrate=mysql_fetch_array($qr_myrate);
					
					$my_prate=$rs_myrate['_Rate'];
					
					if($my_prate > 0.00 && $my_prate < 2.00)
					{
						$my_pgrad="F";
					}
					if($my_prate >= 2.00 && $my_prate < 4.00)
					{
						$my_pgrad="D";
					}
					if($my_prate >= 4.00 && $my_prate < 6.00)
					{
						$my_pgrad="C";
					}
					if($my_prate >= 6.00 && $my_prate < 8.00)
					{
						$my_pgrad="B";
					}
					if($my_prate >= 8.00 && $my_prate <= 10.00)
					{
						$my_pgrad="A";
					}
				}
				else
				{
					$my_pgrad="";
					$my_prate="";
				}
				/*Other user*/
				if($rs_list['_Rate'] > 0.00 && $rs_list['_Rate'] < 2.00)
				{
					$user_pgrade="F";
				}
				if($rs_list['_Rate'] >= 2.00 && $rs_list['_Rate'] < 4.00)
				{
					$user_pgrade="D";
				}
				if($rs_list['_Rate'] >= 4.00 && $rs_list['_Rate'] < 6.00)
				{
					$user_pgrade="C";
				}
				if($rs_list['_Rate'] >= 6.00 && $rs_list['_Rate'] < 8.00)
				{
					$user_pgrade="B";
				}
				if($rs_list['_Rate'] >= 8.00 && $rs_list['_Rate'] <= 10.00)
				{
					$user_pgrade="A";
				}
		  	?>
          	<tr class="<?php echo $classname; ?>">
            	<td width="33%" align="left"><strong><?php echo $rs_list['ProductName']; ?></strong></td>
            	<td width="33%" align="center"><strong><?php echo $rs_list['_Rate'].' , "'.$user_pgrade.'"'; ?></strong></td>
            	<td width="34%" align="center"><strong><?php 
				if($my_pgrad)
				{
				echo $my_prate.' , "'.$my_pgrad.'"';
				}
				?></strong></td>
          	</tr>          
         	<?php
			$i++;
			}
			?>
        </table>			
	</div>
</div>
<?php
	include('footer.php');
?>
</body>
</html>

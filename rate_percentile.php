<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}

include('global.php');
include('include/functions.php');


function clean_num( $num )
{
	$pos = strpos($num, '.');
	if($pos === false) 
	{ 
		// it is integer number
		return $num;
	}
	else
	{ 
		// it is decimal number
		return rtrim(rtrim($num, '0'), '.');
	}
}


$CatID=decrypt($_REQUEST['CatID'],$Encrypt);
$UID=decrypt($_REQUEST['UID'],$Encrypt);

//insert/update viewlog table, which is used to tell how many 'new' reviews 
//the user has had since last time this user has checked their comparison page
$date = date("Y-m-d");

$log_sql = "SELECT * FROM ".$tbname."_viewlog WHERE _UID = '".$_SESSION['userid']."' AND _MID = '".$UID."' AND _CID = '".$CatID."'";
$log_qry = mysql_query($log_sql, $connect)or die(mysql_error());	
    
$num_log = mysql_num_rows($log_qry);    
if($num_log > 0)
{
	//update instead of insert
	$sql = "UPDATE ".$tbname."_viewlog SET _DATE = '".$date."' WHERE _UID = '".$_SESSION['userid']."' AND _MID = '".$UID."' AND _CID = '".$CatID."'";	
}
else
{
	$sql = "INSERT INTO ".$tbname."_viewlog SET _UID = '".$_SESSION['userid']."', _MID = '".$UID."', _CID = '".$CatID."', _DATE = '".$date."'";
}

$rst = mysql_query($sql,$connect) or die(mysql_error());	

$sel_mem="select * from ".$tbname."_member where _ID='".$UID."' ";
$qr_mem=mysql_query($sel_mem);
$rs_mem=mysql_fetch_array($qr_mem);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<?php
	include('topscript.php');
?>
<link rel="stylesheet" href="css/style.css">
<script src="ui/jquery-1.8.0.js"></script>
</head>

<body>
<?php
  	include('header.php');
	
	$sel_cat="select * from ".$tbname."_category where _ID='".$CatID."' ";
	$qr_cat=mysql_query($sel_cat);
	$rs_cat=mysql_fetch_array($qr_cat);
	
  ?>
<div class="cat-menu" style="min-height:350px;">

  <div class="cat-title">
  <h3 style="text-align:center;">Your similarity to <?php echo ucfirst($rs_mem['_Fname'])." ".ucfirst($rs_mem['_Lname']); ?> in <?php echo  strtoupper($rs_cat['_Name']); ?> is..</h3><br />
  		<?php
			$totalrate=0;
			$no=0;
			$avgrate=0;
			
			$sel_mv="select ur.*,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$CatID."' and ur._Uid ='".$UID."' and ur._Prodid in (select ur._Prodid from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$CatID."' and m._ID ='".$_SESSION['userid']."' group by ur._Prodid) ";
			$qr_mv=mysql_query($sel_mv);
			
			while($rs_users=mysql_fetch_array($qr_mv))
			{$no++;
					$user_rate=$rs_users['_Rate'];
					
					$sel_mrate="select ur.*,m._Username as username from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$CatID."' and m._ID ='".$_SESSION['userid']."' AND p._ID='".$rs_users['_Prodid']."' ";
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
					}
					
				    if($no > 0)
					{
						$avgrate=$totalrate / $no;
					}
					

			
			
		?>
  
  		<div style="text-align:center;">
        	<h1>
            	<span style="background:#000000;color:
				<?php 
				if(ceil($avgrate)>=0 && ceil($avgrate)<=64){ $percColor = '#800080'; echo $percColor.";"; } 
				if(ceil($avgrate)>=65 && ceil($avgrate)<=74){ $percColor = '#0000FF'; echo $percColor.";"; } 
				if(ceil($avgrate)>=75 && ceil($avgrate)<=79){ $percColor = '#008000'; echo $percColor.";"; } 
				if(ceil($avgrate)>=80 && ceil($avgrate)<=89){ $percColor = '#FFA500'; echo $percColor.";"; } 
				if(ceil($avgrate)>=90 && ceil($avgrate)<=100){ $percColor = '#FF0000'; echo $percColor.";"; } ?>
                padding:10px 20px;border-radius:10px;">
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
              	<br /><br />
                <span style="color:<?php echo $percColor;?>;margin-top:5px;">
					<?php 
                    if(ceil($avgrate)>=0 && ceil($avgrate)<=59){ $percSimDesc = 'No Similarity'; echo $percSimDesc; } 
                    if(ceil($avgrate)>=60 && ceil($avgrate)<=64){ $percSimDesc = 'Poor'; echo $percSimDesc; } 
                    if(ceil($avgrate)>=65 && ceil($avgrate)<=69){ $percSimDesc = 'Weak'; echo $percSimDesc; } 
                    if(ceil($avgrate)>=70 && ceil($avgrate)<=74){ $percSimDesc = 'Below Average'; echo $percSimDesc; } 
                    if(ceil($avgrate)>=75 && ceil($avgrate)<=79){ $percSimDesc = 'Average'; echo $percSimDesc; }
                    if(ceil($avgrate)>=80 && ceil($avgrate)<=84){ $percSimDesc = 'Above Average'; echo $percSimDesc; }
                    if(ceil($avgrate)>=85 && ceil($avgrate)<=89){ $percSimDesc = 'Strong'; echo $percSimDesc; }
                    if(ceil($avgrate)>=90 && ceil($avgrate)<=94){ $percSimDesc = 'Great'; echo $percSimDesc; }
                    if(ceil($avgrate)>=95 && ceil($avgrate)<=100){ $percSimDesc = 'Excellent'; echo $percSimDesc; }

                    ?>  
                </span>
        	</h1>
        </div>
        <table width="700" border="0" align="center" cellpadding="5" cellspacing="0" style="margin:0 auto;">
          <tr>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr style="font-size:20px;">
            <td width="33%" align="left"><strong>Title</strong></td>
            <td width="33%" align="center"><strong>Rating</strong></td>
            <td width="34%" align="center"><strong>My Rating</strong></td>
          </tr>
          <?php
		  	$sel_list="select ur.*,m._Username as username,p._ID, p._Title as ProductName from ".$tbname."_userrates as ur left join ".$tbname."_member as m on ur._Uid=m._ID join ".$tbname."_product as p on p._ID=ur._Prodid where p._Catid='".$CatID."' and m._ID ='".$UID."' order by p._Title DESC";
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
            	<td width="33%" align="left">
                	<strong>
                    	<a href="viewcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_list['_ID'],$Encrypt);?>"  class="prod_title">
							<span class="title"><?php echo $rs_list['ProductName']; ?></span>
                        </a>
                    </strong>
                </td>
            	<td width="33%" align="center"><strong><?php echo  clean_num( $rs_list['_Rate'] ).'  "'.$user_pgrade.'"'; ?></strong></td>
            	<td width="34%" align="center"><strong><?php if($my_pgrad){ echo clean_num( $my_prate ).'  "'.$my_pgrad.'"';}?></strong></td>
          	</tr>          
         	<?php
			$i++;
			}
			?>
        </table>			
	</div>
</div>
<script>
$(document).ready(function()
{
	category = '<?php echo $rs_cat['_Name'];?>';
	var i=0;
	$('.prod_title').each(function()
	{
		if (category == 'Movies' || category == 'TV Shows')
		{
			_this = $('.title', this);
			query = $('.title', this).html();
			$.ajax(
			{
				url : 'getImage.php?title='+ escape(query),
				dataType:'json',
				success:function(data)
				{
					console.log(data);
					$('.prod_title .title').each(function()
					{
						if ($(this).html() == data.title)
						{
							imgTag = "<img src='" + data.content + "' style='height:80px;width:60px;'/>";
							$(this).before(imgTag);                                
						}
					});
				}
			});
		}
		else if (category == 'Games')
		{
			query = encodeURI($('.title', this).html() + ' Games');
			urlString = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" + query + "&callback=?";
			_this = $('.title', this);
			$.ajax(
			{
				url: urlString,
				dataType : 'jsonp',
				success:function(data)
				{
					$('.prod_title .title').each(function()
					{
						if ($(this).parent().find('img').length == 0)
						{
							imgTag = "<img src='"+data.responseData.results[0].tbUrl + "' style='height:80px;width:60px'/>";
							title = encodeURI($(this).html() + ' Games').replace(/\%20/g, "+");
							console.log(title);
							responseData = data.responseData.cursor.moreResultsUrl;
							responseDatas = responseData.split("&q=");
							console.log("response:" + responseDatas[1]);
							if (title == responseDatas[1])
							{
								$(this).before(imgTag);
							}
						}                                
					});
				}
			});
		}
		else
		{
			//if (i % 2 == 0){
				_this = $('.title', this);
				query = $('.title', this).html();
				$.ajax(
				{
					url : 'getImage.php?type=books&title='+ escape(query),
					dataType:'json',
					success:function(data)
					{
						$('.prod_title .title').each(function()
						{
							if ($(this).parent().find('img').length == 0)
							{
								if ($(this).html() == data.title)
								{
									imgTag = "<img src='" + data.url + "' style='height:80px;width:60px;'/>";
									$(this).before(imgTag);                                
								}
							}
						});
					}
				});
			//}
		}
		i++;               
	});
});
</script>
<?php
	include('footer.php');
?>
</body>
</html>
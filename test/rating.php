<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}


include('global.php');
include('include/functions.php');

$CatID=decrypt($_REQUEST['CID'],$Encrypt);
$done=decrypt($_REQUEST['done'],$Encrypt);
$alphabetic=decrypt($_REQUEST['alphabetic'],$Encrypt);
$searchkey=decrypt($_REQUEST['searchkey'],$Encrypt);

if($CatID)
{
	if($CatID==1)
	{
		$common_cat=10;
	}
	if($CatID==2)
	{
		$common_cat=10;
	}
	if($CatID==3)
	{
		$common_cat=10;
	}
	if($CatID==4)
	{
		$common_cat=10;
	}
	$sel_Cat_Detail="select * from ".$tbname."_category where _ID='".$CatID."' ";
	$qr_Cat_Detail=mysql_query($sel_Cat_Detail);
	$rs_Cat_Detail=mysql_fetch_array($qr_Cat_Detail);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<?php
	include('topscript.php');
?>
<link rel="stylesheet" href="base/jquery.ui.all.css">
<script src="ui/jquery-1.8.0.js"></script>
<script src="ui/jquery.ui.core.js"></script>
<script src="ui/jquery.ui.widget.js"></script>
<script src="ui/jquery.ui.mouse.js"></script>
<script src="ui/jquery.ui.slider.js"></script>
<link rel="stylesheet" href="ui/demos.css">
<!--<script type="text/javascript" src="greybox/AJS.js"></script>
<script type="text/javascript">
    var GB_ROOT_DIR = "./greybox/";
</script>
<script type="text/javascript" src="greybox/AJS_fx.js"></script>
<script type="text/javascript" src="greybox/gb_scripts.js"></script>
<link href="greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />-->
<script language="javascript" type="text/javascript">
function PopupCenter(pageURL, title,w,h) {
var left = (screen.width/2)-(w/2);
var top = (screen.height/2)-(h/2);
var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
function validatesearch()
{
	var err="";
	if(document.searchproduct.searchkey.value=="")
	{
		err +="Please Enter in Search Keyword.\n";
	}
	if(err !="")
	{
		alert(err);
		return false;
	}
	else
	{
		return true;
	}
}
</script>
<style>
.paginate {
font-family:Arial, Helvetica, sans-serif;
	padding: 3px;
	margin: 3px;
}

.paginate a {
	padding:2px 5px 2px 5px;
	margin:2px;
	border:1px solid #999;
	text-decoration:none;
	color: #666;
}
.paginate a:hover, .paginate a:active {
	border: 1px solid #999;
	color: #000;
}
.paginate span.current {
    margin: 2px;
	padding: 2px 5px 2px 5px;
		border: 1px solid #999;
		
		font-weight: bold;
		background-color: #999;
		color: #FFF;
	}
	.paginate span.disabled {
		padding:2px 5px 2px 5px;
		margin:2px;
		border:1px solid #eee;
		color:#DDD;
	}
	
	
</style>
</head>

<body>
<?php
  	include('header.php');
  ?>
<div class="cat-menu" style="min-height:350px;">
  <?php
	if($CatID)
	{
	?>
	
	  <div class="cat-title">
      <center>
    <h2 style="font-size:29px; margin-left:-10px;width:auto;width:300px;"><?php echo $rs_Cat_Detail['_Name']; ?></h2>
	</center>
    <div style="float: right;margin-top: -35px;width: 242px;">
    <form method="post" name="searchproduct" action="searchproduct.php" onsubmit="return validatesearch();">
			<input style="height:19px;" type="text" name="searchkey" value="<?php echo $searchkey; ?>" />
						<input type="submit" name="search" value="search" class="sign_up_bt" style="float:right;" />
					
      		<input type="hidden" name="CID" value="<?php echo $CatID; ?>" />
            
            <input type="hidden" name="page" value="<?php echo $page; ?>" />
            
	</form>
	</div>	
    
  </div>
 <br /><br />
 <?php
 if($rs_Cat_Detail['_Name']=='Movies')
 {?>
  <p align="center" style="margin:0 0 20px 0; font-size:16px;">
Rate as many movies as you want; the more movies you rate, the more accurate your results will be. <br />IMPORTANT: Parthenon only calculates the similarity between users who have rated a minimum of 10 movies in common.</p>
<?php
}
else if($rs_Cat_Detail['_Name']=='TV Shows')
{?>
<p align="center" style="margin:0 0 20px 0;font-size:16px;">
Rate as many TV shows as you want; the more shows you rate, the more accurate your results will be. <br />IMPORTANT: Parthenon only calculates the similarity between users who have rated a minimum of 10 shows in common.</p>
<?php
}
else if($rs_Cat_Detail['_Name']=='Games')
{?>
<p align="center" style="margin:0 0 20px 0;font-size:16px;">
Rate as many games as you want; the more games you rate, the more accurate your results will be. <br />IMPORTANT: Parthenon only calculates the similarity between users who have rated a minimum of 10 games in common.</p>
<?php
}
else if($rs_Cat_Detail['_Name']=='Books')
{?>
<p align="center" style="margin:0 0 20px 0;font-size:16px;">
Rate as many books as you want; the more books you rate, the more accurate your results will be. <br />IMPORTANT: Parthenon only calculates the similarity between users who have rated a minimum of 10 books in common.</p>
<?php
}
?>
  <form name="frmcat" action="ratingaction.php" method="post" >

  
  <input type="hidden" name="CatID" value="<?php echo $CatID; ?>" />
    <table width="1000" border="0" align="center" cellpadding="5" cellspacing="0" style="margin-left:-30px;">
      <tr align="center" class="page-char">
        <td colspan="2" style="font-size:16px;">
        	<a href="?CID=<?php echo encrypt($CatID,$Encrypt); ?>">#</a>&nbsp; 
			<?php
            foreach (range('A', 'Z') as $char) {
                ?>
                <a href="?alphabetic=<?php echo encrypt($char,$Encrypt); ?>&CID=<?php echo encrypt($CatID,$Encrypt); ?>"><?php echo $char; ?></a>&nbsp; 
                <?php
            }
            ?>
        </td>
      	</tr>
        <?php
		if($done && $done==1)
		{
		?>
       	<tr>
        	<td colspan="2" align="center" style="color:red;">Your rating has been added successfully.</td>
       	</tr>
      	<?php
		}
		?>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr style="font-size:21px;">
        <td width="50%" align="center" style="border:1px solid;"><strong>Title</strong></td>
        <td width="50%" align="center"  style="border:1px solid;"><strong>My Rating</strong></td>
      </tr>
      <?php
	  
		$sql = "select count(*) from ".$tbname."_product as p left join ".$tbname."_userrates as ur on ur._Prodid=p._ID and ur._Uid='".$_SESSION['userid']."' where p._Catid='".$CatID."'  ";
		if($alphabetic !='all' && $alphabetic !='')
		{
		  $sql .=" AND p._Title LIKE '".$alphabetic."%' ";
		}
		if($searchkey !='')
		{
		  $sql .=" AND p._Title LIKE '%".$searchkey."%' ";
		}
		$result = mysql_query($sql);
		$r = mysql_fetch_row($result);
		$numrows = $r[0];
		
		$rowsperpage = 25;
		
		$totalpages = ceil($numrows / $rowsperpage);
		
		
		if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
		   $currentpage = (int) $_GET['currentpage'];
		} else {
		   $currentpage = 1;
		} 
		
		if ($currentpage > $totalpages) {
		   $currentpage = $totalpages;
		} 
		
		if ($currentpage < 1) {
		   $currentpage = 1;
		}
		
		$offset = ($currentpage - 1) * $rowsperpage;
	  
	  $sel_prod="select p.*,ur._Rate as rate from ".$tbname."_product as p left join ".$tbname."_userrates as ur on ur._Prodid=p._ID and ur._Uid='".$_SESSION['userid']."' where p._Catid='".$CatID."'  ";
	  if($alphabetic !='all' && $alphabetic !='')
	  {
		  $sel_prod .=" AND p._Title LIKE '".$alphabetic."%' ";
	  }
	  if($searchkey !='')
	  {
		  $sel_prod .=" AND p._Title LIKE '%".$searchkey."%' ";
	  }
	  $sel_prod2 = $sel_prod. " LIMIT $offset, $rowsperpage ";
	  
	  //echo $sel_prod;
	  $qr_prod1=mysql_query($sel_prod);
	  
	  
	  $qr_prod=mysql_query($sel_prod2);
	  
	  	
		
	  $i=1;
	  while($rs_prod=mysql_fetch_array($qr_prod))
	  {
		  if($i%2 == 0)
		  {
			  $classname="tr-color-gray";
		  }
		  else
		  {
			  $classname="tr-color-white"; 
		  }
	  ?>
      <tr class="<?php echo $classname; ?>">
        <td style="border-left:1px solid; border-right:1px solid;"><a href="viewcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_prod['_ID'],$Encrypt); ?>"><?php echo $rs_prod['_Title']; ?></a></td>
        <td align="center" style="border-right:1px solid;"><script>
			$(function() {
				$( "#slider-range-min<?php echo $rs_prod['_ID']; ?>" ).slider({
					range: "min",
					value: <?php if($rs_prod['rate'] !='') { echo $rs_prod['rate']; } else { echo 0;} ?>,
					min: 0,
					max: 10,
					slide: function( event, ui ) {
						var prt=ui.value;
						var grd="";
						if(prt > 0.00 && prt < 2.00)
						{
							grd="F";
						}
						else if(prt >= 2.00 && prt < 4.00)
						{
							grd="D";
						}
						else if(prt >= 4.00 && prt < 6.00)
						{
							grd="C";
						}
						else if(prt >= 6.00 && prt < 8.00)
						{
							grd="B";
						}
						else if(prt >= 8.00 && prt <= 10.00)
						{
							grd="A";
						}
						if(ui.value > 0)
						{
							$( "#amount<?php echo $rs_prod['_ID']; ?>" ).val(ui.value );
							$( "#tagname<?php echo $rs_prod['_ID']; ?>" ).val('"'+grd+'"');
						}
						else
						{
							$( "#amount<?php echo $rs_prod['_ID']; ?>" ).val('');
							$( "#tagname<?php echo $rs_prod['_ID']; ?>" ).val('');
						}
						$( "#comment<?php echo $rs_prod['_ID']; ?>" ).html('<a style="color:#8E0818;" title="Add Comment" href="javascript:void(0);" onclick="PopupCenter(\'addcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_prod['_ID'],$Encrypt); ?>\', \'myPop1\',500,300);">Add comment/review</a>');
						}
				});
				if($( "#slider-range-min<?php echo $rs_prod['_ID']; ?>" ).slider( "value" ) > 0)
				{
				$("#amount<?php echo $rs_prod['_ID']; ?>" ).val($( "#slider-range-min<?php echo $rs_prod['_ID']; ?>" ).slider( "value" ) );
				}
				var rt=$( "#slider-range-min<?php echo $rs_prod['_ID']; ?>" ).slider( "value" );
				var prt=rt;
					var grd="";
					if(prt > 0.00 && prt < 2.00)
					{
						grd="F";
					}
					else if(prt >= 2.00 && prt < 4.00)
					{
						grd="D";
					}
					else if(prt >= 4.00 && prt < 6.00)
					{
						grd="C";
					}
					else if(prt >= 6.00 && prt < 8.00)
					{
						grd="B";
					}
					else if(prt >= 8.00 && prt <= 10.00)
					{
						grd="A";
					}
				if(rt != 0)
				{
					$("#tagname<?php echo $rs_prod['_ID']; ?>" ).val('"'+grd+'"');
					$("#comment<?php echo $rs_prod['_ID']; ?>" ).html('<a style="color:#8E0818;" title="Add Comment" href="javascript:void(0);" onclick="PopupCenter(\'addcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_prod['_ID'],$Encrypt); ?>\', \'myPop1\',500,300);">Add comment/review</a>');
				}
				});
		</script>
          <div class="demo" style="padding:0; float: right; width: 480px;">
            <div id="slider-range-min<?php echo $rs_prod['_ID']; ?>" style="width:225px; float:left; margin:3px 0; margin-left:10px;"></div>
            <input readonly="readonly" type="text" id="amount<?php echo $rs_prod['_ID']; ?>" name="amount<?php echo $rs_prod['_ID']; ?>" style="border:0; color:#496FAF; font-weight:bold; font-size:17px; float:left; width:30px; margin-left:15px;background:none;" /><input readonly="readonly" type="text" id="tagname<?php echo $rs_prod['_ID']; ?>" name="tagname<?php echo $rs_prod['_ID']; ?>" style="border:0; color:#496FAF; font-weight:bold; font-size:17px; float:left; width:30px;background:none;" />
            <input type="hidden" name="productID[]" value="<?php echo $rs_prod['_ID']; ?>" />
            <span style="float:left; margin-left:20px; font-size:12px;" id="comment<?php echo $rs_prod['_ID']; ?>"></span>
          </div></td>
      </tr>
      <?php
	  $i++;
	  }
	  ?>
      <tr>
        <td colspan="2" align="right" style="border-top:1px solid;">
        <?php

		if($lastpage > 1)
		{/*	
		$paginate .= "<div class='paginate'>";
		// Previous
		if ($page > 1){
			$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$prev'>previous</a>";
		}else{
			$paginate.= "<span class='disabled'>previous</span>";	}
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$paginate.= "<span class='current'>$counter</span>";
				}else{
					$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$counter&searchkey=".encrypt($searchkey,$Encrypt)."'>$counter</a>";}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$counter'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$LastPagem1'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$lastpage'>$lastpage</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=1'>1</a>";
				$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=2'>2</a>";
				
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$counter'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$LastPagem1'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$lastpage'>$lastpage</a>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=1'>1</a>";
				$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=2'>2</a>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$counter'>$counter</a>";}					
				}
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&page=$next'>next</a>";
		}else{
			$paginate.= "<span class='disabled'>next</span>";
			}
			
		
		$paginate.= "</div>";		
	*/
	
		}
		$range = 3;
		echo mysql_num_rows($qr_prod1).' Results';
		echo "<div class='paginate'>";
		if ($currentpage > 1) {
		   echo " <a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&searchkey=".encrypt($searchkey,$Encrypt)."&currentpage=1'>First</a> ";
		   $prevpage = $currentpage - 1;
		   echo " <a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&searchkey=".encrypt($searchkey,$Encrypt)."&currentpage=$prevpage'>Previous</a> ";
		}
		
		
		for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
		   if (($x > 0) && ($x <= $totalpages)) {
			  if ($x == $currentpage) {
				 echo " <span class='current'><b>$x</b></span> ";
			  } else {
				 echo " <a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&searchkey=".encrypt($searchkey,$Encrypt)."&currentpage=$x'>$x</a> ";
			  } 
		   } 
		} 
		
		
		if ($currentpage != $totalpages) {
		   $nextpage = $currentpage + 1;
		   echo " <a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&searchkey=".encrypt($searchkey,$Encrypt)."&currentpage=$nextpage'>Next</a> ";
		   echo " <a href='$targetpage?CID=".encrypt($CatID,$Encrypt)."&alphabetic=".encrypt($alphabetic,$Encrypt)."&searchkey=".encrypt($searchkey,$Encrypt)."&currentpage=$totalpages'>Last</a> ";
		}
		 // pagination
		 echo "</div>";
		?>
        </td>
      </tr>
      <tr>
      	<td><span style="margin-left:250px; width:110px;">&nbsp;</span></td>
        <td>&nbsp;</td>
      </tr>
	 
	
	  </table>
	
	  
	  <table align="center" style="padding: 0px 13px 0px 0px;">
      <tr>
        <td align="center" colspan="2"><input style="width:110px; height:33px;" type="submit" name="Submit" value="Submit Ratings" class="sign_up_bt" ></td>
		<td>&nbsp;</td>
		<td><input type="button" style="width:110px; height:33px;" name="Result" onclick="window.location='category_listing.php';" value="Get Results" class="sign_up_bt" />
          </td>
      </tr>
    </table>
	  <input type="hidden" name="alphabetic" value="<?php echo $alphabetic; ?>"  />
  <input type="hidden" name="searchkey" value="<?php echo $searchkey; ?>"  />
  <input type="hidden" name="currentpage" value="<?php echo $currentpage; ?>"  />
  </form>
  <br /><br />
  	<p align="center" style="font-size:16px;">
	
	Seen a <?php echo $rs_Cat_Detail['_Name']; ?> not listed above? Send us a  <a href="#" style="font-size:16px;"><b>message</b></a> and we will update the list as soon as possible. Parthenon is and will always be a work in progress, so your opinions guide us toward making the site as useful and fun as possible.
	
	</p>
  <?php
	}
	?>
</div>
<?php
	include('footer.php');
?>
</body>
</html>

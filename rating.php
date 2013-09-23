<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}
                                                    

include('global.php');
include('include/functions.php');                 

$CatID=decrypt($_REQUEST['CID'],$Encrypt);
$myratings = decrypt($_REQUEST['myratings'],$Encrypt);

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
<script src="ui/jquery.ui.touch-punch.js"></script>
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

.ui-widget-header { 
    background: url("../images/rating-slider.png") 50% 50% repeat-x; 
    color: #222222; 
    font-weight: bold; 
}

.ui-slider, 
.ui-slider-horizontal, 
.ui-widget, 
.ui-widget-content, 
.ui-corner-all {
    width: 227px;
    float: left;
    margin: 5px 0;
    margin-left: 10px;
    height: 23px;
    background: url("../images/rating-slider-empty.png") 50% 50% repeat-x;
    border: 0px;
	border-radius: 6px;
	box-shadow: inset 0px 1px 6px rgba(0,0,0,0.2),inset 0px 0px 0px rgba(0,0,0,0.8);
}

.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
	border-radius: 0px;
	border: none;
	color: #555555;
	background: url("../images/slider-handle.png");
	width: 22px;
	height: 33px;
	box-shadow: none;
	cursor: pointer;
}

.ui-slider-horizontal .ui-slider-handle {
top: -10px;
margin-left: -10px;
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

	<div style="float: right;width: 320px;">
    <form method="post" name="searchproduct" action="searchproduct.php" onsubmit="return validatesearch();">
			<img src="images/search-icon.png" class="search-icon"><input class="search-box" type="text" name="searchkey" value="<?php echo $searchkey; ?>" />
						<input type="submit" name="search" value="search" class="sign_up_bt search-button" style="float:right;" />
					
      		<input type="hidden" name="CID" value="<?php echo $CatID; ?>" />
            
            <input type="hidden" name="page" value="<?php echo $page; ?>" />
            
	</form>
	</div>
	
	  <div class="cat-title">
      <center>
    <h2 style="margin-top:20px;">
	<?php 
	if($myratings == 'yes')
	{
		echo "MY ".substr($rs_Cat_Detail['_Name'],0,-1)." RATINGS";
	}
	else
	{
		echo $rs_Cat_Detail['_Name'];
	}
    ?>
    </h2>
	</center>
    	
    
  </div>
 <br />
 <?php
 if($rs_Cat_Detail['_Name']=='Movies')
 {?>
  <p align="center" class="cat-detail">
Rate as many movies as you want; the more movies you rate, the more accurate your results will be. <br />IMPORTANT: Prthenon only calculates the similarity between users who have rated a minimum of 10 movies in common.</p>
<?php
}
else if($rs_Cat_Detail['_Name']=='TV Shows')
{?>
<p align="center" class="cat-detail">
Rate as many TV shows as you want; the more shows you rate, the more accurate your results will be. <br />IMPORTANT: Prthenon only calculates the similarity between users who have rated a minimum of 10 shows in common.</p>
<?php
}
else if($rs_Cat_Detail['_Name']=='Games')
{?>
<p align="center" class="cat-detail">
Rate as many games as you want; the more games you rate, the more accurate your results will be. <br />IMPORTANT: Prthenon only calculates the similarity between users who have rated a minimum of 10 games in common.</p>
<?php
}
else if($rs_Cat_Detail['_Name']=='Books')
{?>
<p align="center" class="cat-detail">
Rate as many books as you want; the more books you rate, the more accurate your results will be. <br />IMPORTANT: Prthenon only calculates the similarity between users who have rated a minimum of 10 books in common.</p>
<?php
}
?>
  <form name="frmcat" action="ratingaction.php" method="post" >
	<input type="hidden" name="CatID" value="<?php echo $CatID; ?>" />
  	
  	<table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
      	<tr align="center" class="page-char">
	        <td colspan="2" style="text-align:right">
		       &nbsp;&nbsp; 
               	
                <span>
               		<a href="?catall=all&CID=<?php echo encrypt($CatID,$Encrypt); ?>" <?php if(isset($_REQUEST['catall'])) { ?> class="char-select"<?php } else { ?>style="color:#777777; font-weight:normal;"<?php } ?> >All</a>&nbsp;
               	</span>
               	<span style="font-size:34px; padding: 0px 4px; font-weight:bold;">|</span>
               	<span>
               		<a href="browsepost.php?UID=<?php echo encrypt("ALL",$Encrypt);?>&catbrowse=browse&CID=<?php echo encrypt($CatID,$Encrypt); ?>" <?php if(isset($_REQUEST['catbrowse'])) { ?> class="char-select"<?php } else { ?>style="color:#777777; font-weight:normal;"<?php } ?> >Browse</a>&nbsp;
               	</span>               
                <br />
		       
               	<span style="text-align:center; width:100%;">
				<a href="?cath=h&CID=<?php echo encrypt($CatID,$Encrypt); ?>" <?php if(isset($_REQUEST['cath'])) { echo 'style="color:#429631;padding: 0px 4px; font-weight:bold;font-size:44px;'; } else { echo 'style="color:#777777; padding: 0px 4px; font-weight:normal;font-size:44px;"'; } ?>">#</a>&nbsp; 
				<?php
                foreach (range('A', 'Z') as $char) 
                {
                    ?>
                    <a href="?alphabetic=<?php echo encrypt($char,$Encrypt); ?>&CID=<?php echo encrypt($CatID,$Encrypt); ?>" <?php if($alphabetic == $char) { echo 'class="char-select"'; } else { echo 'style="color:#777777; padding: 0px 4px; font-weight:normal;font-size:44px;"'; } ?>"><?php echo $char; ?></a>&nbsp; 
                    <?php
                }
                ?>
                </span>
	        </td>
      	</tr>
		<?php
        if($done && $done==1)
        {
        	?>
        	<tr><td colspan="2" align="center" class="rating-response">Your rating has been added successfully!</td></tr>
        	<?php
        }
        ?>
		
        <!--Table heading row-->
      	<tr><td><strong class="media-title" align="center">Title</strong></td><td><strong class="media-rating" align="center">My Rating</strong></td></tr>
		<!--End table heading row-->
        
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
			
			
		if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) 
		{
		   $currentpage = (int) $_GET['currentpage'];
		} 
		else 
		{
		   $currentpage = 1;
		} 
		
		if ($currentpage > $totalpages) 
		{
		   $currentpage = $totalpages;
		} 
		
		if ($currentpage < 1) 
		{
		   $currentpage = 1;
		}
		
		$offset = ($currentpage - 1) * $rowsperpage;
		  
	  	$sel_prod="SELECT p.*, ur._Rate AS rate 
				   FROM ".$tbname."_product 
				   AS p LEFT JOIN ".$tbname."_userrates 
				   AS ur ON ur._Prodid=p._ID 
				   AND ur._Uid='".$_SESSION['userid']."' 
				   WHERE p._Catid='".$CatID."'  ";
				 
	  	if($alphabetic !='all' && $alphabetic !=''){ $sel_prod .=" AND p._Title LIKE '".$alphabetic."%' "; }
	  	if($searchkey !=''){ $sel_prod .=" AND p._Title LIKE '%".$searchkey."%' "; }
	  
	  	$sel_prod2 = $sel_prod. " LIMIT $offset, $rowsperpage ";
	  
	  	//echo $sel_prod;
	  	$qr_prod1=mysql_query($sel_prod);
	  
	  	$qr_prod=mysql_query($sel_prod2);
		  	
		$i=1;
		
		while($rs_prod=mysql_fetch_array($qr_prod))
		{
			if($i%2 == 0){$classname="tr-color-gray";}
			else{$classname="tr-color-white"; }
		  	?>

      		<tr class="<?php echo $classname; ?>">
	  
			<?php
                  
            $qry = "SELECT _comment 
                	FROM ".$tbname."_comment 
                	WHERE _CID='".$CatID."' 
                	AND _PID='".$rs_prod['_ID']."' 
                	AND _UID='".$_SESSION['userid']."' ";
            
            $result = mysql_query($qry);
            $r = mysql_num_rows($result);
            
            if($r>=1)
            {	  
                ?>
                <!-- Start of Title Listings-->
                  
                  <!-- Item Name, Picture TD-->
                  <td style="border-left:2px solid #ccc;" class="title-column">
                    <a href="viewcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_prod['_ID'],$Encrypt);?>" class="prod_title">
                        <span class="title"><?php echo $rs_prod['_Title']; ?></span><br />
                        <font style="font-size:15px;color: #800080;"><?php echo $rs_prod['_Author']; ?></font>
                    </a>
                  </td>
                  <!--End of Item Name, Picture TD-->
          
                  <!-- Start Slider TD-->
                  <td align="center" style="border-right:2px solid #ccc;">
                    <script>
                    $(function() 
                    {
                        $( "#slider-range-min<?php echo $rs_prod['_ID']; ?>" ).slider(
                        {
                            range: "min",
                            value: <?php if($rs_prod['rate'] !='') { echo $rs_prod['rate']; } else { echo 0;} ?>,
                            min: 0,
                            max: 10,
                            slide: function( event, ui ) 
                            {
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
                                $( "#comment<?php echo $rs_prod['_ID']; ?>" ).html('<a class="comment-button" title="Edit Comment" href="javascript:void(0);" onclick="PopupCenter(\'editcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_prod['_ID'],$Encrypt); ?>\', \'myPop1\',550,350);">Edit Review</a>');
                            },
                            stop: function(event, ui)
                            {
                                $('#frmSubmit').trigger('click');
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
                            $("#comment<?php echo $rs_prod['_ID']; ?>" ).html('<a class="comment-button" title="Edit Comment" href="javascript:void(0);" onclick="PopupCenter(\'editcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_prod['_ID'],$Encrypt); ?>\', \'myPop1\',550,350);">Edit Review</a>');
                        }
                    });
                    </script>
                
                    <div class="demo" style="padding:0; float: right; width: 480px;">
                        <div id="slider-range-min<?php echo $rs_prod['_ID']; ?>" style="width:225px; float:left; margin:5px 0; margin-left:10px;"></div>
                        <input readonly="readonly" type="text" id="amount<?php echo $rs_prod['_ID']; ?>" name="amount<?php echo $rs_prod['_ID']; ?>" class="rating-number" /><input readonly="readonly" type="text" id="tagname<?php echo $rs_prod['_ID']; ?>" name="tagname<?php echo $rs_prod['_ID']; ?>" class="rating-letter" />
                        <input type="hidden" name="productID[]" value="<?php echo $rs_prod['_ID']; ?>" />
                        <span style="float:left; margin-left:15px; font-size:12px;" id="comment<?php echo $rs_prod['_ID']; ?>"></span>
                    </div>
                  
                    <?php
                    if($r>=1)
                    {
                      while($row=mysql_fetch_array($result))
                      {
                        ?>
                        <!--Start Comment Row-->
                        <tr class="<?php echo $classname; ?>" ><td colspan="2" style="border-top:0px; border-bottom:0px; border-left:2px solid #ccc; border-right:2px solid #ccc;" class="comment-display"><?php echo $row["_comment"]; ?></td></tr>
                        <!--End Comment Row-->
                        <?php
                      }
                    }
                    ?>
                  </td>
                  <!--End Slider TD-->
		
				  <?php
				  if($myratings == 'yes'){ $i++; }
			}
			else
			{
	  			if($myratings != 'yes')
				{
					?>
                    <td style="border-left:2px solid #ccc; border-right:2px solid #ccc;" class="title-column">
                        <a href="viewcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_prod['_ID'],$Encrypt);?>"  class="prod_title">
                            <span class="title"><?php echo $rs_prod['_Title']; ?></span><br />
                            <font style="font-size:15px;color: #800080;"><?php echo $rs_prod['_Author']; ?></font>
                        </a>
                    </td>
                    
                    <td align="center" style="border-right:2px solid #ccc">
                    	<script>
                    $(function() 
                    {
                        $( "#slider-range-min<?php echo $rs_prod['_ID']; ?>" ).slider(
                        {
                            range: "min",
                            value: <?php if($rs_prod['rate'] !='') { echo $rs_prod['rate']; } else { echo 0;} ?>,
                            min: 0,
                            max: 10,
                            slide: function( event, ui ) 
                            {
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
                                $( "#comment<?php echo $rs_prod['_ID']; ?>" ).html('<a class="comment-button" title="Add Comment" href="javascript:void(0);" onclick="PopupCenter(\'addcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_prod['_ID'],$Encrypt); ?>\', \'myPop1\',550,350);">Add Review</a>');
                            },
                            stop: function(event, ui)
                            {
                                $('#frmSubmit').trigger('click');
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
                            $("#comment<?php echo $rs_prod['_ID']; ?>" ).html('<a class="comment-button" title="Add Comment" href="javascript:void(0);" onclick="PopupCenter(\'addcomment.php?CID=<?php echo encrypt($CatID,$Encrypt); ?>&PCID=<?php echo encrypt($rs_prod['_ID'],$Encrypt); ?>\', \'myPop1\',550,350);">Add Review</a>');
                        }
                    });
                    </script>
                    
                    	<div class="demo" style="padding:0; float: right; width: 480px;">
                    	  <div id="slider-range-min<?php echo $rs_prod['_ID']; ?>" style="width:225px; float:left; margin:5px 0; margin-left:10px;"></div>
                    		<input readonly="readonly" type="text" id="amount<?php echo $rs_prod['_ID']; ?>" name="amount<?php echo $rs_prod['_ID']; ?>" class="rating-number" /><input readonly="readonly" type="text" id="tagname<?php echo $rs_prod['_ID']; ?>" name="tagname<?php echo $rs_prod['_ID']; ?>" class="rating-letter" />
                      		<input type="hidden" name="productID[]" value="<?php echo $rs_prod['_ID']; ?>" />
                      		<span style="float:left; margin-left:15px; font-size:12px;" id="comment<?php echo $rs_prod['_ID']; ?>"></span>
                    	</div>
                    
                    	<?php
                    if($r>=1)
                    {
                        while($row=mysql_fetch_array($result))
                        {
                            ?>
                            <tr class="cat-menu"><td colspan="2" style="border:solid 1px; border-top:0px; font-family:Arial; font-size:14px;"><?php echo $row["_comment"]; ?></td></tr>
                            <?php
                        }
                    }
                    ?>
                    </td>
		  			<?php
				}
			}
			?>    
   		 	</tr>
		  
    		<?php
			if($myratings != 'yes'){ $i++; }
		}
	  	?>
      	<!--Start Page Numbers-->
        <tr>
        <td colspan="2" align="right" style="border-top:2px solid #ccc; height: 75px; color: #49a637">
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
	
	  
	  <table align="center" style="margin:0px auto; padding: 0px 13px 0px 0px;">
      <tr>
        <td align="center" colspan="2"><input type="submit" name="Submit" id="frmSubmit" style="visibility:hidden" value="Submit Ratings" class="sign_up_bt" ></td>
		<td>&nbsp;</td>
		<td><input type="button" name="Result" onclick="window.location='category_listing.php';" value="Get Results" class="sign_up_bt" />
          </td>
      </tr>
    </table>
	  <input type="hidden" name="alphabetic" value="<?php echo $alphabetic; ?>"  />
	  <input type="hidden" name="myratings" value="<?php echo $myratings; ?>"  />
  <input type="hidden" name="searchkey" value="<?php echo $searchkey; ?>"  />
  <input type="hidden" name="currentpage" value="<?php echo $currentpage; ?>"  />
  </form>
  <br /><br />
  	<p align="center" class="cat-detail">
	
	<!--<span>Played a <?php echo strtolower(substr($rs_Cat_Detail['_Name'], 0, -1)); ?> not listed above?</span> Send us a  <a href="#" style="font-size:16px;"><b>message</b></a> and we will update the list as soon as possible. Prthenon is and will always be a work in progress, so your opinions guide us toward making the site as useful and fun as possible.
	-->
	<?php 
	if($rs_Cat_Detail['_Name']=='Movies')
	{?>
	<span>Seen a <?php echo strtolower(substr($rs_Cat_Detail['_Name'], 0, -1)); ?> not listed above?</span> Send us a  <a href="contactus.php" style="color: #429631;"><b>message</b></a> and we will update the list as soon as possible. Prthenon is and will always be a work in progress, so your opinions guide us toward making the site as useful and fun as possible.
	<?php
	}
	if($rs_Cat_Detail['_Name']=='TV Shows')
	{?>
	<span>Seen a TV show not listed above?</span> Send us a  <a href="contactus.php" style="color: #429631;"><b>message</b></a> and we will update the list as soon as possible. Prthenon is and will always be a work in progress, so your opinions guide us toward making the site as useful and fun as possible.
	<?php
	}
	if($rs_Cat_Detail['_Name']=='Games')
	{?>
	<span>Played a game not listed above?</span> Send us a  <a href="contactus.php" style="color: #429631;"><b>message</b></a> and we will update the list as soon as possible. Prthenon is and will always be a work in progress, so your opinions guide us toward making the site as useful and fun as possible.
	<?php
	}
	if($rs_Cat_Detail['_Name']=='Books')
	{?>
	<span>Read a book not listed above?</span> Send us a  <a href="contactus.php" style="color: #429631;"><b>message</b></a> and we will update the list as soon as possible. Prthenon is and will always be a work in progress, so your opinions guide us toward making the site as useful and fun as possible.
	<?php
	}
	 ?>
	</p>
  <?php
	}
	?>
</div>
<script>
$(document).ready(function()
{
	category = '<?php echo $rs_Cat_Detail['_Name'];?>';
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
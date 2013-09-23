<?php

$j=1;
	session_start();
	if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
	{
		echo "<script language='javascript'>window.location='index.php';</script>";
	}
	
	include('global.php');
	include('include/functions.php');
	//$_CID=decrypt($_REQUEST['CID'],$Encrypt);
	
	
	foreach($_GET as $k=>$v)
    {
        $v1=str_replace(" ","+",$v);
        $_GET[$k] = decrypt($v1,$Encrypt);
    }
     foreach($_REQUEST as $k=>$v)
    {
        $v1=str_replace(" ","+",$v);
        $_REQUEST[$k] = decrypt($v1,$Encrypt);
    }
    foreach($_POST as $k=>$v)
    {
       $_POST[$k] = decrypt($v,$Encrypt);
    }
	
	
	$_CID=$_REQUEST['CID'];
	$PID=$_REQUEST['PCID'];
	$id=$_SESSION['userid'];
{
	$select="SELECT cm.*,u._username,u._Fname,u._Lname FROM ".$tbname."_comment as cm JOIN ".$tbname."_member as u ON  u._ID=$id and cm._CID=$_CID and cm._UID=$id and cm._PID=$PID";
	
	
}

	
 //*	"SELECT cm.*,u._Username,c._Name,p._Title FROM ".$tbname."_comment as cm JOIN ".$tbname."_member as u ON u._ID=cm._UID JOIN ".$tbname."_category as c ON 			             c._ID=cm._CID JOIN ".$tbname."_product as p ON p._ID=cm._PID ";
//
	$rec=mysql_query($select);
                                                                                     
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<?php
	include('topscript.php');
?>
<script src="ui/jquery-1.8.0.js"></script>
</head>

<body>
<?php
	include('header.php');
	require_once('CurlBrowser.php');
	
	$sel1="SELECT * FROM ".$tbname."_category  WHERE _ID=$_CID";
	$re1=mysql_query($sel1);
	$r1=mysql_fetch_array($re1);

	$sel="SELECT * FROM ".$tbname."_product WHERE _ID=$PID";
	$re=mysql_query($sel);
	$r=mysql_fetch_array($re);
    //var_dump($r1['_Name']);
    if ($r1['_Name'] == 'Movies' || $r1['_Name'] == 'TV Shows'){
        $browser = new CurlBrowser();
        $url = "http://www.imdb.com/find?q=".urlencode($r['_Title'])."&s=all";
        $result = $browser->get($url);
        $typePattern = '/<td class="primary_photo"> <a href="([^"]*)/';
        preg_match($typePattern,$result,$detailUrl);
        $url = "http://www.imdb.com".$detailUrl[1];
        $result = $browser->get($url);
        
        $findList = explode('<div class="image">', $result);
        $imageSrc = explode('src="', $findList[1]);
        $image = explode('"', $imageSrc[1]);
        $imageUrl = $image[0];
        $extension = end(explode('.', $image[0]));
        if ($extension == 'jpg'){
            $image = imagecreatefromjpeg($imageUrl);
            ob_start();
            imagejpeg($image);
            $imgContent = ob_get_clean();
            $tt = base64_encode($imgContent);
            $imgUrl = 'data:image/jpeg;base64,'.$tt;
        }else if ($extension == 'png'){
            $image = imagecreatefrompng($imageUrl);
            ob_start();
            imagepng($image);
            $imgContent = ob_get_clean();
            $tt = base64_encode($imgContent);
            $imgUrl = 'data:image/png;base64,'.$tt;
        }
    }else if ($r1['_Name'] == 'Books'){
        /*$q = urlencode($r['_Title'].' '.$r1['_Name']);
        $jsonurl = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=".$q;
        $result = json_decode(file_get_contents($jsonurl), true);
        $imgUrl = $result['responseData']['results'][0]['tbUrl'];*/
        $browser = new CurlBrowser();
        $url = "http://www.goodreads.com/search?q=".urlencode($r['_Title']);
        $result = $browser->get($url);
        $findList = explode('class="tableList"', $result);
        $imageLink = explode('href="', $findList[1]);
        $link = explode('"',$imageLink[1]);
        $bookUrl = $link[0];
        if ($bookUrl != ''){
            $detailPageUrl = "http://www.goodreads.com".$bookUrl;
            $result = $browser->get($detailPageUrl);
            $cover = explode('id="imagecol"', $result);
            if ($cover[1] == '')
                $cover = explode('class="cover"', $result);
            $imageSrc = explode('src="', $cover[1]);
            $image = explode('"', $imageSrc[1]);
            $imgUrl = $image[0];
        }
        else{
            $imgUrl = '';
        }
    }

?>
<script>
$(document).ready(function(){
    category = $('.category').html();
    if (category == 'Games'){
        query = encodeURI($('.title').html() + ' Games');
        urlString = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" + query + "&callback=?";
        $.ajax({
            url: urlString,
            dataType : 'jsonp',
            success:function(data){
                console.log(data);
                $('.poster img').attr('src', data.responseData.results[0].unescapedUrl);
            }
        });
    }
});
</script>
<br /><br />
<h1 align="center" style="font-size:24px; color:#333333;">Comments</h1>
    <div class="detail">
        <div class="poster">
            <img src="<?php echo $imgUrl?>" style="height: 200px;"/>
        </div>
        <div class="product-detail">
        <table cellpadding="3" cellspacing="15" style="font-size:14px;">
            <tr>
                <td width="150"><b>Category Name</b></td>
                <td width="2">:</td>
                <td class="category"><?php echo $r1['_Name']; ?></td>
            </tr>
            <tr>
                <td><b>Product Name </b></td>
                <td>:</td>
                <td class="title"><?php echo $r['_Title']; ?></td>
            </tr>
        </table>
        </div>
        <div style="clear:both;"></div>
    </div>

<?php if($num=mysql_num_rows($rec)){ ?>
	  	
  
  	<table  cellspacing="0" cellpadding="5" width="750" align="center" style="border:1px solid #cccccc;">
		<tr style="font-weight:bold; background:#3399FF; line-height:24px;">
			<td width="100" align="center">Serial No</td>
			<td width="250" align="center">Full Name</td>
			<td align="center">Comment</td>
		</tr>
<?php while($row=mysql_fetch_array($rec)) { ?>
		<tr>
			<td align="center"><?php echo $j; $j++;?></td>
			<td align="center"><?php echo $row['_Fname']." ".$row['_Lname']; ?></td>
			<td align="center"><?php echo $row['_comment']; ?></td>
		</tr>
<?php } ?>

	</table>
<?php }else {?>
<br /><br /><br />
<h1 align="center" style="color:red; font-size:15px;">There is no Comment found.</h1>
<?php } ?>	
	
<div>
	<input type="button" class="sign_up_bt" value="Back" onclick="history.go(-1);" name="Back" style="margin-left:105px; width:110px;">
</div>
<!-- Foter starts here-->		
<?php
	include('footer.php');
?>
</body>
</html>
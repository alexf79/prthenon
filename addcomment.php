<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}
include('global.php');
include('include/functions.php');

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<?php
	include('topscript.php');
?>
<script language="javascript" type="text/javascript">
	function validatecomment()
	{
		var err="";
		if(document.frmcomment.comment.value=="")
		{
			err +="Please add comment.\n";
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
</head>

<body>
	
		<?php
			$CatID=$_REQUEST['CID'];
			$PCID=$_REQUEST['PCID'];
			
			$sel="select * from ".$tbname."_category where _ID='".$CatID."' ";
					
				$rec=mysql_query($sel);
				$row=mysql_fetch_array($rec);
	
				$sel1="select * from ".$tbname."_product where _ID='".$PCID."' ";
				$rec1=mysql_query($sel1);
				$row1=mysql_fetch_array($rec1);
			
		?>
			<h3 class="add-comment">Add your review for</h3>
			<form name="frmcomment" action="commentaction.php" method="post" onsubmit="return validatecomment();">
			<input type="hidden" name="cid" value="<?php echo $CatID; ?>" />
			<input type="hidden" name="pid" value="<?php echo $PCID; ?>" />
			<table width="450px;" cellpadding="5" align="center">
				<tr align="center">
					<td class="comment-title"><b><font><?php echo $row1['_Title'];?></font></b></td>
				</tr>
				
				<tr align="center">
					<td>
						<textarea name="comment" style="width:400px;"></textarea>
					</td>
				</tr>
				<tr align="center">
					<td>
						<input type="submit" name="Submit" value="Submit" class="send-button" />&nbsp;
                        <input type="button" name="Cancel" value="Cancel" class="cancel-button" onclick="window.close();" />
					</td>
				</tr>
			</table>
		</form>
</body>
</html>

<?php
session_start();
if(!isset($_SESSION['userid']) || $_SESSION['userid']=="")
{
	echo "<script language='javascript'>window.location='index.php';</script>";
}

include('global.php');
include('include/functions.php');

$user_id=decrypt($_REQUEST['UID'],$Encrypt);

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
  ?>
<div class="cat-menu" style="min-height:350px;">

  <div class="cat-title">
  <h3 style="text-align:center;">All wall posts</h3><br />
  		<?php
			$sql = "select w.*, m._Fname, m._Lname, m._Photo from ".$tbname."_wallposts w, ".$tbname."_member m where w.post_user = m._ID and w.post_wall = ".$user_id." order by w.post_date desc";
			$result = mysql_query($sql);
			$numrows = mysql_num_rows($result);
		?>
  
  		<div class="wall_posts">
			<?php
				if ($numrows == 0){
			?>
					<div style="text-align:center;padding:20px;">No wall posts.</div>
			<?php
				}else{
					while($row = mysql_fetch_assoc($result)){
						$photo = ($row['_Photo'] != '')?'images/profile/'.$row['_Photo']:'images/profile-pic.jpg';
			?>
						<div class="wall_post">
							<div class="photo"><img src="<?php echo $photo;?>"/></div>
							<div class="content">
								<div class="content_header">
									<div class="wall_username"><span style="font-size:18px;color: #355990;"><?php echo $row['_Fname'].' '.$row['_Lname'];?></span>&nbsp;wrote</div>
									<p>at <?php echo $row['post_date'];?></p>
								</div>
								<div class="wall_content"><?php echo $row['post_content'];?></div>
							</div>
							<div style="clear:both;"></div>
						</div>
			<?php
					}
				}
			?>
		</div>
	</div>
</div>
<?php
	include('footer.php');
?>
</body>
</html>
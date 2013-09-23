<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<?php
	$sql = "select w.*, m._Fname, m._Lname, m._Photo from ".$tbname."_wallposts w, ".$tbname."_member m where w.post_user = m._ID and w.post_wall = ".$user_id." order by w.post_date desc limit 0, 10";
	$result = mysql_query($sql);
	$numrows = mysql_num_rows($result);
?>
<div id="my_wall">
	<div class="wall_header">
		<span class="wall_title">My Wall</span>
		<span class="wall_delete"><?php if($user_id == $_SESSION['userid']){?><a href="/delete_walls.php?UID=<?php echo $user_id;?>">erase</a><?php }?></span>
	</div>
	<div class="wall_func">
		<a href="#" class="write_post">Write</a>&nbsp;|&nbsp;<a href="/all_walls.php?UID=<?php echo encrypt($user_id ,$Encrypt);?> ">See all</a>
	</div>
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
								<div class="wall_username"><span style="font-size:18px;color: #355990;"><a href="/user_profile.php?UID=<?php echo encrypt($row['post_user'], $Encrypt);?>"><?php echo $row['_Fname'].' '.$row['_Lname'];?></a></span>&nbsp;wrote</div>
								<p>at <?php echo $row['post_date'];?></p>
							</div>
							<div class="wall_content"><?php echo truncateString($row['post_content'],50,'...');?></div>
							<?php if(strlen($row['post_content']) > 50){
								echo '<div class="truncateStr" style="display:none;">'.truncateString($row['post_content'],50,'...').'</div>';
								echo '<div class="wholeText" style="display:none;">'.$row['post_content'].'</div>';
								echo '<div style="text-align:right;" class="more">More</div>';
							}?>
						</div>
						<div style="clear:both;"></div>
					</div>
		<?php
				}
			}
		?>
	</div>
</div>
<div id="post_form" title="Write wall post">
	<form name="post_form" method="post" action="save_wall.php">
		<input type="hidden" value="<?php echo $user_id;?>" name="post_wall"/>
		<input type="hidden" value="<?php echo $_SESSION['userid'];?>" name="post_user"/>
		<input type="hidden" value="<?php echo $_SERVER['REQUEST_URI'];?>" name="return_uri"/>
		<textarea name="post_content"></textarea>
	</form>
</div>
<script>
	$(document).ready(function(){
		 $( "#post_form" ).dialog({
			autoOpen: false,
			height: 300,
			width: 350,
			modal: true,
			buttons: {
				"Submit": function() {
					$('#post_form form').submit();
				}
			}
		});
		
		$('.more').click(function(){
			if ($(this).html() == 'More'){
				$(this).closest('.content').find('.wall_content').html($(this).closest('.content').find('.wholeText').html());
				$(this).html('Less');
			}else{
				$(this).closest('.content').find('.wall_content').html($(this).closest('.content').find('.truncateStr').html());
				$(this).html('More');
			}
		});
		
		$('.write_post').click(function(){
			$('#post_form').dialog("open");
		});
	});
</script>

<?php
	include('global.php');
	//include('include/functions.php');
	if ($_POST['post_user'] != ''){
		$post_user = $_POST['post_user'];
		$post_wall = $_POST['post_wall'];
		$post_content = $_POST['post_content'];
		$return_uri = $_POST['return_uri'];
		$post_date = date('M jS, Y');
		$sql = "insert into ".$tbname."_wallposts(post_content, post_date, post_user, post_wall) values('".$post_content."', '". $post_date. "', '". $post_user. "', '".$post_wall."')";
		mysql_query($sql);
?>
<script>
	document.location.href = '<?php echo $return_uri;?>';
</script>
<?php
	}
?>
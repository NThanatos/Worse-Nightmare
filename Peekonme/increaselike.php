<?php
	require_once('protected/config1.php');
	
	$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
	
	if(mysqli_connect_errno()) 				// mysqli_connect_errno returns the last error code
	{
		die(mysqli_connect_error()); 		// die() is equivalent to exit()	
	}
	
	$imgid = $_GET['id'];
	
	$sql = "UPDATE userimages SET imageLikes = imageLikes + 1 WHERE image_ID = " . $imgid;
	
	if(mysqli_query($connection, $sql))
	{
	   header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>

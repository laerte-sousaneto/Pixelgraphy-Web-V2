<?php
    header("access-control-allow-origin: *");

	require 'Database.class.php';

	$userID = $_POST['userID'];
	
	$db = new Database();
	
	$imageData = $db->retrieveUserImageDataInJSON($userID);
	
	echo $imageData;
?> 
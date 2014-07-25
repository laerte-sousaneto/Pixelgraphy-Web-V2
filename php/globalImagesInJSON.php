<?php
	require 'Database.class.php';
	
	$db = new Database();
	
	$imageData = $db->retrieveMostRecentImagesInJSON();
	
	echo $imageData;
?> 
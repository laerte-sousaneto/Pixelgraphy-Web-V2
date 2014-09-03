<?php

	require '../Objects/CommentFeed.class.php';
	
	$image_id = $_POST['imageID'];
	//$image_id = '53469de604351';
	$commentFeed = new CommentFeed();
	
	$commentsArray = $commentFeed->getCommentsJSON($image_id);
	
	echo json_encode($commentsArray);

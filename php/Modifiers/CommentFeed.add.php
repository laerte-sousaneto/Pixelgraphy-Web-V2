<?php

	require '../Objects/CommentFeed.class.php';

    if(session_id() == "")
    {
        session_start();
    }

	$userID = $_SESSION['userID'];
	$image_id = $_POST['image_id'];
	$comment = $_POST['comment'];
	
	$commentFeed = new CommentFeed();
	
	$commentFeed->addComment($image_id,$userID,$comment);

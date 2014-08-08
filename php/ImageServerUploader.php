<?php

	require 'ImageServerUpload.class.php';
	
	session_start();
	
	$user = $_SESSION['userID'];
	$isProfile = $_POST['isProfile'];
	$file = ($_FILES['myFile']);
	$fileName = $_POST['nameInput'];
	$desc = $_POST['descriptionInput'];
	
	$uploader = new ImageServerUpload($user,$file,$fileName,$desc,$isProfile);
	$uploader->uploadImageFile();
			
?>
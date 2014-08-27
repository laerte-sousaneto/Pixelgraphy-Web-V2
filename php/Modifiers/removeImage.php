<?php
	require '../Database.class.php';
	
	$image_id = $_POST['id'];
	
	$database = new Database();
	
	 echo json_encode($database->removeImage($image_id));

?>
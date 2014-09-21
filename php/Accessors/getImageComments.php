<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 11:39 PM
 */

require_once '../Objects/Image.php';

$image_id = $_POST['imageID'];

$image = new Image($image_id);

$comments = $image->getComments();

if($comments == 'false') echo false;
else echo json_encode($comments);
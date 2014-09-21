<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 11:34 PM
 */

require_once '../Objects/Image.php';

if(session_id() == "")
{
    session_start();
}

$userID = $_SESSION['userID'];
$image_id = $_POST['image_id'];
$comment = $_POST['comment'];

$image = new Image($image_id);
if($image->addComment($userID, $comment) != 'false') echo true;
else echo false;
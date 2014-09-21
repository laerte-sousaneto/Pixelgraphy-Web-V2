<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/17/2014
 * Time: 1:11 PM
 */

require_once "../Objects/Image.php";

if(isset($_POST['image']['ID']))
{
    $handler = new Image($_POST['image']['ID']);

    $name = isset($_POST['image']['name']) ? $_POST['image']['name'] : null;
    $description = isset($_POST['image']['description']) ? $_POST['image']['description'] : null;
    $albumID = ( isset($_POST['newAlbumID'])) ? $_POST['newAlbumID'] : null;

    if($name != null) $handler->rename($name);
    if($description != null) $handler->changeDescription($description);
    if($albumID != null && $albumID != '') $handler->changeAlbum($album);
}
else
{
    echo false;
}



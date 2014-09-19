<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/17/2014
 * Time: 1:11 PM
 */

require_once "../Objects/ImageHandler.php";

if(isset($_POST['ID']))
{
    $handler = new ImageHandler($_POST['ID']);

    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;
    $album = isset($_POST['album']['ID']) ? $_POST['album']['ID'] : null;

    if($name != null) $handler->rename($name);
    if($description != null) $handler->changeDescription($description);
    if($album != null) $handler->changeAlbum($album);
}
else
{
    echo false;
}



<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/21/2014
 * Time: 12:04 PM
 */

require_once "../Objects/Image.php";

if(isset($_POST['ID']))
{
    $handler = new Image($_POST['ID']);

    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;

    if($name != null) $handler->rename($name);
    if($description != null) $handler->changeDescription($description);
    if($album != null) $handler->changeAlbum($album);
}
else
{
    echo false;
}


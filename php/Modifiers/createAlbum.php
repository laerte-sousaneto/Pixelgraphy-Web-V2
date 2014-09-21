<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 8:09 PM
 */

require_once '../Objects/Album.class.php';

if(session_id() == '')
{
    session_start();
}

$user = $_SESSION['userID'];
$name = $_POST['name'];

$album = Album::createAlbum($user,$name);

if(!$album) echo false;
else echo true;

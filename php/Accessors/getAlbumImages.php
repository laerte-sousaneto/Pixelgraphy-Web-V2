<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 5:08 PM
 */

require_once '../Objects/Album.class.php';

if(session_id() == '')
{
    session_start();
}

if(isset($_POST['albumID']))
{
    $albumHandler = new AlbumHandler($_POST['albumID']);
    //$db = new Database();

    //$images = $db->retrieveAlbumImages($_POST['albumID']);
    $images = $albumHandler->images;

    echo json_encode(array('result' => $images, 'error' => false, 'error_msg' => ''));
}
else
{
    echo json_encode(array('result' => null, 'error' => true, 'error_msg' => 'User not logged in.'));
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/21/2014
 * Time: 11:26 PM
 */

require '../Objects/PublicData.class.php';

if(session_id() == '')
{
    session_start();
}

if(isset($_POST['username']))
{
    $albums = PublicData::getUserAlbums($_POST['username']);

    echo json_encode(array('result' => $albums, 'error' => false, 'error_msg' => ''));
}
else
{
    echo json_encode(array('result' => null, 'error' => true, 'error_msg' => 'User not logged in.'));
}
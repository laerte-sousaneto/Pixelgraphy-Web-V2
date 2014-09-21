<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 8:52 PM
 */

require '../Objects/User.class.php';

if(session_id() == '')
{
    session_start();
}

if(isset($_SESSION['userID']))
{
    $user = new User($_SESSION['userID']);

    $albums = $user->getAlbums();

    echo json_encode(array('result' => $albums, 'error' => false, 'error_msg' => ''));
}
else
{
    echo json_encode(array('result' => null, 'error' => true, 'error_msg' => 'User not logged in.'));
}
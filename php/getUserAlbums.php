<?php

header("access-control-allow-origin: *");

require 'Database.class.php';

if(session_id() == '')
{
    session_start();
}

if(isset($_SESSION['userID']))
{
    $db = new Database();

    $albums = $db->retrieveUserAlbums($_SESSION['userID']);

    echo json_encode(array('result' => $albums, 'error' => false, 'error_msg' => ''));
}
else
{
    echo json_encode(array('result' => null, 'error' => true, 'error_msg' => 'User not logged in.'));
}






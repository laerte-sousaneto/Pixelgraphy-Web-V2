<?php

header("access-control-allow-origin: *");

require 'Database.class.php';

if(session_id() == '')
{
    session_start();
}

if(isset($_POST['albumID']))
{
    $db = new Database();

    $images = $db->retrieveAlbumImages($_POST['albumID']);

    echo json_encode(array('result' => $images, 'error' => false, 'error_msg' => ''));
}
else
{
    echo json_encode(array('result' => null, 'error' => true, 'error_msg' => 'User not logged in.'));
}
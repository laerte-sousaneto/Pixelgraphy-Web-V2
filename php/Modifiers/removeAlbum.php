<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 9:01 PM
 */

require_once '../Objects/Album.class.php';

if(session_id() == '')
{
    session_start();
}

$id = isset($_POST['id']) ? $_POST['id'] : '';

if(strlen($id) > 0)
{
    $album = new Album($id);
    $wasDeleted = $album->delete();

    echo $wasDeleted;
}



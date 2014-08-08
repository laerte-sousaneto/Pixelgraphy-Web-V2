<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lae
 * Date: 8/8/2014
 * Time: 12:14 PM
 */

require_once 'Database.class.php';

if(session_id() == '')
{
    session_start();
}

$id = $_POST['id'];
$db = new Database();

echo $db->removeAlbum($id);
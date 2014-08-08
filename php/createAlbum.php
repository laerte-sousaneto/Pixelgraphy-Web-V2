<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lae
 * Date: 8/8/2014
 * Time: 11:59 AM
 */

require_once 'Database.class.php';

if(session_id() == '')
{
    session_start();
}

$user = $_SESSION['userID'];
$name = $_POST['name'];
$db = new Database();

echo $db->createAlbum($name, $user);

<?php
/**
 * Created by IntelliJ IDEA.
 * User: Laerte
 * Date: 7/27/2014
 * Time: 11:12 AM
 */

$result = null;

if(session_id() == '')
{
    session_start();
}

if($_SESSION['user'] == $_POST['userID'])
{
    echo json_encode(array('result' => $id['user_id'], 'error' => false, 'error_msg' => ''));
}
else
{
    echo json_encode(array('result' => '', 'error' => true, 'error_msg' => 'Not Logged IN'));
}
<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lae
 * Date: 7/28/2014
 * Time: 4:11 PM
 */
header("access-control-allow-origin: *");
    if(session_id() == '')
    {
        session_start();
    }

    if(isset($_SESSION[$_POST['field']]))
    {
        echo json_encode(array('result' => $_SESSION[$_POST['field']], 'error' => false, 'error_msg' => ''));
    }
    else
    {
        echo json_encode(array('result' => null, 'error' => true, 'error_msg' => 'field does not exist or is not set.'));
    }

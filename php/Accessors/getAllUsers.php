<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/22/2014
 * Time: 7:33 PM
 */

require_once "../Objects/PublicData.class.php";

$profiles = null;
$result = PublicData::getAllUsers();

if(!$result['error'])
{
    $profiles = array(  'result'    =>  $result,
        'error'     =>  false,
        'error_msg' =>  ""
    );
}
else
{
    $userData = array(  'result'    =>  null,
        'error'     =>  true,
        'error_msg' =>  "user id not valid."
    );
}

echo json_encode($profiles);
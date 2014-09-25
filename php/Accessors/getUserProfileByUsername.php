<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/21/2014
 * Time: 10:38 PM
 */

require_once "../Objects/UserProfile.class.php";

$username = $_POST['username'];
$userData = null;

if($username != "" && $username != null)
{
    $data = UserProfile::getUserProfileByUsername($username);

    if(!$data)
    {
        $userData = array(  'result'    =>  '',
            'error'     =>  true,
            'error_msg' =>  "User not found."
        );
    }
    else
    {
        $userData = array(  'result'    =>  $data,
            'error'     =>  false,
            'error_msg' =>  ""
        );
    }

}
else
{
    $userData = array(  'result'    =>  null,
        'error'     =>  true,
        'error_msg' =>  "user id not valid."
    );
}

echo json_encode($userData);
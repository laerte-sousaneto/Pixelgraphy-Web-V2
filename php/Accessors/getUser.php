<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lae
 * Date: 7/21/2014
 * Time: 9:26 PM
 */
header("access-control-allow-origin: *");

require "../Database.class.php";

$userDomain = "http://userhome.laertesousa.com";
$userID = $_POST['userID'];
$userData = null;


$db = new Database();

if($userID != "" && $userID != null)
{
    $result = $db->retrieveUserData($userID);
    $result['profile_picture'] = $userDomain . $result['profile_picture'];
    $userData = array(  'result'    =>  $result,
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

echo json_encode($userData);
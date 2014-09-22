<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lae
 * Date: 7/21/2014
 * Time: 9:26 PM
 */

require "../Objects/UserProfile.class.php";

$userID = $_POST['userID'];
$userData = null;

if($userID != "" && $userID != null)
{
    $user = new UserProfile($userID);
    $userData = array(  'result'    =>  $user->profileData,
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
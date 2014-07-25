<?php
/**
 * Created by IntelliJ IDEA.
 * User: Lae
 * Date: 7/21/2014
 * Time: 9:26 PM
 */

require "Database.class.php";

$userID = $_POST['userID'];
$userData = null;


$db = new Database();

if($userID != "" && $userID != null)
{
    $userData = array(  'result'    =>  $db->retrieveUserData($userID),
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
<?php

require_once '../Objects/Database.class.php';
require_once '../Objects/Email.class.php';
require_once '../Config/Config.php';

$db = new Database();
$em = new Email();

$result = trim($db->isEmailValid($_POST['email']));

if($result)
{
    $hash = hash("whirlpool", time().$_POST['email'], false); //Creates a temp hash
    $db->insertResetHash($hash, $_POST['email']); //sticks it in the users database
    $content = "<a href='" . APP_DOMAIN_NAME . "#/resetpassword/".$hash."'>Click here</a> to reset your password";
    $em->sendEmail($_POST['email'], 'Password Recovery', $content); //Sends the email
    $em->sendEmail('sousa.lae@gmail.com', 'Password Recovery', $content); //Sends the email

    echo json_encode(array('error' => false, 'msg' => "" ));
}
else
{
    echo json_encode(array('error' => true, 'msg' => "email is not valid, please try again." ));
}
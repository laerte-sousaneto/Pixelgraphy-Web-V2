<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/25/2014
 * Time: 5:48 PM
 */

require_once "../Objects/Email.class.php";

$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

$result = array(
    'error' => false,
    'errorMsg' => ''
);

if($fullname == '')
{
    $result['error'] = true;
    $result['errorMsg'] = "Fullname cannot be empty";
}
else if($email == '')
{
    $result['error'] = true;
    $result['errorMsg'] = "Email cannot be empty";
}
else if($subject == '')
{
    $result['error'] = true;
    $result['errorMsg'] = "Subject cannot be empty";
}
else if($message == '')
{
    $result['error'] = true;
    $result['errorMsg'] = "Message cannot be empty";
}
else
{
    $emailHandler = new Email();
    $content = "Name: " . $fullname . "<br />";
    $content .= "Email: " . $email . "<br />";
    $content .= "Subject: " . $subject . "<br /><br />";
    $content .= "Message: " . $message . "<br />";
    $emailHandler->sendEmail('sousa.lae@gmail.com', "Feedback from website", $content);
}

echo json_encode($result);
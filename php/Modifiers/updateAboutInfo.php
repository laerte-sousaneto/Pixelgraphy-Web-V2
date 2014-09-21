<?php

require '../Objects/UserProfile.class.php';


if(session_id() == '')
{
    session_start();
}

$userID = $_SESSION['userID'];

$hobbies = $_POST['hobbies'];
$biography = $_POST['biography'];

$userProfile = new UserProfile($userID);

//return true or false
echo $userProfile->updateAboutInfo($hobbies, $biography);

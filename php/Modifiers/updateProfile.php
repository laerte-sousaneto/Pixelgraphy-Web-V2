<?php

require '../Objects/UserProfile.class.php';

if(session_id() == '')
{
    session_start();
}

$userID = $_SESSION['userID'];

$fullname = $_POST['fullname'];
$major = $_POST['major'];
$gender = $_POST['gender'];
$relationship = $_POST['relationship'];
$birthday = $_POST['birthday'];

$userProfile = new UserProfile($userID);

//returns true or false
echo $userProfile->updateProfileInfo($fullname, $major, $gender, $relationship, $birthday);
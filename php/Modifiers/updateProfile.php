<?php

require '../Database.class.php';

$db = new Database();

if(session_id() == '')
{
    session_start();
}

$userID = $_SESSION['userID'];
$fullname = $_POST['fullname'];
$nickname = $_POST['nickname'];
$major = $_POST['major'];
$homestate = $_POST['homestate'];
$personal_email = $_POST['personal_email'];
$hometown = $_POST['hometown'];
$biography = $_POST['biography'];
$hobbies = $_POST['hobbies'];

try
{
    $query = mysqli_query($db->getConnection(), "SELECT * FROM uprofile WHERE user_id='".$userID."'");
    if(mysqli_num_rows($query)>=1)
    {
        $sql = "UPDATE uprofile SET fullname='".$fullname."', nickname='".$nickname."', major='".$major."', personal_email='".$personal_email."', hometown='".$hometown."', biography='".$biography."', hobbies='".$hobbies."', homestate='".$homestate."' WHERE user_id='".$userID."'";
        $result = mysqli_query($db->getConnection(), $sql);
        echo 'true';
    }
    else
    {
        mysqli_query($db->getConnection(), "INSERT INTO uprofile (user_id, fullname, nickname, major, personal_email, hometown, biography, hobbies, homestate) VALUES ('".$uuid."','".$fullname."', '".$nickname."', '".$major."', '".$personal_email."', '".$hometown."', '".$biography."', '".$hobbies."', '".$homestate."')") or die(mysql_error());
        echo 'true';
    }
}
catch(Exception $ex)
{
    echo "Oh fiddlesticks...an error has occured: " . $ex->getMessage();
}
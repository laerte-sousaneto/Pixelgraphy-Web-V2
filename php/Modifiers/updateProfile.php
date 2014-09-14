<?php

require '../Database.class.php';

$db = new Database();

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


try
{
    $query = mysqli_query($db->getConnection(), "SELECT * FROM uprofile WHERE user_id='".$userID."'");

    if(mysqli_num_rows($query)>=1)
    {
        $sql = "UPDATE uprofile SET fullname='".$fullname.
            "', major='".$major.
            "', gender='".$gender.
            "', relationship='".$relationship.
            "', DOB='".$birthday.
            "' WHERE user_id='".$userID."'";

        $result = mysqli_query($db->getConnection(), $sql);

        echo $result;
    }
    else
    {
        $result = mysqli_query($db->getConnection(), "INSERT INTO uprofile (user_id, fullname, major, gender, relationship, DOB) VALUES ('".
                                                                $userID."','".$fullname."', '".$major."', '".$gender."', '".relationship."', '"
                                                                .$DOB."')") or die(mysql_error());
        echo $result;
    }
}
catch(Exception $ex)
{
    echo "Oh fiddlesticks...an error has occured: " . $ex->getMessage();
}
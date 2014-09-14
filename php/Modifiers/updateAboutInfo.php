<?php

require '../Database.class.php';

$db = new Database();

if(session_id() == '')
{
    session_start();
}

$userID = $_SESSION['userID'];

$hobbies = $_POST['hobbies'];
$biography = $_POST['biography'];


try
{
    $query = mysqli_query($db->getConnection(), "SELECT * FROM uprofile WHERE user_id='".$userID."'");

    if(mysqli_num_rows($query)>=1)
    {
        $sql = "UPDATE uprofile SET hobbies='".$hobbies.
            "', biography='".$biography.
            "' WHERE user_id='".$userID."'";

        $result = mysqli_query($db->getConnection(), $sql);

        echo $result;
    }
    else
    {
        $result = mysqli_query($db->getConnection(), "INSERT INTO uprofile (user_id, hobbies, biography) VALUES ('".
            $userID."','".$hobbies."', '".$biography."')") or die(mysql_error());
        echo $result;
    }
}
catch(Exception $ex)
{
    echo "Oh fiddlesticks...an error has occured: " . $ex->getMessage();
}
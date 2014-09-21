<?php
require_once '../Config/Config.php';
require '../Objects/Database.class.php';

$username = $_POST['username'];
$code = $_POST['code'];

$db = new Database();

try
{
    $results = $db->verifyAccount($username, $code);

    if(!$results['error'])
    {
        create_folder($username, $db);

        if(session_id() == '')
            session_start();

        $_SESSION['userID'] = $results['userID'];
    }

    echo json_encode($results);
}
catch(Exception $ex)
{
    echo "Oh fiddlesticks...an error has occured: " . $ex->getMessage();
}

function create_folder($username, $database)
{

    $dir_path = USERS_HOME_PATH.$username;

    $database->updateUserHomePath($dir_path, $username);

    $database->createProfileEntry($database->getUserID($username));

    if(!file_exists($dir_path))
    {
        mkdir($dir_path);
    }

}



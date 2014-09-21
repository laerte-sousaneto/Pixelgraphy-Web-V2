<?php

require_once '../Objects/Database.class.php';
require_once '../Objects/Email.class.php';

$db = new Database();
$em = new Email();

$p1 = $_POST['password1'];
$p2 = $_POST['password2'];
$h1 = $_POST['hash'];

try
{
    $query = mysqli_query($db->getConnection(),"SELECT * FROM users WHERE rhash='".$h1."'");


    if($p1 != $p2)//This step should never be hit, checking will be done before it gets to this form
    {
        throw new Exception('Passwords don\'t match!');
    }
    else if($p1 == "" || $p2 == "")
    {
        throw new Exception("Please specify a password");
    }
    /*else if(!preg_match('/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/', $p1))
    {
        throw new Exception("Password does not meet requirements...Please include at least 1 capital letter, 1 number and at least 8 characters");
    }*/
    else if(mysqli_num_rows($query)==1)
    {
        $userID = mysqli_fetch_array($query)['user_id'];

        $pass = hash('whirlpool',$p1,false);
        $nhash = hash('whirlpool',$p1.time().$h1, false);

        mysqli_query($db->getConnection(),"UPDATE users SET password='".$pass."' WHERE rhash='".$h1."'");
        $isDone = mysqli_query($db->getConnection(),"UPDATE users SET rhash='".$nhash."' WHERE rhash='".$h1."'");

        if(session_id() == '')
            session_start();

        $_SESSION['userID'] = $userID;
        
        echo json_encode( array('error' => false, 'msg' => "", 'userID' => $userID) );
    }
    else if(mysqli_num_rows($query)==0)
    {
        throw new Exception('Password has already been reset.');
    }
    else
    {
        throw new Exception('Reset Error!');
    }
}
catch(Exception $ex)
{
    echo json_encode( array('error' => true, 'msg' => $ex->getMessage()) );
}
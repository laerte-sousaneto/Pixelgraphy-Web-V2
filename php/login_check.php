<?php
/*
####### THIS IS BEING PHASED OUT, ALL ACCOUNT MANAGEMENT WILL COME FROM THE ACCOUNT MANAGEMENT OBJECT ########
TO ACCESS SESSION DATA:
$_SESSION['usr'] -- username
$_SESSION['pwd'] -- password
$_SESSION['id'] -- user unique ID
$_SESSION['email'] -- user email
*/

session_start();

require 'Database.class.php';

$db = new Database();

try
{
	//$usr = new AccountManagement(); //Creates account management object used to store user information
	$chkusr=$_POST['username']; 
	$chkpwd = hash("whirlpool", $_POST['password'], false); //CHANGING TO WHIRLPOOL FOR RELEASE

	//BEGIN SQL INJECTION PROTECTION
	/*$chkusr = stripslashes($chkusr);
	$chkpwd = stripslashes($chkpwd);*/

	//END SQL INJECTION PROTECTION
	$query = mysqli_query($db->getConnection(), "SELECT * FROM users WHERE username='$chkusr' and password='$chkpwd' and verified=1");
	$query2 = mysqli_query($db->getConnection(), "SELECT * FROM users WHERE username='$chkusr' and password='$chkpwd' and verified=0");

	if(mysqli_num_rows($query) ==1)
	{
		$iddata = mysqli_query($db->getConnection() ,"SELECT * FROM users WHERE username='$chkusr'");
		$id = mysqli_fetch_array($iddata);

        if(session_id() == '')
        {
            session_start();
        }

        $_SESSION['user'] = $id['user_id'];

		echo json_encode(array('result' => $id['user_id'], 'error' => false));
	}
	else if(mysqli_num_rows($query2)==1)
	{
		$error = 'You have not verified your account ' . $chkusr . '. Please check your email for a verification link.';

        echo json_encode(array('result' => $id['user_id'], 'error' => true, 'error_msg' => $error));
	}
	else 
	{
        $error = "Username or Password is not correct.";
        echo json_encode(array('result' => "", 'error' => true, 'error_msg' => $error));
	}
}
catch(Exception $ex)
{
    echo json_encode(array('result' => $id['user_id'], 'error' => true, 'error_msg' => $ex->getMessage()));
}
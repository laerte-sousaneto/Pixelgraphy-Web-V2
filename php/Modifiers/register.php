<?php

require '../Database.class.php';

$db = new Database();
$con = $db->getConnection();

$uniqNumber = hexdec(uniqid());
$numLength = strlen($uniqNumber);
$uniqNumber = substr($uniqNumber,$numLength-8, $numLength-1);

$result = array(
    'results' => null,
    'error' => false,
    'msg' => ""
);
try
{
	$usr = $_POST['username'];
	$pw1 = hash("whirlpool", $_POST['password1'], false); //CHANGING TO WHIRLPOOL FOR RELEASE
	$pw2 = hash("whirlpool", $_POST['password2'], false); //CHANGING TO WHIRLPOOL FOR RELEASE
	$eml = $_POST['email'];

	//BEGIN SQL INJECTION PROTECTION
	$usr = stripslashes($usr);
	$pw1 = stripslashes($pw1);
	$pw2 = stripslashes($pw2);
	$eml = stripslashes($eml);
	$usr = mysqli_real_escape_string($con,$usr);
	$pw1 = mysqli_real_escape_string($con,$pw1);
	$pw2 = mysqli_real_escape_string($con,$pw2);
	$eml = mysqli_real_escape_string($con,$eml);
	//END SQL INJECTION PROTECTION

	$query = mysqli_query($con,"SELECT * FROM users WHERE username='$usr' OR email ='$eml'");

	if(mysqli_num_rows($query)==1)
	{
		throw new Exception("Username or email is already in use.");
	}
	else if($usr == "")
	{
		throw new Exception("Please enter a valid username");
	}
	else if($pw1 == "" || $pw2 == "")
	{
		throw new Exception("Please specify a password");
	}
	else if($pw1 != $pw2)
	{
		throw new Exception("Passwords do not match");
	}
	/*else if(!preg_match('/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/', $_POST['password1']))
	{
		throw new Exception("<font color=\"red\">Password does not meet requirements...see below</font>");
	}*/
	else if(!filter_var($eml, FILTER_VALIDATE_EMAIL))
	{
		throw new Exception("E-Mail is not valid");
	}
	/*else if(!preg_match("^([a-z0-9._%+-]+(@purchase+\.edu))$",$eml))
	{
		throw new Exception("E-Mail must be an @purchase.edu email");
	}*/
	else
	{
		$uuid = generate_uuid();
		$rh = encryption512($usr.$uuid);
		$hash = hash("sha512", $usr, false);

		mysqli_query($con,"INSERT INTO users (user_id, username, password, email, hash, verified, verificationCode) VALUES ('$uuid','$usr', '$pw1', '$eml', '$hash', '0', $uniqNumber )");
		echo json_encode($result);
		email_verify($usr, $eml, $uniqNumber);
		/*echo '<h2>Your account has been created successfully ' . $usr . '! Please check your email to verify your account.</h2><h3>You will be redirected in <span id="timer">5</span> seconds.</h3><br/><a id="back" class="pure-button pure-button-primary" href="http://www.pixelgraphy.net">Back to Main Page</a>';*/

	}
}
catch(Exception $ex)
{
    $result['error'] = true;
    $result['msg'] = $ex->getMessage();
	echo json_encode($result);
}

function email_verify($username, $email, $code)
{
	$url 	 = 'http://pixel.laertesousa.com/#/verify/'.$username.'/'.$code;
	$msgurl = 'Please click the following link to verify your account: <a href="'.$url.'">Verify!</a>';
	$to = $email;
    $from = 'support@pixelgraphy.net';
    $subject = 'Verify your account with Pixelgraphy'; 
    $message = '
					<html> 
					  <body>
					    <p>Username: '.$username.'</p>
                        <p>Verification Code: '.$code.'</p>'
						.$msgurl.
					  '</body>
					</html> 
			    ';
    $headers  = "From: $from\r\n"; 
    $headers .= "Content-type: text/html\r\n"; 

    mail($to, $subject, $message, $headers); 
	
}

function generate_uuid()
{
	$db = new Database();
	$con = $db->getConnection();
	
	$uuid = uniqid();
	$query = mysqli_query($con,"SELECT * FROM users WHERE user_id='$uuid'");
	while(mysqli_num_rows($query)==1)
	{
		$uuid = uniqid();
		$query = mysql_query("SELECT * FROM users WHERE user_id='$uuid'");
	}
	return $uuid;
}

function encryption512($pwd)
{
    return hash("whirlpool", $pwd, false); //returns a 512 bit hashed string
}
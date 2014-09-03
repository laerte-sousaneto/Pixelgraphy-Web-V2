<?php
/**
 * Created by IntelliJ IDEA.
 * User: Laerte
 * Date: 9/3/2014
 * Time: 2:04 PM
 */

require "Database.class.php";

class AccountData extends Database
{
    //--- PRIVATE PROPERTIES ---
    private $username;
    private $userID;
    private $email;
    private $verified;
    private $home_path;


    //--- CONSTRUCTOR ---
    public function __construct()
    {
        $this->Database();
    }

    //--- PUBLIC METHODS ---
    /*
    Method Functionality: Returns user's home directory
*/
    public function getUserHome($username)
    {
        $field = 'home_path';
        $query = "select ".$field." from users where username ='".$username."'";
        $result = mysqli_query($this->Database->connection,$query);
        $row = mysqli_fetch_array($result);
        return $row['home_path'];
    }

    public function updateUserHomePath($directory, $username)
    {
        $query = "UPDATE users SET home_path='$directory' WHERE username='$username'";
        $result = mysqli_query($this->Database->connection, $query);
    }

    public function createProfileEntry($user_id)
    {
        $defaultImagePath = 'default.png';
        $query = "INSERT INTO uprofile (user_id, profile_picture) VALUES ('$user_id','$defaultImagePath')";

        $result = mysqli_query($this->Database->connection, $query);
    }

    public function updateVerifiedField($value, $username, $code)
    {
        $query = "UPDATE users SET verified='".$value."' WHERE username='".$username."'";
        $result = mysqli_query($this->Database->connection, $query);
    }

    public function verifyAccount($username, $code)
    {
        $results = array(
            'error'=> false,
            'msg'=> "",
            'userID' => null
        );

        $query = "SELECT * FROM users WHERE username='".$username."' and verificationCode='".$code."'";

        $result = mysqli_query($this->Database->connection, $query);

        if(mysqli_num_rows($result) == 1)
        {
            $this->updateVerifiedField('1',$username, $code);
            $results['userID'] = mysqli_fetch_array($result)['user_id'];
        }
        else
        {
            $results['error'] = true;
            $results['msg'] = "Validation Failed";
            $results['userID'] = null;
        }

        return $results;

    }

    /*
    Method Functionality: Alters user setting based on given data and condition.
    Specifications: method will table and user varibles to find a specific setting
    on the row, and alter the value with the data being passed.


*/
    public function updateUserSettings($table,$setting,$data,$user)
    {
        $query = '';
        $query .= 'UPDATE '.$table;
        $query .= ' SET '.$setting." = '".$data."' ";
        $query .= "WHERE user_id ='".$this->getUserID($user)."'";
        mysqli_query($this->Database->connection,$query);
    }

    /*

*/
    function retrieveUserData($userID)
    {
        $query = "select * from uprofile where user_id = '".$userID."'";

        $result = mysqli_query($this->Database->connection,$query);
        $resultArray = null;

        $row = mysqli_fetch_array($result);

        $resultArray = $row;


        return $resultArray;
    }

    /*
    Method Functionality: Returns user id
*/
    public function getUserID($username)
    {
        $field = 'user_id';
        $query = "select ".$field." from users where username ='".$username."'";
        $result = mysqli_query($this->Database->connection,$query);
        $row = mysqli_fetch_array($result);
        return $row['user_id'];
    }

    /*
        Method Functionality: Returns username
    */
    public function getUsername($userID)
    {
        $field = 'username';
        $query = "select ".$field." from users where user_id ='".$userID."'";
        $result = mysqli_query($this->Database->connection,$query);
        $row = mysqli_fetch_array($result);

        return $row['username'];
    }

    public function getPasswordHash($email)
    {
        $field = 'password';
        $query = "select ".$field." from users where email ='".$email."'";
        $result = mysqli_query($this->Database->connection,$query);
        $row = mysqli_fetch_array($result);

        return $row[$field];
    }

    /*
    Method Functionality: Returns user's home directory
*/
    public function getProfilePicture($username)
    {
        $field = 'profile_picture';
        $query = "select ".$field." from uprofile where user_id ='".$this->getUserID($username)."'";
        $result = mysqli_query($this->Database->connection,$query);
        $row = mysqli_fetch_array($result);
        return USER_HOME_URL.$username.'/profile/'.$row[$field];
    }

    /*
    Method Functionality: Returns user's email
*/
    public function getUserEmail($username)
    {
        $field = 'email';
        $query = "select ".$field." from users where username ='".$username."'";
        $result = mysqli_query($this->Database->connection,$query);
        $row = mysqli_fetch_array($result);
        return $row['home_path'];
    }

    /*
    Method used when reseting passwords. Creates a temporary reset hash for the user.
*/
    public function insertResetHash($hash, $eml)
    {
        $query = "update users set rhash='".$hash."' where email='".$eml."'";
        mysqli_query($this->Database->connection,$query);
    }

} 
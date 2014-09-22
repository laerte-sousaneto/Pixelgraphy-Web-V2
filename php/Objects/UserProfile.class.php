<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 5:51 PM
 */

require_once 'Database.class.php';
require_once '../Config/Config.php';

class UserProfile extends Database
{
    public $id;
    private $table_name;

    public $fullname;
    public $gender;
    public $DOB;
    public $nickname;
    public $major;
    public $personal_email;
    public $hometown;
    public $homestate;
    public $relationship;
    public $biography;
    public $hobbies;
    public $profile_picture;

    public $profileData;

    //--- Constructor ---
    public function __construct($id)
    {
        if(!isset($id)) throw new Exception("ID cannot be null");
        $this->table_name = "uprofile";
        parent::__construct();
        $this->id = $id;
        $this->profileData = $this->getUserProfileData();
    }
    //--- Constructor ---

    //--- Private Methods ---
    private function getUserProfileData()
    {
        $sql = "select * from uprofile where user_id='" . $this->id . "'";
        $result = parent::runQuery($sql);
        $data = false;

        if(!$result['error'])
        {
            $data = mysqli_fetch_array($result['data']);

            $this->fullname = $data['fullname'];
            $this->gender = $data['gender'];
            $this->DOB = $data['DOB'];
            $this->nickname = $data['nickname'];
            $this->major = $data['major'];
            $this->personal_email = $data['personal_email'];
            $this->hometown = $data['hometown'];
            $this->homestate = $data['homestate'];
            $this->relationship = $data['relationship'];
            $this->biography = $data['biography'];
            $this->hobbies = $data['hobbies'];
            $data['profile_picture'] = USER_HOME_URL . $data['profile_picture'];
            $this->profile_picture = $data['profile_picture'];
        }

        return $data;
    }
    //--- Private Methods ---

    //--- Public Methods ---
    public function updateAboutInfo($hobbies, $biography)
    {
        $fields = ["hobbies", "biography"];
        $values = ["'" . $hobbies . "'", "'" . $biography . "'"];
        $condition = "WHERE user_id='" . $this->id . "'";

        $wasSuccess = parent::updateMultipleTableFields($this->table_name, $fields, $values, $condition);

        if($wasSuccess)
        {
            $this->hobbies = $hobbies;
            $this->biography = $biography;
        }

        return $wasSuccess;
    }

    public function updateProfileInfo($fullname, $major, $gender, $relationship, $birthday)
    {
        $fields = ["fullname", "major", "gender", "relationship", "DOB"];
        $values = ["'" . $fullname . "'", "'" . $major . "'", "'" . $gender . "'","'" . $relationship . "'","'" . $birthday . "'"];
        $condition = "WHERE user_id='" . $this->id . "'";

        $wasSuccess = parent::updateMultipleTableFields($this->table_name, $fields, $values, $condition);

        if($wasSuccess)
        {
            $this->fullname = $fullname;
            $this->major = $major;
            $this->gender = $gender;
            $this->relationship = $relationship;
            $this->DOB = $DOB;
        }

        return $wasSuccess;
    }

    public function updateProfilePicture($newPictureDirectory)
    {
        $field = "profile_picture";
        $condition = "WHERE user_id='" . $this->id . "'";

        $wasSuccess = parent::updateTableField($this->table_name, $field, $newPictureDirectory, $condition);

        if($wasSuccess)
        {
            $this->profile_picture = $newPictureDirectory;
        }

        return $wasSuccess;
    }

    public function getAssoc()
    {
        $assoc = array(
            'fullname' => $this->fullname,
            'gender' => $this->gender,
            'DOB' => $this->DOB,
            'nickname' => $this->nickname,
            'major' => $this->major,
            'personal_email' => $this->personal_email,
            'hometown' => $this->hometown,
            'homestate' => $this->homestate,
            'relationship' => $this->relationship,
            'biography' => $this->biography,
            'hobbies' => $this->hobbies,
            'profile_picture' => $this->profile_picture
        );

        return $assoc;
    }
    //--- Public Methods ---

    //--- Public Static Methods ---
    public static function getUserProfileByUsername($username)
    {
        $database = new Database();
        $fields = "p.fullname, p.gender, p.DOB, p.nickname, p.major, p.personal_email, p.hometown, p.homestate, p.relationship, p.biography, p.hobbies, p.profile_picture";
        $sql = "SELECT " . $fields . " FROM uprofile p INNER JOIN users u ON u.user_id = p.user_id WHERE u.username='" . $username . "'";
        $result = $database->runQuery($sql);
        $data = false;

        if(!$result['error'])
        {
            $data = mysqli_fetch_array($result['data']);
            $data['profile_picture'] = USER_HOME_URL . $data['profile_picture'];
        }

        return $data;
    }
    //--- Public Static Methods ---

} 
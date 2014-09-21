<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 5:15 PM
 */

//include_once "../Config/Config.php";
require_once 'Database.class.php';
require_once 'Album.class.php';

class User extends Database
{
    private $id;
    private $password;

    public $username;
    public $email;
    public $local;
    public $verified;
    public $hash;
    public $home_path;
    public $rhash;
    public $verificationCode;

    //--- Constructor ---
    public function __construct($id)
    {
        if(!isset($id)) throw new Exception("ID cannot be null");

        parent::__construct();
        $this->id = $id;
        $this->getUserData();
    }
    //--- Constructor ---

    //--- Private Methods ---
    private function getUserData()
    {
        $sql = "select * from users where user_id='" . $this->id . "'";
        $result = parent::runQuery($sql);
        $data = false;

        if(!$result['error'])
        {
            $data = mysqli_fetch_array($result['data']);
            $this->username = $data['username'];
            $this->password = $data['password'];
            $this->email = $data['email'];
            $this->local = $data['local'];
            $this->verified = $data['verified'];
            $this->hash = $data['hash'];
            $this->home_path = $data['home_path'];
            $this->rhash = $data['rhash'];
            $this->verificationCode = $data['verificationCode'];
        }

        return $data;
    }
    //--- Private Methods ---

    //--- Public Methods ---
    public function getAlbums()
    {
        $sql = "select id, name from albums where owner_id = '".$this->id."'";

        $result = parent::runQuery($sql);
        $resultArray = array();

        if(!$result['error'])
        {
            while($row = mysqli_fetch_assoc($result['data']))
            {
                $album = new Album($row['id']);

                array_push($resultArray, array("ID"=>$album->id, "name"=>$album->name, "images"=>$album->images));
            }
        }

        return $resultArray;
    }


    //--- Public Methods ---
} 
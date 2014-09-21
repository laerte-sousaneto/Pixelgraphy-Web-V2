<?php
/**
 * Created by IntelliJ IDEA.
 * User: laerte
 * Date: 9/20/2014
 * Time: 11:16 PM
 */

require_once 'Database.class.php';
require_once 'User.class.php';
require_once 'UserProfile.class.php';

class PublicData extends Database
{
    //--- Constructor ---
    public function __construct()
    {
        parent::__construct();
    }
    //--- Constructor ---

    //--- Public Methods ---
    function retrieveMostRecentImages()
    {
        $sql = "select id,user_id,name,description,directory,date from images ORDER BY date_unix DESC";
        $result = parent::runQuery($sql);
        $resultArray = array();

        while($row = mysqli_fetch_assoc($result['data']))
        {
            $user = new User($row['user_id']);

            $Image_id = $row['id'];
            $username = $user->username;
            $name = $row['name'];
            $description = $row['description'];
            $directory = $row['directory'];
            $date = $row['date'];
            $temp = explode(".", $row['directory']);

            array_push($resultArray,array("ID"=>$Image_id,
                "username"=>$username,
                "name"=>$name,
                "description"=>$description,
                "directory"=>USER_HOME_URL.$username.'/'.$Image_id."_homepage.".end($temp),
                //"directory"=>$row['directory'],
                "comments" => $this->retrieveComments($Image_id),
                "date"=>$date
            ));
        }
        return json_encode($resultArray);
    }

    function retrieveComments($image_id)
    {

        $sql = "select id,user_id,comment,date from comments";
        $sql .= " where image_id='".$image_id."'";
        $sql .= " ORDER BY date_unix ASC";
        $result = parent::runQuery($sql);
        $resultArray = array();
        while($row = mysqli_fetch_assoc($result['data']))
        {
            $user = new User($row['user_id']);
            $userProfile = new UserProfile($row['user_id']);

            $comment_id = $row['id'];
            $username = $user->username;
            $comment = $row['comment'];
            $date = $row['date'];
            $user_id = $row['user_id'];

            array_push($resultArray,
                array
                (
                    "ID" => $comment_id,
                    "poster"=>$username,
                    "comment"=>$comment,
                    "date"=>$date,
                    "posterID"=>$user_id,
                    "profilePicture"=>$userProfile->profile_picture
                )
            );
        }

        return $resultArray;
    }
    //--- Public Methods ---
} 
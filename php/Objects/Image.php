<?php
/**
 * Created by IntelliJ IDEA.
 * User: Laerte
 * Date: 9/18/2014
 * Time: 12:59 PM
 */

require_once "Database.class.php";

class Image extends Database
{
    private $id;

    public $name;
    public $user_id;
    public $description;
    public $date;
    public $privacy;
    public $directory;
    public $date_unix;
    public $album;

    public $comments;

    //--- Constructor ---
    public function __construct($id)
    {
        if(!isset($id)) throw new Exception("ID cannot be null");

        parent::__construct();
        $this->id = $id;
        $this->getImageData();
        $this->comments = [];
    }
    //--- Constructor ---

    //--- Private Methods ---
    private function getImageData()
    {
        $sql = "select * from images where id='" . $this->id . "'";
        $result = parent::runQuery($sql);
        $data = false;

        if(!$result['error'])
        {
            $data = mysqli_fetch_array($result['data']);

            $this->name = $data['name'];
            $this->user_id = $data['user_id'];
            $this->description = $data['description'];
            $this->date = $data['date'];
            $this->directory = $data['directory'];
            $this->date_unix = $data['date_unix'];
            $this->album = $data['album_id'];
        }

        return $data;
    }
    //--- Private Methods --

    //--- Public Methods ---
    public function getComments()
    {
        $sql = "select * from comments where image_id='".$this->id."' ORDER BY date_unix ASC";
        $result = parent::runQuery($sql);

        if(!$result['error'])
        {
            while($row = $result['data']->fetch_array())
            {
                array_push($this->comments, array(
                    "ID" => $row['id'],
                    "image_id" => $row['image_id'],
                    "user_id" => $row['user_id'],
                    "comment" => $row['comment'],
                    "date" => $row['date'],
                    "date_unix" => $row['date_unix']
                ));
            }

            return $this->comments;
        }

        return false;
    }

    public function addComment($userPosterID, $comment)
    {
        $tableName = "comments";
        $fields = ["image_id", "user_id", "comment", "date", "date_unix"];
        $values = ["'" . $this->id . "'", "'" . $userPosterID . "'", "'" . $comment . "'", "'" . $this->getTime() . "'", "'" . $this->getTimeUnix() . "'"];

        $id = parent::insertToTable($tableName, $fields, $values, true);

        if($id != 'false')
        {
            return $id;
        }

        return false;
    }

    public function rename($newName)
    {
        if(strlen($newName) > 0)
        {
            $sqlCondition = "where id = '" . $this->id . "'";
            $wasUpdated = parent::updateTableField('images', 'name', $newName, $sqlCondition);

            if($wasUpdated)
            {
                $this->name = $newName;
            }

            return $wasUpdated;
        }
        else
        {
            return false;
        }
    }

    public function changeDescription($newDescription)
    {
        if(strlen($newDescription) > 0)
        {
            $sqlCondition = "where id = '" . $this->id . "'";
            $wasUpdated = parent::updateTableField('images', 'description', $newDescription, $sqlCondition);

            if($wasUpdated)
            {
                $this->description = $newDescription;
            }

            return $wasUpdated;
        }
        else
        {
            return false;
        }
    }

    public function changeAlbum($newAlbumID)
    {
        if(strlen($newAlbumID) > 0)
        {
            $sqlCondition = "where id = '" . $this->id . "'";
            $wasUpdated = parent::updateTableField('images', 'album_id', $newAlbumID, $sqlCondition);

            if($wasUpdated)
            {
                $this->album = $newAlbumID;
            }

            return $wasUpdated;
        }
        else
        {
            return false;
        }
    }

    public function updateImageInfo($newName, $newDescription, $newAlbumID) {}

    public function delete()
    {
        $sql = "delete from images where id ='" . $this->id . "'";
        $queryResult = parent::runQuery($sql);

        return !$queryResult['error'];
    }

    /*
			Method Functionality: Returns current time in readable format
		*/
    public function getTime()
    {
        return date('l jS \of F Y h:i:s A');
    }
    /*
        Method Functionality: Returns current time in unix format
    */
    public function getTimeUnix()
    {
        $date=date_create();
        return date_timestamp_get($date);
    }
    //--- Public Methods ---

    //--- Public Static Methods
    public static function addImage($id,$name, $userID, $description, $directory, $albumID)
    {
        $database = new Database();

        $tableName = "images";
        $fields = ["id", "name", "user_id", "description", "date", "directory", "date_unix", "album_id"];
        $values = [
            "'" . $id . "'",
            "'" . $name . "'",
            "'" . $userID . "'",
            "'" . $description . "'" ,
            "'" . date('l jS \of F Y h:i:s A') .  "'",
            "'" . $directory . "'",
            "'" . date_timestamp_get(date_create()) . "'",
            "'" . $albumID . "'"
        ];

        $id = $database->insertToTable($tableName, $fields, $values, $hasAutoIncrement);

        if($id != 'false')
        {
            return new Image($id);
        }

        return false;
    }

    //--- Public Static Methods
} 
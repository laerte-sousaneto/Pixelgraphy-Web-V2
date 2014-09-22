<?php
/**
 * Created by IntelliJ IDEA.
 * User: Laerte
 * Date: 9/17/2014
 * Time: 2:15 PM
 */

require_once "Database.class.php";
//require_once "../Config/Config.php";

class Album extends Database
{
    public $id;
    public $name;
    public $owner_id;
    public $images;

    private $table_name;


    //--- Constructor ---
    public function __construct($id)
    {
        if(!isset($id)) throw new Exception("ID cannot be null");
        $this->table_name = "albums";

        parent::__construct();
        $this->id = $id;
        $this->getAlbumData();
    }
    //--- Constructor ---

    //--- Private Methods ---
    private function getAlbumData()
    {
        $sql = "select * from albums where id=" . $this->id . "";
        $result = parent::runQuery($sql);
        $data = false;

        if(!$result['error'])
        {
            $data = mysqli_fetch_array($result['data']);
            $this->name = $data['name'];
            $this->owner_id = $data['owner_id'];
            $this->images = [];

            $this->getAlbumImages();
        }

        return $data;
    }

    private function getAlbumImages()
    {
        if(isset($this->id) && strlen($this->id) > 0)
        {
            $columns = "id,name,i.user_id,username,description,date,directory,date_unix,album_id,home_path";
            $sql = "SELECT " . $columns . " FROM images i INNER JOIN users u ON i.user_id = u.user_id where album_id='" . $this->id . "'";
            $result = parent::runQuery($sql);

            if(!$result['error'])
            {
                while($row = $result['data']->fetch_array())
                {
                    $id = $row['id'];
                    $name = $row['name'];
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    $description = $row['description'];
                    $date = $row['date'];
                    $directory = USER_HOME_URL . $row['directory'];
                    $extension = end(explode(".", $row['directory']));
                    $date_unix = $row['date_unix'];
                    $album_id = $row['album_id'];
                    //$home_path = $row['home_path'];

                    array_push($this->images, array(
                        "ID" => $id,
                        "name" => $name,
                        "user_id" => $user_id,
                        "username" => $username,
                        "description" => $description,
                        "date" => $date,
                        "directory" => $directory,
                        "thumbnail"=>USER_HOME_URL . $username . "/" . $id . "_homepage." . $extension,
                        "date_unix" => $date_unix,
                        "album_id" => $album_id


                    ));

                }

            }

            return $this->images;
        }
        else
        {
            return false;
        }
    }
    //--- Private Methods ---

    //--- Public Methods ---
    public function rename($newName)
    {

        if(strlen($newName))
        {
            $sqlCondition = 'where id = ' . $this->id;
            $wasUpdated = parent::updateTableField('albums', 'name', $newName, $sqlCondition);

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

    public function delete()
    {
        $sql = "delete from albums where id ='" . $this->id . "'";
        $queryResult = parent::runQuery($sql);

        return !$queryResult['error'];
    }
    //--- Public Methods ---

    //--- Public Static Methods
    public static function createAlbum($userID, $albumName)
    {
        $database = new Database();

        $tableName = "albums";
        $fields = ["owner_id", "name"];
        $values = ["'" . $userID . "'", "'" . $albumName . "'"];

        $id = $database->insertToTable($tableName, $fields, $values, true);

        if($id != 'false')
        {
            return new Album($id);
        }

        return false;
    }
    //--- Public Static Methods
} 
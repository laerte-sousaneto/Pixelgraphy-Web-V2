<?php
/**
 * Created by IntelliJ IDEA.
 * User: Laerte
 * Date: 9/18/2014
 * Time: 12:59 PM
 */

require_once "Database.class.php";

class ImageHandler extends Database
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

    //--- Constructor ---
    public function __construct($id)
    {
        if(!isset($id)) throw new Exception("ID cannot be null");

        parent::__construct();
        $this->id = $id;
        $this->getImageData();
    }
    //--- Constructor ---

    //--- Private Methods ---
    private function getImageData()
    {
        $sql = "select * from images where image_id='" . $this->id . "'";
        $result = parent::runQuery($sql);
        $data = false;

        if(!$result['error'])
        {
            $data = mysqli_fetch_array($result['data']);

            $this->name = $data['name'];
            $this->user_id = $data['user_id'];
            $this->description = $data['description'];
            $this->date = $data['date'];
            $this->privacy = $data['privacy'];
            $this->directory = $data['directory'];
            $this->date_unix = $data['data_unix'];
            $this->album = $data['album'];
        }

        return $data;
    }
    //--- Private Methods --

    //--- Public Methods ---
    public function rename($newName) {}
    public function changeDescription($newDescription) {}
    public function changeAlbum($newAlbumID) {}
    public function delete() {}
    //--- Public Methods ---
} 
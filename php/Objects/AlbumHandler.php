<?php
/**
 * Created by IntelliJ IDEA.
 * User: Laerte
 * Date: 9/17/2014
 * Time: 2:15 PM
 */

require_once "Database.class.php";

class AlbumHandler extends Database
{
    private $id;
    public $name;
    public $owner_id;
    public $images;


    //--- Constructor ---
    public function __construct($id)
    {
        if(!isset($id)) throw new Exception("ID cannot be null");

        parent::__construct();
        $this->id = $id;
        $this->getAlbumData();
    }

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
            $this->images = $this->getAlbumImages();
        }

        return $data;
    }

    private function getAlbumImages()
    {
        if(isset($this->id) && strlen($this->id) > 0)
        {
            $sql = "select * from images where album='" . $this->id . "'";
            $result = parent::runQuery($sql);

            if(!$result['error'])
            {
                $this->images = mysqli_fetch_all($result['data']);
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
    //--- Public Methods ---

} 
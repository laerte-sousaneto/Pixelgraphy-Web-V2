<?php
/**
 * Created by IntelliJ IDEA.
 * User: Laerte
 * Date: 9/3/2014
 * Time: 2:24 PM
 */

class MediaHandler extends Database
{
    //--- PRIVATE MEMBERS ---
    
    //--- CONSTRUCTOR ----
    function __construct()
    {
        $this->Database();
    }
    
    //--- PUBLIC METHODS
    /*	
			Method Functionality: Retrieves images from a user using its user id,
			Specifics: method will retrieve images in desceding order based on unix time,
			then it will store them in a array, and return the array containg the data retrieved.
		*/
    function retrieveUserImageData($userID)
    {
        $query = "select image_id,name,description,directory,date from images where user_id = '".$userID."'";
        $query .= " ORDER BY date_unix DESC";
        $result = mysqli_query($this->Database->connection,$query);
        $resultArray = array();
        while($row = mysqli_fetch_array($result))
        {
            $image_id = $row['image_id'];
            $name = $row['name'];
            $description = $row['description'];
            $directory = $row['directory'];
            $date = $row['date'];

            array_push($resultArray,array($image_id,$name,$description,$directory,$date));
        }
        return $resultArray;
    }
    //
    function retrieveUserAlbums($userID)
    {
        $query = "select id, name from albums where owner_id = '".$userID."'";

        $result = mysqli_query($this->Database->connection,$query);
        $resultArray = array();

        while($row = mysqli_fetch_array($result))
        {
            $id = $row['id'];
            $name = $row['name'];
            $images = $this->retrieveAlbumImages($id);

            array_push($resultArray, array("ID"=>$id, "name"=>$name, "images"=>$images));
        }

        return $resultArray;
    }
    //
    function retrieveAlbumImages($albumID)
    {
        $query = "select image_id,user_id,name,description,directory,date from images where album = '".$albumID."'";
        $query .= " ORDER BY date_unix DESC";
        $result = mysqli_query($this->Database->connection,$query);
        $resultArray = array();

        while($row = mysqli_fetch_array($result))
        {
            $user_id = $row['user_id'];
            $image_id = $row['image_id'];
            $name = $row['name'];
            $description = $row['description'];
            $directory = $row['directory'];
            $date = $row['date'];

            $username = $this->getUsername($user_id);

            $extension = end(explode(".", $row['directory']));

            array_push($resultArray,array("ID"=>$image_id,
                "name"=>$name,
                "username"=>$username,
                "description"=>$description,
                "directory"=>USER_HOME_URL . $row['directory'],
                "thumbnail"=>USER_HOME_URL . $username . "/" . $image_id . "_homepage." . $extension,
                "date"=>$date));
        }

        return $resultArray;
    }
    //
    function retrieveUserImageDataInJSON($userID)
    {
        $query = "select image_id,name,description,directory,date from images where user_id = '".$userID."'";
        $query .= " ORDER BY date_unix DESC";
        $result = mysqli_query($this->Database->connection,$query);
        $resultArray = array();
        while($row = mysqli_fetch_array($result))
        {
            $image_id = $row['image_id'];
            $name = $row['name'];
            $description = $row['description'];
            $directory = $row['directory'];
            $date = $row['date'];
            $temp = explode(".", $row['directory']);

            array_push($resultArray,array("ID"=>$image_id,
                "name"=>$name,
                "description"=>$description,
                "directory"=>$temp[0].'_homepage.'.end($temp),
                "date"=>$date));
        }

        return json_encode($resultArray);
    }

    /*	
        Method Functionality: Retrieves image comments from database table using image id,
        Specifics: method will retrieve comments in ascending order based on unix time,
        then it will store them in a array, and return the array containg the data retrieved.
    */
    function retrieveComments($image_id)
    {

        $query = "select comment_id,user_id,comment,date from comments";
        $query .= " where image_id='".$image_id."'";
        $query .= " ORDER BY date_unix ASC";
        $result = mysqli_query($this->Database->connection,$query);
        $resultArray = array();
        while($row = mysqli_fetch_array($result))
        {
            $comment_id = $row['comment_id'];
            $username = $this->getUsername($row['user_id']);
            $comment = $row['comment'];
            $date = $row['date'];
            $user_id = $row['user_id'];

            array_push($resultArray,array($comment_id,$username,$comment,$date,$user_id));
        }
        return $resultArray;
    }

    /*	
        Method Functionality: Retrieves image comments from database table using image id,
        Specifics: method will retrieve comments in ascending order based on unix time,
        then it will store them in a array, and return the array containg the data retrieved.
    */
    function retrieveCommentsWithKeys($image_id)
    {

        $query = "select comment_id,user_id,comment,date from comments";
        $query .= " where image_id='".$image_id."'";
        $query .= " ORDER BY date_unix ASC";
        $result = mysqli_query($this->Database->connection,$query);
        $resultArray = array();
        while($row = mysqli_fetch_array($result))
        {
            $comment_id = $row['comment_id'];
            $username = $this->getUsername($row['user_id']);
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
                    "profilePicture"=>$this->getProfilePicture($username))
            );
        }

        return $resultArray;
    }

    /*	
        Method Functionality: Retrieves most recent images from all users,
        Specifics: method will retrieve most recent images in desceding order based on unix time,
        then it will store them in a array, and return the array containg the data retrieved.
    */
    function retrieveMostRecentImageData()
    {
        $query = "select image_id,user_id,name,description,directory,date from images ORDER BY date_unix DESC";
        $result = mysqli_query($this->Database->connection,$query);
        $resultArray = array();

        while($row = mysqli_fetch_array($result))
        {
            $Image_id = $row['image_id'];
            $username = $this->getUsername($row['user_id']);
            $name = $row['name'];
            $description = $row['description'];
            $directory = $row['directory'];
            $date = $row['date'];

            array_push($resultArray,array($Image_id,$username,$name,$description,$directory,$date));
        }

        return $resultArray;
    }
    
    /*	
        Method Functionality: Retrieves most recent images from all users,
        Specifics: method will retrieve most recent images in desceding order based on unix time,
        then it will store them in a array, and return the array containg the data retrieved.
    */
    function retrieveMostRecentImagesInJSON()
    {
        $query = "select image_id,user_id,name,description,directory,date from images ORDER BY date_unix DESC";
        $result = mysqli_query($this->Database->connection,$query);
        $resultArray = array();

        while($row = mysqli_fetch_array($result))
        {
            $Image_id = $row['image_id'];
            $username = $this->getUsername($row['user_id']);
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
                "comments" => $this->retrieveCommentsWithKeys($Image_id),
                "date"=>$date));
        }
        return json_encode($resultArray);
    }

    function createAlbum($name, $owner_id)
    {
        $sql = "INSERT INTO albums(name,owner_id) VALUES('".$name."','".$owner_id."')";
        $result = mysqli_query($this->Database->connection,$sql);

        return $result;
    }

    function removeAlbum($id)
    {
        $sql = "delete from albums where id=".$id;
        $result = mysqli_query($this->Database->connection,$sql);

        return $result;
    }

    /*
        Method Functionality: Inserts an image into the database
        Specification: Uses parameters being passed to create a query, in order to 
        insert image information into the database.
        Note: This method is only inserting the image information, not the actual image.
    */
    public function insertImage($image_id,$name,$album,$username,
                                $directory,$description,$privacy)
    {
        $table = 'images';
        $values = array	//this array contains information needed to generate query.
        (
            "columns"=>array
            (					//Table fields
                'image_id',
                'name',
                'album',
                'user_id',
                'description',
                'privacy',
                'directory',
                'date',
                'date_unix'
            ),
            "values"=>array
            (					//Table field data - may contain more than one set of data
                array
                (
                    "'".$image_id."'",
                    "'".$name."'",
                    "'".$album."'",
                    "'".$username."'",
                    "'".$description."'",
                    "'".$privacy."'",
                    "'".$directory."'",
                    "'".$this->getTime()."'",
                    "'".$this->getTimeUnix()."'"
                )
            )
        );

        $query = $this->createInsertSQL($values,$table);

        if(!mysqli_query($this->getConnection(),$query))
        {
            echo mysqli_error($this->getConnection());
        }
    }
    /*
        Method Functionality: Removes image from database
        Specification: Removes image and its comments from database, using
        its image id.
    */
    public function removeImage($image_id)
    {
        $results = array(
            'result' => "",
            'error' => false,
            'error_msg' => ""

        );
        $query = "SELECT directory FROM images WHERE image_id='".$image_id."'";
        $query1 = "DELETE FROM images WHERE image_id='".$image_id."'";
        $query2 = "DELETE FROM comments WHERE image_id='".$image_id."'";

        if($result = mysqli_query($this->getConnection(),$query))
        {
            $row = mysqli_fetch_array($result);

            $temp = explode(".", $row['directory']);
            $temp2 = explode("/", $row['directory']);
            $ext = end($temp);

            $path = USERS_HOME_PATH.$row['directory'];
            $path2 = USERS_HOME_PATH.$temp2[0] . "/" . $image_id . "_homepage." . end($temp);

            if(unlink($path) && unlink($path2))
            {
                if(!mysqli_query($this->getConnection(),$query1))
                {
                    $results['error'] = true;
                    $results['error_msg'] = mysqli_error($this->getConnection());
                }
                if(!mysqli_query($this->getConnection(),$query2))
                {
                    $results['error'] = true;
                    $results['error_msg'] = mysqli_error($this->getConnection());
                }
            }
            else
            {
                $results['error'] = true;
                $results['error_msg'] = "file was not deleted sucessfully";
            }
        }
        else
        {
            $results['error'] = true;
            $results['error_msg'] = mysqli_error($this->getConnection());
        }

        return $results;

    }
    
    /*
        Method Functionality: Insert comment into database
        Specification: This method will insert comment into the database, it uses
        an image id in order to relate this comment and the image.
    */
    public function insertComment($comment_id,$image_id,$user_id,$comment)
    {
        $table = 'comments';
        $values = array
        (
            "columns"=>array
            (
                'comment_id',
                'image_id',
                'user_id',
                'comment',
                'date',
                'date_unix'
            ),
            "values"=>array
            (
                array
                (
                    "'".$comment_id."'",
                    "'".$image_id."'",
                    "'".$user_id."'",
                    "'".$comment."'",
                    "'".$this->getTime()."'",
                    "'".$this->getTimeUnix()."'"
                )
            )
        );

        $query = $this->createInsertSQL($values,$table);

        if(!mysqli_query($this->getConnection(),$query))
        {
            echo mysqli_error($this->getConnection());
        }
    }

    public function getRandomImages()
    {
        $query = "SELECT * FROM images WHERE privacy='0'";
        $result = mysqli_query($this->Database->connection,$query);
        if (mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $temp = explode(".", $row['directory']);

                $responses[] = array
                (
                    'directory' => $temp[0].'_homepage.'.end($temp),
                    'name' => $row['name'],
                    'user_id' => $row['user_id'],
                    'description' => $row['description']
                );
            }
            shuffle($responses); //Randomizes the images
            return $responses;
        }
    }

} 
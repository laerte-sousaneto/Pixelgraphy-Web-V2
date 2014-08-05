<?php
	/*
		-----------------------------------------------------------------------------
		Author: Laerte Sousa Neto
		Purpose: This class is meant to be used for retrieving, and altering information from database. 
		Last Updated: 1/2/2014
		
		PLEASE LIST ALL FUTURE UPDATES BELOW, INCLUDE AUTHOR, METHOD, SPECIFICATIONS:
		PS - ALSO INCLUDE UPDATE DATE ABOVE CLASS METHOD, OR WHAT HAS BEEN MODIFIED
			###################################################################

		
		-----------------------------------------------------------------------------
	*/
	require_once "Credential.class.php";
	
	class Database
	{
		//---PRIVATE MEMBERS---
		private $host;
		private $username;
		private $password;
		private $dbName;
		private $credentials;
		
		private $connection;  //holds database connection stream
		
		//---CONSTRUCTOR---
		
		function __construct()
		{
			$this->credentials = new Credential();
			
			$this->host = $this->credentials->getHost();
			$this->username = $this->credentials->getUsername();
			$this->password = $this->credentials->getPassword();
			$this->dbName = $this->credentials->getDBName();
			
			$this->connect();
		}
		
		// ---CLASS METHODS---
		public function getRandomImages()
		{
			$query = "SELECT * FROM images WHERE privacy='0'";
			$result = mysqli_query($this->connection,$query);
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
		/*
			Method Functionality:
			Specification:
		*/
		//connects to database, returns true if connection is estabished, else returns false
		public function connect()
		{
			$successful = true;
			$this->connection = mysqli_connect
			($this->host,$this->username,$this->password,$this->dbName);
			
			if(mysqli_connect_errno($this->connection))
			{
				$successful = false;
			}
			return $successful;
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
			mysqli_query($this->connection,$query);
		}

        /*

		*/
        function retrieveUserData($userID)
        {
            $query = "select * from uprofile where user_id = '".$userID."'";

            $result = mysqli_query($this->connection,$query);
            $resultArray = null;

            $row = mysqli_fetch_array($result);

            $resultArray = $row;


            return $resultArray;
        }

		/*	
			Method Functionality: Retrieves images from a user using its user id,
			Specifics: method will retrieve images in desceding order based on unix time,
			then it will store them in a array, and return the array containg the data retrieved.
		*/
		function retrieveUserImageData($userID)
		{
			$query = "select image_id,name,description,directory,date from images where user_id = '".$userID."'";
			$query .= " ORDER BY date_unix DESC";
			$result = mysqli_query($this->connection,$query);
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

            $result = mysqli_query($this->connection,$query);
            $resultArray = array();

            while($row = mysqli_fetch_array($result))
            {
                $id = $row['id'];
                $name = $row['name'];

                array_push($resultArray, array("ID"=>$id, "name"=>$name));
            }

            return $resultArray;
        }


        //
        function retrieveAlbumImages($albumID)
        {
            $query = "select image_id,user_id,name,description,directory,date from images where album = '".$albumID."'";
            $query .= " ORDER BY date_unix DESC";
            $result = mysqli_query($this->connection,$query);
            $resultArray = array();
            while($row = mysqli_fetch_array($result))
            {
                $user_id = $row['user_id'];
                $image_id = $row['image_id'];
                $name = $row['name'];
                $description = $row['description'];
                $directory = $row['directory'];
                $date = $row['date'];
                $temp = explode(".", $row['directory']);

                array_push($resultArray,array("ID"=>$image_id,
                    "name"=>$name,
                    "username"=>$this->getUsername($user_id),
                    "description"=>$description,
                    "directory"=>$temp[0].'_homepage.'.end($temp),
                    "date"=>$date));
            }

            return $resultArray;
        }


		//
		function retrieveUserImageDataInJSON($userID)
		{
			$query = "select image_id,name,description,directory,date from images where user_id = '".$userID."'";
			$query .= " ORDER BY date_unix DESC";
			$result = mysqli_query($this->connection,$query);
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
			$result = mysqli_query($this->connection,$query);
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
			$result = mysqli_query($this->connection,$query);
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
								"posterID"=>$user_id)
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
			$result = mysqli_query($this->connection,$query);
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
			$result = mysqli_query($this->connection,$query);
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
				"directory"=>$temp[0].'_homepage.'.end($temp),
				"date"=>$date));
			}
			return json_encode($resultArray);
		}
		
		/*
			Method Functionality: Inserts an image into the database
			Specification: Uses parameters being passed to create a query, in order to 
			insert image information into the database.
			Note: This method is only inserting the image information, not the actual image.
		*/
		public function insertImage($image_id,$name,$username,
		$directory,$description,$privacy)
		{
			$table = 'images';
			$values = array	//this array contains information needed to generate query.
			(
				"columns"=>array
				(					//Table fields
					'image_id',
					'name',
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
						"'".$this->getUserID($username)."'",
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
			$query = "SELECT directory FROM images WHERE image_id='".$image_id."'";
			$query1 = "DELETE FROM images WHERE image_id='".$image_id."'";
			$query2 = "DELETE FROM comments WHERE image_id='".$image_id."'";
			
			if($result = mysqli_query($this->getConnection(),$query))
			{
				$row = mysqli_fetch_array($result);
				
				$temp = explode(".", $row['directory']);
				if(unlink("../".$row['directory']) && unlink("../".$temp[0].'_homepage.'.end($temp)))
				{
					if(!mysqli_query($this->getConnection(),$query1))
					{
						echo mysqli_error($this->getConnection());
					}
					if(!mysqli_query($this->getConnection(),$query2))
					{
						echo mysqli_error($this->getConnection());
					}
				}
				else
				{
					echo "file was not deleted sucessfully";	
				}
			}
			else
			{
				echo mysqli_error($this->getConnection());
			}
			
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
		/*
			Method Functionality: creates insert SQL command
			Specification: It will create insert SQL command based on the values being passed,
			and uses generateInsertInto() and generateValues() in order to translate the array data 
			into a SQL command.
		*/
		public function createInsertSQL($arrayData,$table)
		{
			$query = $this->generateInsertInto($arrayData['columns'],$table);
			$query = $query.$this->generateValues($arrayData['values']);
			
			return $query;
		}
		
		/*
			Method Functionality: Translates arrayData into first part of SQL insert command
			Specification: This method should work in conjunction to generateVaues(), It will only
			generate the first part of SQL insert command.
		*/
		public function generateInsertInto($arrayColumns,$table)
		{
			$query = "INSERT INTO ".$table."(";
			
			foreach($arrayColumns as $column)
			{
				
				 $query = $query.$column;
				 if($this->isLastIndex($arrayColumns,$column))
				 {
				 	$query = $query.')';
				 }
				 else
				 {
				 	$query = $query.',';
				 }
			}
			
			return $query; 
		}
		
		/*
			Method Functionality: Translates arrayData into second part of SQL insert command
			Specification: This method should work in conjunction to generateInsertInto(), It will only
			generate the second part of SQL insert command. Also works with multiple values.
		*/
		public function generateValues($arrayFieldValues)
		{
			$query = '';
			foreach($arrayFieldValues as $valueField)
			{
				$query2 = " VALUES(";
				foreach($valueField as $fieldData)
				{
					$query2 = $query2.$fieldData;
					if($this->isLastIndex($valueField,$fieldData))
				 	{
				 		$query2 = $query2.')';
				 	}
				 	else
				 	{
				 		$query2 = $query2.',';
				 	}
				}
				
				/*if(!$this->isLastIndex($arrayFieldValues,$valueField))
				{
					$query2 = $query2.',';
				}*/
				$query = $query.$query2;
				
			}
			return $query;
		}
		
		/*
			Method Functionality: check it is the last element of the array.
			Specification: Method uses the array and the element which is suppose to be contained in the array,
			in order to determine if it is the last index or not. It will return true if it is the last index,
			or false if it is not found, or last index.
		*/
		public function isLastIndex($array,$element)
		{
			return ($element == end($array));
		}
		
		// -----GETTERS & SETTERS-----
		
		//returns connection stream
		public function getConnection()
		{
			return $this->connection;
		}
		/*
			Method Functionality: Returns all users on database
		*/
		public function getUsers()
		{
			$query = "select * from users";
			$result = mysqli_query($this->connection,$query);
			
			while($row = mysqli_fetch_array($result))
			{
				$userID = $row['user_id'];
				$username = $row['username'];
				$password = $row['password'];
				
				echo 'ID: '.$userID.'	Username: '.$username.
				'	Password: '.$password.'<br/>';
			}
		}
		
		/*
			Method Functionality: Returns user's home directory
		*/
		public function getUserHome($username)
		{
			$field = 'home_path';
			$query = "select ".$field." from users where username ='".$username."'";
			$result = mysqli_query($this->connection,$query);
			$row = mysqli_fetch_array($result);
			return $row['home_path'];
		}
		/*
			Method Functionality: Returns user's email
		*/
		public function getUserEmail($username)
		{
			$field = 'email';
			$query = "select ".$field." from users where username ='".$username."'";
			$result = mysqli_query($this->connection,$query);
			$row = mysqli_fetch_array($result);
			return $row['home_path'];
		}

		public function isEmailValid($email)
		{
			$valid = false;
			$field = 'email';
			$query = "select ".$field." from users where email ='".$email."'";
			$result = mysqli_query($this->connection,$query);
			$row = mysqli_fetch_array($result);
			if($row)
			{
				$valid = true;
			}
			return $valid;
		}
		/*
			Method Functionality: Returns user id
		*/
		public function getUserID($username)
		{
			$field = 'user_id';
			$query = "select ".$field." from users where username ='".$username."'";
			$result = mysqli_query($this->connection,$query);
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
			$result = mysqli_query($this->connection,$query);
			$row = mysqli_fetch_array($result);
			return $row['username'];
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
		/*
			Method used when reseting passwords. Creates a temporary reset hash for the user.
		*/
		public function insertResetHash($hash, $eml)
		{
			$query = "update users set rhash='".$hash."' where email='".$eml."'";
			mysqli_query($this->connection,$query);
		}
	}
	
?>
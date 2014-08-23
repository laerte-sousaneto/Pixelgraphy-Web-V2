<?php
/*
	-----------------------------------------------------------------------------
	Author: Laerte Sousa Neto
	Purpose: This class is meant to be used in order upload/save image files in
	the server.
	Last Updated: 1/7/2014
	
	PLEASE LIST ALL FUTURE UPDATES BELOW, INCLUDE AUTHOR, METHOD, SPECIFICATIONS:
	PS:		ALSO INCLUDE UPDATE DATE ABOVE CLASS METHOD, OR WHAT HAS BEEN MODIFIED
	e.g:	function_name modyfied on 1/7/2013 by Laerte Sousa Neto
			+Added something description example
			-Removed something description example
		###################################################################
	
	-----------------------------------------------------------------------------
*/
	require_once 'Database.class.php';
	require_once 'ImageUtility.class.php';

	class ImageServerUpload
	{
		//---PRIVATE MEMBERS---
		private $database;
		private $user;
        private $username;
		private $file;
		private $name;
        private $album;
		private $description;
		private $isProfile;
		private $directory;
        private $tempDirectory;
		private $domain;
		private $image_id;
		
		//---DEFAULT CONSTRUCTOR---
		function __construct($user,$file,$name, $album,$description,$isProfile)
		{

			$this->database = new Database();


			$this->user = $user;
            $this->username = $this->database->getUsername($user);
			$this->file = $file;
			$this->name = $name;
            $this->album = $album;
			$this->description = $description;
			$this->image_id = uniqid();
			$this->isProfile = $isProfile;
			$this->rootDirectory = "/var/www/html/userhome_pixel/".$this->username."/";
            $this->imageURL = "http://userhome.laertesousa.com/".$this->username;

            $this->tempURL = "http://pixel.laertesousa.com/temp/";
            $this->tempDirectory = "/var/www/html/pixelgraphy/temp/";
			$this->domain = 'pixelgraphy.net/';
		}
		//---PUBLIC METHODS---
		/*
			Method Functionality: Converts private members into a strin
			Specifications: This method will convert all private members into a string,
			and return it. This method is mostly used for debugging purpose.
		*/
		public function toString()
		{
			$str = "";
			$str .=$this->image_id."<br/>";
			$str .=$this->file['name'].'<br/>';
			$str .=$this->directory.'<br/>';
			$str .=$this->user.'<br/>';
			return $str;
		}
		
		/*
			Method Functionality: Update Profile Picture
			Specifications: This function will update profile image source in
			the database. This method is assuming that the image file already
			exists in the server.
		*/
		public function updateProfilePicture($table,$setting,$data,$user)
		{
			$this->database->updateUserSettings($table,$setting,$data,$user);
		}
		
		/*
			Method Functionality: Upload image file
			Specifications: This method will check if the file is an actual image,
			if there's no errors on file, if if doesn't already exists. Then it will
			save the picture into the user home directory on the server, and if it is
			a profile image, this will update user profile image source, if it is not 
			a profile image, then this will add image source and details, to table containing
			list of all images to be displayed in the global feed. If any of the pre-conditions
			are not met, this will echo appropiate error message. Note: if there's more than
			one error, this will warn about the first error it ecountered.
		*/
		public function uploadImageFile()
		{
			$ext = $this->getFileExtension($this->name);
			
			if($this->isImageFile($ext) && $this->noFileError() && $this->noDuplicate())
			{
				if(move_uploaded_file($this->file['tmp_name'],$this->rootDirectory.$this->image_id.".".$ext))
				{
					if($this->isProfile == 'true')
					{
						$this->database->updateUserSettings('uprofile','profile_picture',$this->directory,$this->user);
					}
					else
					{
						$this->database
						->insertImage($this->image_id,$this->name, $this->album,$this->user,
						$this->imageURL.$this->image_id.".".$ext,$this->description,0);
						
						$imageUtility = new ImageUtility($this->rootDirectory.$this->image_id.".".$ext);
						$imageUtility->cropAndSave($this->image_id.'_homepage.'.$this->getFileExtension(),$this->rootDirectory,350,200);
					}
					
					echo "File Uploaded";
				}
			}
			elseif(!$this->isImageFile($ext))
			{
				echo "not an image file.";
			}
			elseif(!$this->noFileError())
			{
				echo "there's a file error."."<br/>".$this->file['error'];
			}
			elseif(!$this->noDuplicate())
			{
				echo "Already exists";
			}
		}

        /*
			Method Functionality: Upload image file
			Specifications: This method will check if the file is an actual image,
			if there's no errors on file, if if doesn't already exists. Then it will
			save the picture into the user home directory on the server, and if it is
			a profile image, this will update user profile image source, if it is not
			a profile image, then this will add image source and details, to table containing
			list of all images to be displayed in the global feed. If any of the pre-conditions
			are not met, this will echo appropiate error message. Note: if there's more than
			one error, this will warn about the first error it ecountered.
		*/
        public function uploadTempImageFile()
        {
            $ext = $this->getFileExtension($this->name);
            $result = array('data'=> '', 'error'=>false, 'error_msg'=>'', 'moreInfo'=>'');

            if($this->isImageFile($ext) && $this->noFileError() && $this->noDuplicate())
            {

                $imageUtility = new ImageUtility($this->file['tmp_name']);
                $imageUtility->cropAndSave2(350,200);
                move_uploaded_file($this->file['tmp_name'],$this->tempDirectory.$this->image_id.".".$ext);

                $result['data'] = $this->tempURL.$this->image_id.".".$ext;
                $result['moreInfo'] =  "File Uploaded";

            }
            elseif(!$this->isImageFile($ext))
            {
                $result['error'] = true;
                $result['error_msg'] = "not an image file.";
            }
            elseif(!$this->noFileError())
            {
                $result['error'] = true;
                $result['error_msg'] = "there's a file error."."<br/>".$this->file['error'];
            }
            elseif(!$this->noDuplicate())
            {
                $result['error'] = true;
                $result['error_msg'] = "Already exists";
            }

            return $result;
        }
		
		//---PRIVATE METHODS---
		/*
			Method Functionality: Remove file extension
			Specifications: This method will simply separte file's name from
			its extension, and return file's name.
		*/
		private function removeFileExtension()
		{
			$temp = explode(".", $this->file['name']);
			$extension = $temp[0];
			return $extension;
		}
		
		/*
			Method Functionality: Retrieve file extension
			Specifications: This method will extract file extension from
			file's name and return its extension.
		*/
		private function getFileExtension()
		{
			$temp = explode(".", $this->file['name']);
			$extension = end($temp);
			return $extension;
		}
		
		/*
			Method Functionality: Check if is an image file
			Specifications: This method will check if file is an
			image, and if the image format is allowed.
		*/
		private function isImageFile()
		{
			$extension = $this->getFileExtension();
			$isImageFile = false;
			$allowedExts = array("gif", "jpeg", "jpg", "png","JPG");
			
			if(in_array($extension, $allowedExts))
			{
				$isImageFile = true;
			}
			
			return $isImageFile;
		}
		
		/*
			Method Functionality: Check if there's any errors in the file
			Specifications: This method will check for any errors ocurred during
			file transfer.
		*/
		private function noFileError()
		{
			$noError = true;
			if ($this->file["error"] > 0)
			{
				$noError = true;
			}
			return $noError;
		}
		
		/*
			Method Functionality: Check for duplicates
			Specifications: This method will check if this file already
			exists in the server. Returns true if it doesnt, else returns false.
		*/
		private function noDuplicate()
		{
			$noDuplicate = true;
			if (file_exists($this->directory))
			{
				$noDuplicate = false;
			}
			return $noDuplicate;
		}
		
		/*
			Method Functionality: Generates Directory for Image to be saved
			Specifications: This method will grab the user home directory from Database
			and formats it, in order to save the image properly.
		*/
		public function generateDirectory()
		{
			$dir = $this->database->getUserHome($this->user).'/'.$this->image_id.'.'.$this->getFileExtension();
			return $dir;
		}
		public function appendStringBeforeFileExtension($str)
		{
			$dir = $this->database->getUserHome($this->user).'/'.$this->image_id.$str.'.'.$this->getFileExtension();
			return $dir;
		}
		
		//--GETTERS & SETTERS
		public function getCredential()
		{
			return $this->credential;
		}
		public function getDatabase()
		{
			return $this->database;
		}
		public function getFile()
		{
			return $this->file;
		}
		public function getImage()
		{
			return $this->image_id;
		}
		public function getDirectory()
		{
			return $this->directory;
		}
		
		public function setCredential($credential)
		{
			$this->credential = $credential;
		}
		public function setDatabase($database)
		{
			$this->database = $database;
		}
		public function setFile($file)
		{
			$this->file = $file;
		}
		
	}
?>
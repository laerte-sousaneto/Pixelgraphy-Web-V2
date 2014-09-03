<?php
/*
	-----------------------------------------------------------------------------
	Author: Laerte Sousa Neto
	Purpose: This class is meant to be used in order to retrieve comments stored
	in the database.
	Last Updated: 1/7/2014
	
	PLEASE LIST ALL FUTURE UPDATES BELOW, INCLUDE AUTHOR, METHOD, SPECIFICATIONS:
	PS:		ALSO INCLUDE UPDATE DATE ABOVE CLASS METHOD, OR WHAT HAS BEEN MODIFIED
	e.g:	function_name modyfied on 1/7/2013 by Laerte Sousa Neto
			+Added something description example
			-Removed something description example
		###################################################################
	
	-----------------------------------------------------------------------------
*/
	require_once '../Database.class.php';
	
	class CommentFeed
	{
		//---PRIVATE MEMBERS---
		private $database; 
		
		//---DEFAULT CONSTRUCTOR---
		function __construct()
		{
			$this->database = new Database();
		}
		/*
			Method Functionality: Store a comment in the database table
			Specifications: This method will store an comment made by the user
			using the parameters being passed, it will also generate a uniq id for
			the comment being stored.
			Note: uses Database object, read Database.class.php for more information.
		*/
		public function addComment($image_id,$userID,$comment)
		{
			$comment_id = uniqid();
			$this->database->insertComment($comment_id,
											$image_id,
											$userID,
											$comment);
		}
		
		/*
			Method Functionality: Store a comment in the database table
			Specifications: This method will store an comment made by the user
			using the parameters being passed, it will also generate a uniq id for
			the comment being stored.
			Note: uses Database object, read Database.class.php for more information.
		*/
		public function addCommentWithUserID($image_id,$userID,$comment)
		{
			$comment_id = uniqid();
			$this->database->insertComment($comment_id,
											$image_id,
											$userID,
											$comment);
		}
		
		/*
			Method Functionality: Rtrieve comment from certain image
			Specifications: This method will retrieve all comments in the
			image with the specific id being passed to this method.
			Note: uses Database object, read Database.class.php for more information.
		*/
		public function getComments($image_id)
		{
			return $this->database->retrieveComments($image_id);
		}
		
		public function getCommentsJSON($image_id)
		{
			return $this->database->retrieveCommentsWithKeys($image_id);
		}
	}
?>
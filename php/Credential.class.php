<?php
	/*
		-----------------------------------------------------------------------------
		Author: Laerte Sousa Neto
		Purpose: This class has the soly purpose of	holding credentials 
		needed for accessing databases or others resctricted directory
		
		Last Updated: 1/2/2014
		
		PLEASE LIST ALL FUTURE UPDATES BELOW, INCLUDE AUTHOR, METHOD, SPECIFICATIONS:
		PS - ALSO INCLUDE UPDATE DATE ABOVE CLASS METHOD, OR WHAT HAS BEEN MODIFIED
			###################################################################
		
		-----------------------------------------------------------------------------
	*/
	class Credential
	{
		//---PRIVATE MEMBERS---
		
		private $host;
		private $username;
		private $password;
		private $dbName;
		
		//---CONSTRUCTOR---
		
		function __construct()
		{
			$this->host = '192.168.1.7';
			$this->username = 'laerte';
			$this->password = 'lta86t7v';
			$this->dbName = 'pixelgraphy';
		}
		
		// ---GETTERS---
		public function getHost()
		{
			return $this->host;
		}
		public function getUsername()
		{
			return $this->username;
		}
		public function getPassword()
		{
			return $this->password;
		}
		public function getDBName()
		{
			return $this->dbName;
		}
	}
?>
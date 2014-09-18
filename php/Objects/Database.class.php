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
	require_once "../Config/Credential.class.php";
    require_once "../Config/Config.php";
	
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

        public function runQuery($sql)
        {
            $results = array('data' => null, 'error' => false, 'error_msg' => '');
            if($this->connection != null)
            {
                $queryResult = mysqli_query($this->connection, $sql);

                if(!$queryResult)
                {
                    $results['error'] = true;
                    $results['error_msg'] = mysqli_error($this->connection);
                }
                else
                {
                    $results['data'] = $queryResult;
                }
            }

            return $results;
        }

        public function updateTableField($table, $field, $value, $condition = "")
        {
            if( !isset($table) || strlen($table) < 0 ) throw new Exception("Table name cannot be null");
            if( !isset($field) || strlen($field) < 0 ) throw new Exception("Field name cannot be null");
            if( !isset($value) || strlen($value) < 0 ) throw new Exception("Field value cannot be null");

            $sql = "UPDATE " . $table . " SET " . $field . "='" . $value . "' " . $condition;
            $queryResult = $this->runQuery($sql);

            if(!$queryResult)
            {
                return false;
            }
            else
            {
                return true;
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

	}
	

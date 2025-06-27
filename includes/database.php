<?php
require_once(LIB_PATH.DS."config.php");

class mysqliDatabase {
	
	private $connection;				// Holds the database connection string.
	public  $last_query; 				// Holds the last database Query.
	private $magic_quotes_active;		// Checks and store if the mysqli_prep() exists.
	private $real_escape_string_exists;	// Checks mysqli_real_escape_string existance.
	
	//List of functions to be executed when the class is instantiated.
	function __construct(){
		$this->open_connection();
// 		$this->magic_quotes_active = @get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists("mysqli_real_escape_string"); //PHP >= v4.3.0
	}
	
	//Create a database connection.
	public function open_connection(){
		$this->connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS); 
		if(!$this->connection):
			die("Database Connection Failed. ".mysqli_error());
		else:
			$db_select = mysqli_select_db($this->connection,DB_NAME);
			if(!$db_select):
				die("Database Selection Failed. ".mysqli_error($this->connection));
			endif;
		endif;
	}
	
	//Closing the database connection.
	public function close_connection(){
		if(isset($this->connection)):
			mysqli_close($this->connection); //CLOSE DATABASE CONNECTION
			unset($this->connection);
		endif;
	}
	
	//Performs database Query.
	public function query($sql){
		$this->last_query = $sql;
		$result = mysqli_query($this->connection,$sql);
		$this->confirm_query($result);
		return $result;
	}
	
	//Prepare data to be injected to the database.
	public function escape_value($value){
		if($this->real_escape_string_exists):
			if($this->magic_quotes_active){ $value = stripslashes($value);}
			$value = mysqli_real_escape_string($this->connection,$value);
		else: //PHP < v4.3.0
			if(!$this->magic_quotes_active){ $value = addslashes($value);}
		endif;
		return $value;
	}
	
	//Return number of rows in the result set.
	public function num_rows($result){
		return mysqli_num_rows($result);
	}
	
	//Performs db Query and returns the result in Array.
	public function fetch_array($result, $option = MYSQLI_ASSOC){
		return mysqli_fetch_array($result, $option);
	}

	public function fetch_object($result){
		return mysqli_fetch_object($result);
	}
	
	public function fetch_data($recordset)  {
		if(is_resource($recordset))  {  
			return mysqli_fetch_object($recordset);
		}
	}

    //i(Naresh) add some functions for transaction
    function begin()
	{
	@mysqli_query(" BEGIN ");	
	}
	function commit()
	{
	 return @mysqli_query(" COMMIT ");	
	}
	function rollback()
	{
		@mysqli_query("ROLLBACK");	
    }
	
	//
	public function insert_id(){
		return mysqli_insert_id($this->connection);
	}
	
	//How many rows were affected in the last database query.
	public function affected_rows(){
		return mysqli_affected_rows($this->connection);
	}
	
	//Confirms that the Query worked.
	private function confirm_query($result){
		if(!$result):
			$output = "<br />Database Query Failed. ".mysqli_error($this->connection);
			$output.= "<br />Last Query: <b>".$this->last_query."</b>";
			die($output);
		endif;
	}
}

$database = new mysqliDatabase(); //DATABASE OBJECT
$db =& $database; //CAN USE JUST $db INSTEAD OF $database.
$db->query("SET SESSION sql_mode = ''");
$db->query("SET names utf8");

?>
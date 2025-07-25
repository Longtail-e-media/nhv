<?php
class Member extends DatabaseObject {

	protected static $table_name = "tbl_member";
	protected static $db_fields = array('id', 'regno', 'first_name', 'middle_name', 'last_name', 'gender', 'dob', 'pass_level', 'pass_year', 'mailaddress', 'phoneno', 'current_address',  'other_info', 'sortorder', 'status', 'added_date', 'login_status', 'user_text', 'pass_text', 'reset_token');
	
	public $id;	
	public $regno;
	public $first_name;
	public $middle_name;
	public $last_name;
	public $gender;
	public $dob;
	public $pass_level;
	public $pass_year;
	public $mailaddress;
	public $phoneno;
	public $current_address;
	
	public $other_info;
	public $sortorder;
	public $status;
	public $added_date;
	public $login_status;
	public $user_text;
	public $pass_text;
	public $reset_token;
		

	public static function get_all_students()	 {
		global $db;
		$sql = "SELECT * FROM ".self::$table_name." WHERE status=1 AND login_status=1 ORDER BY sortorder DESC ";
		$result = self::find_by_sql($sql);
		return $result;
	}

	public static function get_login_access($unam='', $upass='') {
		global $db;
		$sql="SELECT * FROM ".self::$table_name." WHERE user_text='$unam' AND pass_text='$upass' ORDER BY sortorder DESC LIMIT 1 ";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function get_reset_info_by($reset='') {
		global $db;
		$sql="SELECT * FROM ".self::$table_name." WHERE reset_token='$reset' ORDER BY sortorder DESC LIMIT 1 ";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public static function get_forget_pass($email='') {
		global $db;
		$sql="SELECT * FROM ".self::$table_name." WHERE mailaddress='$email' ORDER BY sortorder DESC LIMIT 1 ";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
		
	public static function checkDupliEmail($mail='') {
		global $db;
		$sql = "SELECT mailaddress FROM ".self::$table_name." WHERE mailaddress='$mail' LIMIT 1 ";
		$query = $db->query($sql);
		$result= $db->num_rows($query);
		return !empty($result)?$result:0;
	}

	public static function checkOldpass($uid='', $old_pass='') {
		global $db;
		$sql = "SELECT mailaddress FROM ".self::$table_name." WHERE pass_text='$old_pass' AND id='$uid' LIMIT 1 ";
		$query = $db->query($sql);
		$result= $db->num_rows($query);
		return !empty($result)?$result:0;
	}

	public static function find_by_passtoken($pstokn=0){
		global $db;
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE reset_token='$pstokn' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	//FIND THE HIGHEST MAX NUMBER.
	public static function find_maximum($field="sortorder"){
		global $db;
		$result = $db->query("SELECT MAX({$field}) AS maximum FROM ".self::$table_name);
		$return = $db->fetch_array($result);
		return ($return) ? ($return['maximum']+1) : 1 ;
	}
	
	//Find all the rows in the current database table.
	public static function find_all(){
		global $db;
		return self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY sortorder ASC");
	}

	//Find a single row in the database where id is provided.
	public static function find_by_id($id=0){
		global $db;
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	//Find rows from the database provided the SQL statement.
	public static function find_by_sql($sql=""){
		global $db;
		$result_set = $db->query($sql);
		$object_array = array();
		while($row = $db->fetch_array($result_set)){
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	//Instantiate all the attributes of the Class.
	private static function instantiate($record){
		$object  = new self;
		foreach($record as $attribute=>$value){
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	//Check if the attribute exists in the class.
	private function has_attribute($attribute){
		$object_vars = $this->attributes();
		return array_key_exists($attribute, $object_vars);
	}
	
	//Return an array of attribute keys and thier values.
	protected function attributes(){
		$attributes = array();
		foreach(self::$db_fields as $field):
			if(property_exists($this, $field)){
				$attributes[$field] = $this->$field;
			}
		endforeach;
		return $attributes;
	}
	
	//Prepare attributes for database.
	protected function sanitized_attributes(){
		global $db;
		$clean_attributes = array();
		foreach($this->attributes() as $key=>$value):
			$clean_attributes[$key] = $db->escape_value($value);
		endforeach;
		return $clean_attributes;
	}
	
	//Save the changes.
	public function save(){
		return isset($this->id) ? $this->update() : $this->create();
	}
	
	//Add  New Row to the database
	public function create(){
		global $db;
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".self::$table_name."(";
		$sql.= join(", ", array_keys($attributes));
		$sql.= ") VALUES ('";
		$sql.= join("', '", array_values($attributes));
		$sql.= "')";
		if($db->query($sql)){
			$this->id = $db->insert_id();
			return true;
		} else {
			return false;
		}
	}
	
	//Update a row in the database.
	public function update(){
		global $db;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		
		foreach($attributes as $key=>$value):
			$attribute_pairs[] = "{$key}='{$value}'";
		endforeach;
		
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql.= join(", ", array_values($attribute_pairs));
		$sql.= " WHERE id=".$db->escape_value($this->id);
		$db->query($sql);
		return ($db->affected_rows()==1) ? true : false;
		//return true;
	}
}
?>
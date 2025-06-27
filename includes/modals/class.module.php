<?php
class Module extends DatabaseObject {

	protected static $table_name = "tbl_modules";
	protected static $db_fields = array('id', 'parent_id', 'name', 'link', 'mode', 'icon_link', 'status', 'sortorder', 'added_date', 'properties');
	
	public $id;
	public $parent_id;
	public $name;
	public $link;
	public $mode;
	public $icon_link;
	public $status;
	public $sortorder;
	public $added_date;
	public $properties;
	
	//Get All modules
	public static function getAllmode(){
		global $db;
		$sql= "SELECT mode FROM ".self::$table_name." WHERE status='1'";
		return self::find_by_sql($sql);
	}

	public static function get_id_by($mode)
	{
		global $db;
		$result_array = self::find_by_sql("SELECT id FROM ".self::$table_name." WHERE mode='{$mode}' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	//Find all the rows in the current database table.
	public static function find_all_parent(){
		global $db;
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status='1' AND parent_id= 0 ORDER BY sortorder ASC");
	}

	public static function find_child_by($parentId=''){
		global $db;
		$sql = "SELECT * FROM ".self::$table_name." WHERE status='1' AND parent_id= {$parentId} ORDER BY sortorder ASC";
		return self::find_by_sql($sql);
	}
	
	public static function display_all(){
		global $db;
		return self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY sortorder ASC");
	}

	//Find all by parent id the current database table.
	static function find_all_byparnt($parentId=0){
		global $db;
		$sql = "SELECT * FROM ".self::$table_name." WHERE parent_id=$parentId  ORDER BY sortorder DESC";
		return self::find_by_sql($sql);
	}

	public static function getTotalSub($type=''){
		global $db;
		$cond = !empty($type)?' AND parent_id='.$type:'';
		$query = "SELECT COUNT(id) AS tot FROM ".self::$table_name." WHERE status=1 $cond ";
		$sql = $db->query($query);
		$ret = $db->fetch_array($sql);
		return $ret['tot'];
	}
	
	public static function check_parent($mode=''){
		global $db;
		$sql = "SELECT parent_id FROM ".self::$table_name." WHERE mode='$mode' ORDER BY sortorder DESC LIMIT 1";
		$result = self::find_by_sql($sql);
		return !empty($result)?array_shift($result):false;
	}

	//Find a single row in the database where id is provided.
	public static function find_properties_by($id=0){
		global $db;
		$result = $db->query("SELECT properties FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		$return = $db->fetch_array($result);
		return ($return) ? $return['properties'] : '' ;
	}

	public static function get_properties($id=0,$fields=""){
		global $db;
		$sql = "SELECT properties FROM ".self::$table_name." WHERE id={$id} LIMIT 1";
		$result = $db->query($sql);
		$return = $db->fetch_array($result);		
		$rec 	= unserialize($return['properties']);
		
		return ($rec[$fields])? $rec[$fields] : 0;
	}
	
	public static function field_by_id($id=0,$fields=""){
		global $db;
		$sql = "SELECT $fields FROM ".self::$table_name." WHERE id={$id} LIMIT 1";
		$result = $db->query($sql);
		$return = $db->fetch_array($result);
		return ($return) ? $return[$fields] : '' ;
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
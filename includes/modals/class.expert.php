<?php
class Expert extends DatabaseObject {

	protected static $table_name = "tbl_expert";
	protected static $db_fields = array('id', 'slug', 'name', 'description', 'status', 'sortorder', 'image','email','package1');
	
	public $id;
	public $slug;
	public $name;
	public $description;
	public $status;
	public $sortorder;
	public $image;
	public $email;
	public $package1;
	
	public static function checkDupliName($name='')
	{
		global $db;
		$query = $db->query("SELECT name FROM ".self::$table_name." WHERE name='$name' LIMIT 1");
		$result= $db->num_rows($query);
		if($result>0) {return true;}
	}
	
	public static function get_allexpert($limit=''){
		global $db;
		$cond=!empty($limit)?' LIMIT '.$limit:'';
		$sql="SELECT * FROM ".self::$table_name." WHERE status='1' ORDER BY sortorder DESC $cond";
		return self::find_by_sql($sql);
	}
	/*public static function get_expert_option($selId=''){
		global $db;
		$sql = "SELECT id,name FROM ".self::$table_name." WHERE status='1' ORDER BY sortorder DESC";
		$expert = self::find_by_sql($sql);				
		$result='';		
		if($expert):		
			foreach($expert as $Row):
				$sel = ($selId==$Row->id) ?'selected':'0';
				$result.=' <input type="checkbox" class="custom-radio" name="check[]" id="check"
                               value="1" '.$Row->id.'" '.$sel.'>
                        <label for="">'.$Row->name.'</label>';
			endforeach;
		endif;
		return $result;
	}	*/
	//GET Random Testimonial
	public static function get_by_rand($type='') {
		global $db;
		$cond = !empty($type)? " AND type='$type'" : '';
		$sql = "SELECT * FROM ".self::$table_name." WHERE status=1 $cond ORDER BY RAND() LIMIT 1 ";
		$result_array = self::find_by_sql($sql);
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
		return self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY sortorder DESC");
	}
	
	//Get sortorder by id
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
	
	
	//front end function start here
//	public static function getAllTestimonial($total=6, $offset=0){
//		global $db;
//		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status=1 ORDER BY sortorder ASC LIMIT {$total} OFFSET {$offset}");
//	}
	public static function getAllExpert(){
		global $db;
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status=1 ORDER BY sortorder ASC");
	}
	
	// GET Testimonial LIST.
	public static function getExpertList($total=5){
		global $db;
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status=1 ORDER BY sortorder DESC LIMIT $total");
	}
	
	// GET SPECIFIC Testimonial
	public static function getExpert($id=0){
		global $db;
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} AND status=1 LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	// get total number of records published
	public static function getTotalExpert(){
		global $db;
		$sql = "SELECT * FROM ".self::$table_name." WHERE status='1'";
		$query = $db->query($sql);
		return $db->num_rows($query);
	}
}
?>
<?php
class Video extends DatabaseObject {

	protected static $table_name = "tbl_video";
	protected static $db_fields = array('id', 'source', 'url_type', 'title', 'thumb_image', 'url', 'content', 'class', 'host', 'status', 'sortorder', 'added_date');
	
	public $id;	
	public $source;
	public $url_type;
	public $title;
	public $thumb_image;
	public $url;
	public $host;
	public $content;
	public $class;
	public $status;
	public $sortorder;
	public $added_date;
	
	// Get all the published videos
	public static function getVideos($total=1000){
		global $db;
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE published=1 ORDER BY sortorder DESC LIMIT {$total}");
	}
	
	// get all news getAllNews <pagination>
	public static function getAllVideos($total=10, $offset=0){
		global $db;
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE published=1 ORDER BY sortorder DESC LIMIT {$total} OFFSET {$offset}");
	}
	
	// get total published video number
	public static function getTotalVideo(){
		global $db;
		$sql = "SELECT id FROM ".self::$table_name." WHERE published=1";
		$query = $db->query($sql);
		return $db->num_rows($query);
	}
	
	public static function checkDupliTitle($title='')
	{
		global $db;
		$query = $db->query("SELECT title FROM ".self::$table_name." WHERE title='$title' LIMIT 1");
		$result= $db->num_rows($query);
		if($result>0) {return true;}
	}

	/************************** Video link  by me ***************************/
	public static function get_internal_link($Lsel='',$LType=0){
		global $db;		
		$sql = "SELECT id, title FROM ".self::$table_name." WHERE status='1' ORDER BY sortorder ASC";
		$pages = self::find_by_sql($sql);			
		$result='';		
		if($pages):
		$result.='<option value="0">None</option>
			<optgroup label="Video">';
			foreach($pages as $pageRow):
				$sel = ($Lsel==$pageRow->id) ?'selected':'';
				$result.='<option value="'.$pageRow->id.'" '.$sel.'>&nbsp;&nbsp;'.$pageRow->title.'</option>';
			endforeach;
		$result.='</optgroup>';	
		endif;
		return $result;
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
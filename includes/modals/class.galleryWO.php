<?php
class Gallery extends DatabaseObject {

	protected static $table_name = "tbl_galleries";
	protected static $db_fields = array('id', 'image', 'title', 'status', 'sortorder', 'detail', 'type', 'registered');
	
	var $id;
	var $image;
	var $title;
	var $status;
	var $sortorder;
	var $detail;
	var $type;
	var $registered;
	
	// view gallery Front.
	static function getGallery(){
		global $db;
		$sql = "SELECT * FROM ".self::$table_name." WHERE status=1 ORDER BY sortorder ASC ";
		return self::find_by_sql($sql);
	}
		
	public static function checkDupliName($name='')
	{
		global $db;
		$query = $db->query("SELECT name FROM ".self::$table_name." WHERE name='$name' LIMIT 1");
		$result= $db->num_rows($query);
		if($result>0) {return true;}
	}
	
	static function getTotalImages($id=0){
		global $db;
		$sql = "SELECT id FROM ".self::$table_name." WHERE status=1";
		return @$db->num_rows($db->query($sql));
	}
	
	// view gallery of the nos provided.
	static function getGalleryList($total=5, $offset=0){
		global $db;
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status=1 ORDER BY sortorder ASC LIMIT {$total} OFFSET {$offset}");
	}

	/************************** Gallery link  by me ***************************/
	public static function get_gallery_link($Lsel='',$LType=0)
	{
		global $db;		
		$sql = "SELECT id,title FROM ".self::$table_name." WHERE status='1' ORDER BY sortorder ASC";
		$pages = self::find_by_sql($sql);		
		$linkpageDis = ($Lsel==1)?'hide':'';
		
		$result='';		
		if($pages):
		$result.='<optgroup label="Gallery">';
			foreach($pages as $pageRow):
				$sel = ($Lsel==("gallery/".$pageRow->id."/".sanitize_title($pageRow->title))) ?'selected':'';
				$result.='<option value="gallery/'.$pageRow->id.'/'.sanitize_title($pageRow->title).'" '.$sel.'>&nbsp;&nbsp;'.$pageRow->title.'</option>';
			endforeach;
		$result.='</optgroup>';	
		endif;
		return $result;
	}
	
	//FIND THE HIGHEST MAX NUMBER.
	static function find_maximum($field="sortorder"){
		global $db;
		$result = $db->query("SELECT MAX({$field}) AS maximum FROM ".self::$table_name);
		$return = $db->fetch_array($result);
		return ($return) ? ($return['maximum']+1) : 1 ;
	}
	
	// get the gallery name from it's id
	static function getGalleryName($id=0){
		global $db;
		$result = $db->query("SELECT title FROM ".self::$table_name." WHERE id='{$id}'");
		$return = $db->fetch_array($result);
		return ($return) ? $return['title'] : '' ;
	}
	
	//Find all the rows in the current database table.
	static function find_all(){
		global $db;
		return self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY sortorder ASC");
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
	static function find_by_id($id=0){
		global $db;
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	//Find rows from the database provided the SQL statement.
	static function find_by_sql($sql=""){
		global $db;
		$result_set = $db->query($sql);
		$object_array = array();
		while($row = $db->fetch_array($result_set)){
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
	
	//Instantiate all the attributes of the Class.
	static function instantiate($record){
		$object  = new self;
		foreach($record as $attribute=>$value){
			if($object->has_attribute($attribute)){
				$object->$attribute = $value;
			}
		}
		return $object;
	}
	
	//Check if the attribute exists in the class.
	function has_attribute($attribute){
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
	function save(){
		return isset($this->id) ? $this->update() : $this->create();
	}
	
	//Add  New Row to the database
	function create(){
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
	function update(){
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
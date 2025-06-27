<?php
class Destination extends DatabaseObject {

	protected static $table_name = "tbl_destination";
	protected static $db_fields = array('id', 'slug', 'title', 'title_brief', 'image', 'gallery', 'brief', 'content', 'status', 'sortorder', 'meta_keywords', 'meta_description', 'added_date');
	
	public $id;
	public $slug;
	public $title;
	public $title_brief;
	public $image;
	public $gallery;
	public $brief;
	public $content;
	public $status;
	public $sortorder;
	public $meta_keywords;
	public $meta_description;
	public $added_date;		

	// Get destination list
	public static function get_destination()
	{
		global $db;
		$sql = "SELECT id, title,slug,image, content FROM ".self::$table_name." WHERE status=1 ORDER BY sortorder DESC ";
		return self::find_by_sql($sql);
	}
	
	//Find a single row in the database where slug is provided.
	public static function find_by_slug($slug=0){
		global $db;
		$sql = "SELECT * FROM ".self::$table_name." WHERE slug='$slug' LIMIT 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function checkDupliName($title=''){
		global $db;
		$query = $db->query("SELECT title FROM ".self::$table_name." WHERE title='$title' LIMIT 1");
		$result= $db->num_rows($query);
		if($result>0) {return true;}
	}	
	
	// Homepage Display
	public static function homepageDestination($limit=''){
		global $db;
		$lmt = !empty($limit)?' LIMIT '.$limit:'';
		$sql="SELECT * FROM ".self::$table_name." WHERE status='1' AND homepage='1' ORDER BY sortorder ASC $lmt";
		return self::find_by_sql($sql);
	}
	
	// Destination display
	public static function getDestination($page=""){
		global $db;
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE name='{$page}' AND status=1 LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	// Footer destination list
	public static function getDestinationlist($limt='')
	{
		global $db;
		$cond = !empty($limit)?' LIMIT '.$limit:'';
		$sql = "SELECT slug, title, image FROM ".self::$table_name." WHERE status='1' ORDER BY sortorder DESC $cond ";
		$result = self::find_by_sql($sql);
		return $result;
	}

	// Footer destination list
	public static function getfooterDestination($limt='')
	{
		global $db;
		$cond = !empty($limit)?' LIMIT '.$limit:'';
		$sql = "SELECT slug,title FROM ".self::$table_name." WHERE status='1' ORDER BY sortorder DESC $cond ";
		$result = self::find_by_sql($sql);
		return $result;
	}

	// Destination list for activity
	public static function get_destination_option($selId=''){
		global $db;
		$sql = "SELECT id,title FROM ".self::$table_name." WHERE status='1' ORDER BY sortorder DESC";
		$destination = self::find_by_sql($sql);				
		$result='';		
		if($destination):		
			foreach($destination as $Row):
				$sel = ($selId==$Row->id) ?'selected':'';
				$result.='<option value="'.$Row->id.'" '.$sel.'>'.$Row->title.'</option>';
			endforeach;
		endif;
		return $result;
	}
	
	/************************** Destination menu link  by me ***************************/
	public static function get_internal_link($Lsel='',$LType=0){
		global $db;		
		$sql = "SELECT title, slug FROM ".self::$table_name." WHERE status='1' ORDER BY sortorder ASC";
		$pages = Destination::find_by_sql($sql);		
		$linkpageDis = ($Lsel==1)?'hide':'';
		
		$result='';		
		if($pages):
		$result.='<optgroup label="Destinations">';
			foreach($pages as $pageRow):
				$sel = ($Lsel==("destination/".$pageRow->slug)) ?'selected':'';
				$result.='<option value="destination/'.$pageRow->slug.'" '.$sel.'>&nbsp;&nbsp;'.$pageRow->title.'</option>';
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
		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status=1 ORDER BY sortorder DESC");
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
}
?>
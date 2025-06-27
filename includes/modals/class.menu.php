<?php
class Menu extends DatabaseObject {

	protected static $table_name = "tbl_menu";
	protected static $db_fields = array('id', 'name', 'linksrc','image', 'parentOf', 'status', 'sortorder', 'linktype', 'added_date', 'type', 'style', 'module', 'module_id');
	
	public $id;
	public $name;
	public $linksrc;
	public $parentOf;
	public $image;
	public $status;
	public $sortorder;
	public $linktype;
	public $added_date;
	public $style;
	public $module;
	public $module_id;
	public $type;
	
	//Find a single row in the database where id is provided.
	public static function find_by_linksrc($linksrc=''){
		global $db;
		$sql="SELECT parentOf FROM ".self::$table_name." WHERE linksrc='{$linksrc}' LIMIT 1";
		$result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	// Get the list of menu items with the parent provided
	public static function getMenuByParent($parent=0,$pos=1){
		global $db;
		$sql = "SELECT * FROM ".self::$table_name." WHERE status=1 AND parentOf='".$parent."' AND type=".$pos." ORDER BY sortorder ASC";
		return self::find_by_sql($sql);
	}
	
	// Get the parent menu id
	public static function getParentId($id=0,$top_parent=false){
		global $db;
		$result=self::find_by_sql("SELECT parentOf FROM ".self::$table_name." WHERE id=".$id." ORDER BY sortorder ASC");
		
		$parentOf=$result[0]->parentOf;
		return $parentOf;
	}
	
	// count sub menus
	public static function countHomeSubMenu($id=0){
		global $db;
		$sql = "SELECT * FROM tbl_menu WHERE parentOf='".$id."' AND status=1";
		return $db->num_rows($db->query($sql));
	}

	public static function getType_By($parentOf=''){	    
		global $db;
		$sql = "SELECT type FROM ".self::$table_name." WHERE id = $parentOf LIMIT 1";
		$result = $db->query($sql);
		$return = $db->fetch_array($result);
		return !empty($return['type']) ? $return['type'] : false;
	}

	public static function getStyle_By($parentOf=''){	    
		global $db;
		$sql = "SELECT style FROM ".self::$table_name." WHERE id = $parentOf LIMIT 1";
		$result = $db->query($sql);
		$return = $db->fetch_array($result);
		return !empty($return['style']) ? $return['style'] : false;
	}
	
	/************************** multi level menu by me ***************************/
	public static function get_parentList_bylevel($level=1,$selid=0)
	{
		global $db;
		$sql1  = "SELECT id,name FROM tbl_menu WHERE parentOf='0' ORDER BY sortorder ASC";
		$result='';
		$menuRec1 = self::find_by_sql($sql1);
		
		$result.='<select data-placeholder="None" class="chosen-select" id="parentOf" name="parentOf">';
		$result.='<option value="0">None</option>';
		/******** First level ********/
		if($menuRec1):
			foreach($menuRec1 as $menuRow1):
				$sel1 = ($selid==$menuRow1->id) ?'selected':'';
				$result.='<option value="'.$menuRow1->id.'" '.$sel1.'>'.$menuRow1->name.'</option>';			
			/******** Second level ********/	
			if($level!=1){
			$sql2 = "SELECT id,name FROM tbl_menu WHERE parentOf='".$menuRow1->id."' ORDER BY sortorder ASC";
			$menuRec2 = self::find_by_sql($sql2);				
			if($menuRec2):
				foreach($menuRec2 as $menuRow2):
					$sel2 = ($selid==$menuRow2->id) ?'selected':'';
					$result.='<option value="'.$menuRow2->id.'" '.$sel2.'>&nbsp;&nbsp;- '.$menuRow2->name.'</option>';
				/******** Third level ********/
				if($level!=2){
				$sql3 = "SELECT id,name FROM tbl_menu WHERE parentOf='".$menuRow2->id."' ORDER BY sortorder ASC";
				$menuRec3 = self::find_by_sql($sql3);	
				if($menuRec3):
					foreach($menuRec3 as $menuRow3):
						$sel3 = ($selid==$menuRow3->id) ?'selected':'';
						$result.='<option value="'.$menuRow3->id.'" '.$sel3.'>&nbsp;&nbsp;&nbsp;&nbsp;- '.$menuRow3->name.'</option>';
					/******** Fourth level ********/
					if($level!=3){
					$sql4 = "SELECT id,name FROM tbl_menu WHERE parentOf='".$menuRow3->id."' ORDER BY sortorder ASC";
				    $menuRec4 = self::find_by_sql($sql4);	
					if($menuRec4):
						foreach($menuRec4 as $menuRow4):
							$sel4 = ($selid==$menuRow4->id) ?'selected':'';
							$result.='<option value="'.$menuRow4->id.'" '.$sel4.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$menuRow4->name.'</option>';
						/******** Fifth level ********/
						if($level!=4){
						$sql5 = "SELECT id,name FROM tbl_menu WHERE parentOf='".$menuRow4->id."' ORDER BY sortorder ASC";
				    	$menuRec5 = self::find_by_sql($sql5);	
						if($menuRec5):
							foreach($menuRec5 as $menuRow5):
								$sel5 = ($selid==$menuRow5->id) ?'selected':'';
								$result.='<option value="'.$menuRow5->id.'" '.$sel5.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$menuRow5->name.'</option>';
							endforeach;
						endif;	
						}
						endforeach;
					endif;
					}
					endforeach;
				endif;
				}
				endforeach;
			endif;
			}
			endforeach;
		endif;
		$result.='</select>';		
		return $result;
	}
	
	//FIND THE HIGHEST MAX NUMBER BY PARENT ID.
	static function find_maximum_byparent($field="sortorder",$pid=""){
		global $db;
		$result = $db->query("SELECT MAX({$field}) AS maximum FROM ".self::$table_name." WHERE parentOf={$pid}");
		$return = $db->fetch_array($result);
		return ($return) ? ($return['maximum']+1) : 1 ;
	}
	
	//FIND THE HIGHEST MAX NUMBER.
	public static function find_maximum($field="sortorder"){
		global $db;
		$result = $db->query("SELECT MAX({$field}) AS maximum FROM ".self::$table_name);
		$return = $db->fetch_array($result);
		return ($return) ? ($return['maximum']+1) : 1 ;
	}
	
	// count sub menus
	public static function countSubMenu($id=0){
		global $db;
		$sql = "SELECT * FROM tbl_menu WHERE parentOf='{$id}'";
		return $db->num_rows($db->query($sql));
	}
	
	//Find all the rows in the current database table.
	public static function find_all(){
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
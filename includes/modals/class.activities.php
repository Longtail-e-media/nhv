<?php

class Activities extends DatabaseObject
{

    protected static $table_name = "tbl_activities";
    protected static $db_fields = array('id', 'slug', 'parentOf', 'destinationId', 'title', 'title_brief', 'image', 'banner_image', 'brief', 'content', 'status', 'sortorder', 'meta_keywords', 'meta_description', 'added_date');

    public $id;
    public $slug;
    public $parentOf;
    public $destinationId;
    public $title;
    public $title_brief;
    public $image;
    public $banner_image;
    public $brief;
    public $content;
    public $status;
    public $sortorder;
    public $meta_keywords;
    public $meta_description;
    public $added_date;

    // Get activities list for filter
    public static function get_activities()
    {
        global $db;
        $sql = "SELECT id, title,slug,image FROM " . self::$table_name . " WHERE status=1 ORDER BY sortorder DESC ";
        return self::find_by_sql($sql);
    }
     public static function get_activities_parent()
    {
        global $db;
        $sql = "SELECT id, title,slug,image FROM " . self::$table_name . " WHERE status=1 AND parentOf=0 ORDER BY sortorder DESC ";
        return self::find_by_sql($sql);
    }

    public static function get_actitvityby($destid = '', $parentId = '')
    {
        global $db;
        $cond = !empty($parentId) ? ' AND parentOf="' . $parentId . '" ' : ' AND parentOf="0" ';
        $sql = "SELECT * FROM " . self::$table_name . " WHERE destinationId='$destid' $cond AND status='1' ORDER BY sortorder DESC ";
        return self::find_by_sql($sql);
    }

    public static function get_id_by_slug($slug = '')
    {
        global $db;
        $sql = "SELECT id FROM " . self::$table_name . " WHERE slug='$slug' AND status='1' ORDER BY sortorder DESC ";
        return self::find_by_sql($sql);
    }

    public static function checkDupliName($title = '')
    {
        global $db;
        $query = $db->query("SELECT title FROM " . self::$table_name . " WHERE title='$title' LIMIT 1");
        $result = $db->num_rows($query);
        if ($result > 0) {
            return true;
        }
    }

    //Find a single row in the database where slug is provided.
    public static function find_by_slug($slug = 0)
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE slug='$slug' LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    // Homepage Display
    public static function homepageActivities($limit = '')
    {
        global $db;
        $lmt = !empty($limit) ? ' LIMIT ' . $limit : '';
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status='1' AND homepage='1' ORDER BY sortorder ASC $lmt";
        return self::find_by_sql($sql);
    }

    // Get total Child no.
    public static function getTotalChild($pid = '')
    {
        global $db;
        $query = "SELECT COUNT(id) AS tot FROM " . self::$table_name . " WHERE parentOf= $pid ";
        $sql = $db->query($query);
        $ret = $db->fetch_array($sql);
        return $ret['tot'];
    }

    // Activities display
    public static function getActivities($page = "")
    {
        global $db;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE name='{$page}' AND status=1 LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    //Find all by parent id the current database table.
    static function find_all_byparnt($parentId = 0)
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE parentOf=$parentId  ORDER BY sortorder DESC";
        return self::find_by_sql($sql);
    }

    //Filter all activity by destination id
    public static function get_all_filterdata($destid = 0, $selid = '')
    {
        global $db;
        $sql = "SELECT id,title FROM " . self::$table_name . " WHERE destinationId='$destid' AND parentOf=0 ORDER BY sortorder DESC";
        $record = self::find_by_sql($sql);
        $result = '';
        if ($record) {
            $result .= '<option value="0">None</option>';
            foreach ($record as $row) {
                $sel = ($selid == $row->id) ? 'selected' : '';
                $result .= '<option value="' . $row->id . '" ' . $sel . '>' . $row->title . '</option>';
            }
        } else {
            $result .= '<option value="0">None</option>';
        }
        return $result;
    }

    //Filter all activity by destination id
    public static function get_all_filterdatafront($destid = 0, $selid = '')
    {
        global $db;
        $sql = "SELECT id,title FROM " . self::$table_name . " WHERE destinationId='$destid' AND parentOf=0 ORDER BY sortorder DESC";
        $record = self::find_by_sql($sql);
        $result = '';
        if ($record) {
            $result .= '<option value="">Search Activity</option>';
            foreach ($record as $row) {
                $sel = ($selid == $row->id) ? 'selected' : '';
                $result .= '<option value="' . $row->id . '" ' . $sel . '>' . $row->title . '</option>';
            }
        } else {
            $result .= '<option value="">Search Activity</option>';
        }
        return $result;
    }

    public static function get_all_regionfront($actid = 0, $selid = '')
    {
        global $db;
        $sql = "SELECT id,title FROM " . self::$table_name . " WHERE parentOf='$actid' ORDER BY sortorder DESC";
        $record = self::find_by_sql($sql);
        $result = '';
        if ($record) {
            $result .= '<option value="">Choose Region</option>';
            foreach ($record as $row) {
                $sel = ($selid == $row->id) ? 'selected' : '';
                $result .= '<option value="' . $row->id . '" ' . $sel . '>' . $row->title . '</option>';
            }
        } else {
            $result .= '<option value="">Choose Region</option>';
        }
        return $result;
    }

    //Filter all Region by activities id
    public static function get_all_regiondata($actid = 0, $selid = '')
    {
        global $db;
        $sql = "SELECT id,title FROM " . self::$table_name . " WHERE parentOf='$actid' ORDER BY sortorder DESC";
        $record = self::find_by_sql($sql);
        $result = '';
        if ($record) {
            $result .= '<option value=" ">None</option>';
            foreach ($record as $row) {
                $sel = ($selid == $row->id) ? 'selected' : '';
                $result .= '<option value="' . $row->id . '" ' . $sel . '>' . $row->title . '</option>';
            }
        } else {
            $result .= '<option value=" ">None</option>';
        }
        return $result;
    }

    /************************** Activities menu link  by me ***************************/
    public static function get_internal_link($Lsel = '', $LType = 0)
    {
        global $db;
        $sql = "SELECT id, slug, destinationId, title FROM " . self::$table_name . " WHERE status='1' AND parentOf='0' ORDER BY sortorder ASC";
        $pages = Activities::find_by_sql($sql);
        $linkpageDis = ($Lsel == 1) ? 'hide' : '';

        $result = '';
        if ($pages):
            $result .= '<optgroup label="Activitiess">';
            foreach ($pages as $pageRow):
                $destSlug = Destination::field_by_id($pageRow->destinationId, 'slug');
                $sel = ($Lsel == ("activities/" . $destSlug . "/" . $pageRow->slug)) ? 'selected' : '';
                $result .= '<option value="activity/' . $pageRow->slug . '" ' . $sel . '>&nbsp;&nbsp;' . $pageRow->title . '</option>';

                $sql2 = "SELECT slug, destinationId, title FROM " . self::$table_name . " WHERE status='1' AND parentOf='$pageRow->id' ORDER BY sortorder ASC";
                $pages2 = Activities::find_by_sql($sql2);
                if ($pages2) {
                    foreach ($pages2 as $page2Row) {
                        $sel2 = ($Lsel == ("activity/" . $page2Row->slug)) ? 'selected' : '';
                        $result .= '<option value="activity/' . $page2Row->slug . '" ' . $sel2 . '>&nbsp;&nbsp;&nbsp;&nbsp;--' . $page2Row->title . '</option>';
                    }
                }
            endforeach;
            $result .= '</optgroup>';
        endif;
        return $result;
    }
    /*public static function get_internal_link($Lsel='',$LType=0){
        global $db;
        $sql = "SELECT id, slug, destinationId, title FROM ".self::$table_name." WHERE status='1' AND parentOf='0' ORDER BY sortorder ASC";
        $pages = Activities::find_by_sql($sql);
        $linkpageDis = ($Lsel==1)?'hide':'';

        $result='';
        if($pages):
            $result.='<optgroup label="Activitiess">';
            foreach($pages as $pageRow):
                $destSlug = Destination::field_by_id($pageRow->destinationId, 'slug');
                $sel = ($Lsel==("activities/".$destSlug."/".$pageRow->slug)) ?'selected':'';
                $result.='<option value="activities/'.$destSlug.'/'.$pageRow->slug.'" '.$sel.'>&nbsp;&nbsp;'.$pageRow->title.'</option>';

                $sql2 = "SELECT slug, destinationId, title FROM ".self::$table_name." WHERE status='1' AND parentOf='$pageRow->id' ORDER BY sortorder ASC";
                $pages2 = Activities::find_by_sql($sql2);
                if($pages2){
                    foreach($pages2 as $page2Row){
                        $sel2 = ($Lsel==("activities/".$destSlug."/".$page2Row->slug)) ?'selected':'';
                        $result.='<option value="activities/'.$destSlug.'/'.$page2Row->slug.'" '.$sel2.'>&nbsp;&nbsp;&nbsp;&nbsp;--'.$page2Row->title.'</option>';
                    }
                }
            endforeach;
            $result.='</optgroup>';
        endif;
        return $result;
    }*/

    //FIND THE HIGHEST MAX NUMBER BY PARENT ID.
    static function find_maximum_byparent($field = "sortorder", $pid = "")
    {
        global $db;
        $result = $db->query("SELECT MAX({$field}) AS maximum FROM " . self::$table_name . " WHERE parentOf={$pid}");
        $return = $db->fetch_array($result);
        return ($return) ? ($return['maximum'] + 1) : 1;
    }

    //Find all the rows in the current database table.
    public static function find_all()
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY sortorder DESC");
    }

    //Get sortorder by id
    public static function field_by_id($id = 0, $fields = "")
    {
        global $db;
        $sql = "SELECT $fields FROM " . self::$table_name . " WHERE id={$id} LIMIT 1";
        $result = $db->query($sql);
        $return = $db->fetch_array($result);
        return ($return) ? $return[$fields] : '';
    }

    //Find a single row in the database where id is provided.
    public static function find_by_id($id = 0)
    {
        global $db;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    //Find rows from the database provided the SQL statement.
    public static function find_by_sql($sql = "")
    {
        global $db;
        $result_set = $db->query($sql);
        $object_array = array();
        while ($row = $db->fetch_array($result_set)) {
            $object_array[] = self::instantiate($row);
        }
        return $object_array;
    }

    //Instantiate all the attributes of the Class.
    private static function instantiate($record)
    {
        $object = new self;
        foreach ($record as $attribute => $value) {
            if ($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    //Check if the attribute exists in the class.
    private function has_attribute($attribute)
    {
        $object_vars = $this->attributes();
        return array_key_exists($attribute, $object_vars);
    }

    //Return an array of attribute keys and thier values.
    protected function attributes()
    {
        $attributes = array();
        foreach (self::$db_fields as $field):
            if (property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        endforeach;
        return $attributes;
    }

    //Prepare attributes for database.
    protected function sanitized_attributes()
    {
        global $db;
        $clean_attributes = array();
        foreach ($this->attributes() as $key => $value):
            $clean_attributes[$key] = $db->escape_value($value);
        endforeach;
        return $clean_attributes;
    }

    //Save the changes.
    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    //Add  New Row to the database
    public function create()
    {
        global $db;
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO " . self::$table_name . "(";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if ($db->query($sql)) {
            $this->id = $db->insert_id();
            return true;
        } else {
            return false;
        }
    }

    //Update a row in the database.
    public function update()
    {
        global $db;
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();

        foreach ($attributes as $key => $value):
            $attribute_pairs[] = "{$key}='{$value}'";
        endforeach;

        $sql = "UPDATE " . self::$table_name . " SET ";
        $sql .= join(", ", array_values($attribute_pairs));
        $sql .= " WHERE id=" . $db->escape_value($this->id);
        $db->query($sql);
        return ($db->affected_rows() == 1) ? true : false;
        //return true;
    }
}

?>
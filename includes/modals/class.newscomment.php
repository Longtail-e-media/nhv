<?php

class NewsComment extends DatabaseObject
{

    protected static $table_name = "tbl_news_comment";
    protected static $db_fields = array('id', 'news_id', 'person_name', 'person_email', 'person_address', 'comment', 'status', 'image', 'sortorder', 'type', 'phone');

    public $id;
    public $news_id;
    public $person_name;
    public $person_email;
    public $person_address;
    public $status;
    public $comment;
    public $sortorder;
    public $image;
    public $type;
    public $phone;


    //GET ALL News Comment
    public static function getTotalSub($type = '')
    {
        global $db;
        $cond = !empty($type) ? ' AND news_id=' . $type : '';
        $query = "SELECT COUNT(id) AS tot FROM " . self::$table_name . " WHERE 1=1 $cond ";
        $sql = $db->query($query);
        $ret = $db->fetch_array($sql);
        return $ret['tot'];
    }

    public static function get_all_news_comment($limit = '')
    {
        global $db;
        $cond = !empty($limit) ? ' LIMIT ' . $limit : '';
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY id DESC $cond";
        return self::find_by_sql($sql);
    }

    public static function get_by_rand($type = '')
    {
        global $db;
        $cond = !empty($type) ? " AND type='$type'" : '';
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status=1 $cond ORDER BY RAND() LIMIT 1 ";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function get_alltest_by($type = '', $limit = '')
    {
        global $db;
        $cond = !empty($limit) ? ' LIMIT ' . $limit : '';
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status=1 AND type='$type' ORDER BY id DESC $cond";
        return self::find_by_sql($sql);
    }

    //Find all by parent id the current database table.
    static function find_all_byparnt($parentId = 0)
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE parentOf=$parentId  ORDER BY id DESC";
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

    public static function find_by_news($news_id)
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE news_id=$news_id AND status=1 ORDER BY sortorder DESC");
    }

    public static function checkDupliTitle($title = '')
    {
        global $db;
        $query = $db->query("SELECT title FROM " . self::$table_name . " WHERE parentOf='0' AND title='$title' LIMIT 1");
        $result = $db->num_rows($query);
        if ($result > 0) {
            return true;
        }
    }

    public static function getTotalComment($news_id = '')
    {
        global $db;
        $cond = !empty($news_id) ? ' AND news_id=' . $news_id : '';
        $query = "SELECT COUNT(id) AS tot FROM " . self::$table_name . " WHERE status=1 $cond ";
        // echo $query; die();
        $sql = $db->query($query);
        $ret = $db->fetch_array($sql);
        return $ret['tot'];
    }

    //Filter all activity by destination id
    public static function get_all_filterdata($selid = '')
    {
        global $db;
        $sql = "SELECT id,title FROM " . self::$table_name . " WHERE parentOf= 0 AND status='1' ORDER BY id DESC";
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

    //FIND THE HIGHEST MAX NUMBER.
    public static function find_maximum($field = "id")
    {
        global $db;
        $result = $db->query("SELECT MAX({$field}) AS maximum FROM " . self::$table_name);
        $return = $db->fetch_array($result);
        return ($return) ? ($return['maximum'] + 1) : 1;
    }

    //Find all the rows in the current database table.
    public static function find_all()
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " ORDER BY id n_to_ascii(domain) DESC");
    }

    //Get id by id
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


    //front end function start here
//	public static function getAllNewsComment($total=6, $offset=0){
//		global $db;
//		return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE status=1 ORDER BY id ASC LIMIT {$total} OFFSET {$offset}");
//	}
    public static function getAllNewsComment()
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY id ASC");
    }

    // GET NewsComment LIST.
    public static function getNewsCommentList($total = 5)
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY id DESC LIMIT $total");
    }

    // GET SPECIFIC NewsComment
    public static function getNewsComment($id = 0)
    {
        global $db;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} AND status=1 LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    // get total number of records published
    public static function getTotalNewsComment()
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status='1'";
        $query = $db->query($sql);
        return $db->num_rows($query);
    }
}

?>
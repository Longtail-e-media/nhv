<?php

class CombinedNews extends DatabaseObject
{

    protected static $table_name = "tbl_conbined_news";
    protected static $db_fields = array('id', 'slug', 'title', 'brief', 'content', 'image', 'gallery', 'status', 'sortorder', 'added_date', 'meta_keywords', 'display', 'event_stdate', 'event_endate', 'type', 'author', 'banner_image', 'source', 'meta_description');

    public $id;
    public $slug;
    public $title;
    public $brief;
    public $content;
    public $image;
    public $gallery;
    public $status;
    public $sortorder;
    public $added_date;
    public $meta_keywords;
    public $display;
    public $event_stdate;
    public $event_endate;
    public $type;
    public $author;
    public $banner_image;
    public $source;
    public $meta_description;

    //Find a single row in the database where slug is provided.
    public static function find_by_slug($slug = 0)
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE slug='$slug' LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    // News lists
    public static function get_news_by($limit = '')
    {
        global $db;
        $cond = !empty($limit) ? ' LIMIT ' . $limit : '';
        $sql = "SELECT id, slug, title, event_stdate, image, brief, content  FROM " . self::$table_name . " WHERE status=1 ORDER BY sortorder DESC $cond ";
        return self::find_by_sql($sql);
    }

    // Related News
    public static function getRelatednews_by($cond = '', $limit = '')
    {
        global $db;
        $cond1 = !empty($cond) ? 'AND id <> ' . $cond : '';
        $cond2 = !empty($limit) ? ' LIMIT ' . $limit : '';
        $sql = "SELECT id,title,slug,event_stdate,image FROM " . self::$table_name . " WHERE status=1 $cond1 ORDER BY event_stdate DESC $cond2 ";
        return self::find_by_sql($sql);
    }

    //FIND THE HIGHEST MAX NUMBER.
    public static function find_maximum($field = "sortorder")
    {
        global $db;
        $result = $db->query("SELECT MAX({$field}) AS maximum FROM " . self::$table_name);
        $return = $db->fetch_array($result);
        return ($return) ? ($return['maximum'] + 1) : 1;
    }

    //Find all the rows in the current database table.
    public static function find_all($limit = '')
    {
        global $db;
        $cond = !empty($limit) ? ' LIMIT ' . $limit : '';
        // return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY event_stdate DESC $cond");
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY sortorder DESC $cond");
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


    //front end function start here
    public static function getAllNews($total = 10, $offset = 0)
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY sortorder DESC LIMIT {$total} OFFSET {$offset}");
    }

    // GET NEWS LIST.
    public static function getNewsList($total = 5)
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY sortorder DESC LIMIT $total");
    }

    // GET NEWS WHICH ARE NOT BEFORE TODAY'S DATE.
    public static function getLatestNewsList($total = 3)
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY news_date DESC LIMIT $total");
    }

    // GET SPECIFIC NEWS
    public static function getNews($id = 0)
    {
        global $db;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} AND status=1 LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    // get total number of records published
    public static function getTotalNews()
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status='1'";
        $query = $db->query($sql);
        return $db->num_rows($query);
    }
}

?>
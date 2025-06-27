<?php

class Package extends DatabaseObject
{

    protected static $table_name = "tbl_package";
    protected static $db_fields = array('id', 'slug', 'title', 'image', 'destinationId', 'activityId', 'regionId', 'price', 'offers', 'offer_price', 'accomodation', 'group_size', 'transportation', 'currency', 'days', 'maptype', 'mapimage', 'mapgoogle', 'videolink', 'breif', 'overview', 'itinerary', 'incexc', 'availability', 'others', 'booking_info', 'other_info', 'guide', 'altitude', 'difficulty', 'gread', 'season', 'pdate', 'startpoint', 'endpoint', 'gallery', 'expackage', 'tags', 'featured', 'lastminutes', 'homepage', 'status', 'fixed', 'date', 'sortorder', 'added_date', 'meta_keywords', 'meta_description', 'banner_image', 'itenaryfile', 'expert_id', 'group_size_price1', 'discount1', 'group_size_price2', 'discount2', 'group_size_price3', 'discount3', 'group_size_price4', 'discount4', 'group_size_price5', 'discount5', 'color');

    public $id;
    public $slug;
    public $title;
    public $image;
    public $banner_image;
    public $destinationId;
    public $activityId;
    public $regionId;
    public $price;
    public $offers;
    public $offer_price;
    public $accomodation;
    public $group_size;
    public $transportation;
    public $currency;
    public $days;
    public $maptype;
    public $mapimage;
    public $mapgoogle;
    public $videolink;
    public $breif;
    public $overview;
    public $itinerary;
    public $incexc;
    public $availability;
    public $others;
    public $booking_info;
    public $other_info;
    public $guide;
    public $altitude;
    public $difficulty;
    public $gread;
    public $season;
    public $pdate;
    public $startpoint;
    public $endpoint;
    public $gallery;
    public $expackage;
    public $tags;
    public $featured;
    public $lastminutes;
    public $homepage;
    public $status;
    public $fixed;
    public $date;
    public $sortorder;
    public $added_date;
    public $meta_keywords;
    public $meta_description;
    public $itenaryfile;
    public $expert_id;
    public $group_size_price1;
    public $discount1;
    public $group_size_price2;
    public $discount2;
    public $group_size_price3;
    public $discount3;
    public $group_size_price4;
    public $discount4;
    public $group_size_price5;
    public $discount5;
    public $color;


    public static function get_total_activities_packages($id = '')
    {
        global $db;
        $sql = "SELECT id FROM " . self::$table_name . " WHERE status=1 AND activityId=$id ORDER BY sortorder DESC ";
        $tot = $db->num_rows($db->query($sql));
        return $tot;
    }

    // view package Front.
    static function getPackage($limit = '')
    {
        global $db;
        $cond = !empty($limit) ? ' LIMIT ' . $limit : '';
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY sortorder DESC $cond";
        return self::find_by_sql($sql);
    }

    public static function get_total_destination_packages($id = '')
    {
        global $db;
        $sql = "SELECT id FROM " . self::$table_name . " WHERE status=1 AND destinationId=$id ORDER BY sortorder DESC ";
        $tot = $db->num_rows($db->query($sql));
        return $tot;
    }

    public static function get_avg_rating($id = '')
    {
        global $db;
        $sql = "SELECT AVG(rating) 'rating' FROM tbl_review WHERE package_id = $id";
        $ratingObj = $db->fetch_object($db->query($sql));
        $rating_float = (float)$ratingObj->rating;
        $rating_floor = floor($rating_float);
        $rating = ($rating_float <= ($rating_floor + 0.5)) ? ($rating_floor + 0.5) : (ceil($rating_float));
        return $rating;
    }

    public static function get_review_num($id = '')
    {
        global $db;
        $sql = "SELECT * FROM tbl_review WHERE package_id = $id";
        $tot = $db->num_rows($db->query($sql));
        return $tot;
    }

    public static function get_total_by_activity_id($id = '')
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status=1 AND activityId = $id";
        $tot = $db->num_rows($db->query($sql));
        return $tot;
    }

    public static function get_filterpkg_by($destId = '', $activId = '', $RegnId = '')
    {
        global $db;
        $cond = !empty($destId) ? ' AND destinationId="' . $destId . '" ' : '';
        $cond2 = !empty($activId) ? ' AND activityId="' . $activId . '" ' : '';
        $cond3 = !empty($RegnId) ? ' AND regionId="' . $RegnId . '" ' : '';
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status='1' $cond $cond2 $cond3 ORDER BY sortorder ASC ";
        return self::find_by_sql($sql);
    }

    //Find a single row in the database where slug is provided.
    public static function find_by_slug($slug = 0)
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE slug='$slug' LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function get_databy_display($colname = '', $act = '', $limit = '')
    {
        global $db;
        $cond = (!empty($colname) and !empty($act)) ? ' AND ' . $colname . '="' . $act . '" ' : '';
        $cond2 = !empty($limit) ? ' LIMIT ' . $limit : '';
        $sql = "SELECT * FROM " . self::$table_name . " WHERE status=1 $cond ORDER BY sortorder ASC $cond2 ";
        $result = self::find_by_sql($sql);
        return $result;
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

    public static function get_packages()
    {
        global $db;
        $sql = "SELECT id, title FROM " . self::$table_name . " WHERE status=1 ORDER BY title ASC";
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
    public static function find_all()
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " ORDER BY sortorder ASC");
    }

    //Find a single row in the database where id is provided.
    public static function find_by_id($id = 0)
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE id={$id} LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
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

    /************************** Package menu link  by me ***************************/
    public static function get_internal_link($Lsel = '', $LType = 0)
    {
        global $db;
        $sql = "SELECT id,title, slug FROM " . self::$table_name . " WHERE status='1' ORDER BY sortorder ASC";
        $pages = self::find_by_sql($sql);
        $linkpageDis = ($Lsel == 1) ? 'hide' : '';

        $result = '';
        if ($pages):
            $result .= '<optgroup label="Package">';
            foreach ($pages as $pageRow):
                $sel = ($Lsel == ("package/" . $pageRow->slug)) ? 'selected' : '';
                $result .= '<option value="package/' . $pageRow->slug . '" ' . $sel . ' module="package" module_id="' . $pageRow->id . '">&nbsp;&nbsp;' . $pageRow->title . '</option>';
            endforeach;
            $result .= '</optgroup>';
        endif;
        return $result;
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
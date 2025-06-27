<?php

class Packagedate extends DatabaseObject
{

    protected static $table_name = "tbl_package_date";
    protected static $db_fields = array('id', 'package_id', 'package_currency', 'package_rate', 'package_date', 'package_closure', 'package_seats', 'status', 'sortorder', 'added_date');

    public $id;
    public $package_id;
    public $package_currency;
    public $package_rate;
    public $package_date;
    public $package_closure;
    public $package_seats;
    public $status;
    public $sortorder;
    public $added_date;

    public static function get_package_date($pkgid = '')
    {
        global $db;
        $sql = "SELECT package_currency, package_rate, package_date FROM " . self::$table_name . " WHERE status='1' AND package_id='$pkgid' AND package_date>=CURDATE() ORDER BY package_date ASC ";
        return self::find_by_sql($sql);
    }
     public static function get_package_date_home($pkgid = '')
    {
        global $db;
        $result_array = self::find_by_sql("SELECT id,package_currency, package_rate, package_date,package_seats FROM " . self::$table_name . " WHERE status='1' AND package_id='$pkgid' AND package_date>=CURDATE() ORDER BY package_date ASC");
        return !empty($result_array) ? array_shift($result_array) : false;
       
    }

    // homepage package list
    public static function getPackage_limit($type = 0, $limit = '')
    {
        global $db;
        $cond = !empty($limit) ? ' LIMIT ' . $limit : '';
        $sql = "SELECT * FROM " . self::$table_name . " WHERE package_id=$type AND status=1 ORDER BY package_date ASC $cond ";
        return self::find_by_sql($sql);
    }

    public static function check_availability($objectArr = array(), $pkgId = '', $pkgSize = '')
    {
        $resArr = array();
        global $db;
        foreach ($objectArr as $fixedDate) {
            $today = date('F d, Y');
            // $closure_date = date('F d, Y', strtotime($fixedDate->package_date . ' - ' . $fixedDate->package_closure . ' days'));
            $closure_date = date('F d, Y', strtotime($fixedDate->package_closure));
            $sql = "SELECT SUM(trip_pax) total FROM tbl_bookinginfo WHERE pkg_id=$pkgId AND fixed_date_id=$fixedDate->id";
            $res = $db->fetch_array($db->query($sql));
            $total = !empty($res['total']) ? $res['total'] : 0;
//            @$diff = $pkgSize - $total;
            @$diff = $fixedDate->package_seats - $total;

            if (($diff > 0) and (strtotime($closure_date) >= strtotime($today))) {
                $resArr[] .= $fixedDate->id;
            }
        }
        return $resArr;
    }

    public static function getTotalSub($package_id = '')
    {
        global $db;
        $cond = !empty($package_id) ? ' AND package_id=' . $package_id : '';
        $query = "SELECT COUNT(id) AS tot FROM " . self::$table_name . " WHERE status=1 $cond ";
        $sql = $db->query($query);
        // pr($sql);
        $ret = $db->fetch_array($sql);
        return $ret['tot'];
    }

    //FIND THE HIGHEST MAX NUMBER.
    public static function find_maximum($field = "sortorder")
    {
        global $db;
        $result = $db->query("SELECT MAX({$field}) AS maximum FROM " . self::$table_name);
        $return = $db->fetch_array($result);
        return ($return) ? ($return['maximum'] + 1) : 1;
    }

    //FIND THE HIGHEST MAX NUMBER BY PARENT ID.
    static function find_maximum_byparent($field = "sortorder", $pid = "")
    {
        global $db;
        $result = $db->query("SELECT MAX({$field}) AS maximum FROM " . self::$table_name . " WHERE package_id={$pid}");
        $return = $db->fetch_array($result);
        return ($return) ? ($return['maximum'] + 1) : 1;
    }

    //Find all the rows in the current database table.
    public static function find_all()
    {
        global $db;
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE status=1 ORDER BY package_date ASC");
    }

    //Find a single row in the database where id is provided.
    public static function find_by_id($id = 0)
    {
        global $db;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} LIMIT 1");
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
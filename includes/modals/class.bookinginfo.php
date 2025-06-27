<?php

class Bookinginfo extends DatabaseObject
{

    protected static $table_name = "tbl_bookinginfo";
    protected static $db_fields = array('id', 'pkg_id', 'fixed_date_id', 'trip_date', 'date_rate', 'trip_currency', 'trip_pax', 'trip_flight', 'accesskey', 'person_title', 'person_fname', 'person_mname', 'person_lname', 'person_email', 'person_country', 'person_country_code', 'person_city', 'person_address', 'person_postal', 'person_phone', 'person_ctype', 'person_hear', 'person_comment', 'ip_address', 'pay_type', 'pay_by', 'pay_amt', 'transaction_code', 'status', 'sortorder', 'added_date', 'confirm_ip', 'confirm_date');

    public $id;
    public $pkg_id;
    public $fixed_date_id;
    public $trip_date;
    public $date_rate;
    public $trip_currency;
    public $trip_pax;
    public $trip_flight;
    public $accesskey;
    public $person_title;
    public $person_fname;
    public $person_mname;
    public $person_lname;
    public $person_email;
    public $person_country;
    public $person_country_code;
    public $person_city;
    public $person_address;
    public $person_postal;
    public $person_phone;
    public $person_ctype;
    public $person_hear;
    public $person_comment;
    public $ip_address;
    public $pay_type;
    public $pay_by;
    public $pay_amt;
    public $transaction_code;
    public $status;
    public $sortorder;
    public $added_date;
    public $confirm_ip;
    public $confirm_date;

    //Find a single row in the database where slug is provided.
    public static function find_by_tranid($tranid = 0)
    {
        global $db;
        $sql = "SELECT * FROM " . self::$table_name . " WHERE accesskey='$tranid' LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
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
        return self::find_by_sql("SELECT * FROM " . self::$table_name . " ORDER BY sortorder DESC");
    }

    //Find a single row in the database where id is provided.
    public static function find_by_id($id = 0)
    {
        global $db;
        $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_token($token = '')
    {
        $sql = "SELECT * FROM " . self::$table_name . " WHERE accesskey='$token' AND status<>'1' LIMIT 1 ";
        $result = self::find_by_sql($sql);
        return !empty($result) ? array_shift($result) : false;
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
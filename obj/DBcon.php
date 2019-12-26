<?php

/**
 * @author : Darwin Buelo
 */
class DBcon
{
    //define the variable needed
    public static $host = 'localhost';
    public static $username = 'root';
    public static $password = '';
    public static $dbname = '';
    public static $conn;
    static $error;

    //Connect to the database
    public static function connect()
    {
        try {
            static::$conn = mysqli_connect(static::$host, static::$username, static::$password, static::$dbname);
        } catch (Exception $e) {
            static::$error = $e;
            echo "<pre>".$e."</pre>";
        }
    }

    //select data from the table
    function select($table, $data = null, $value = null)
    {
        $this->connect();
        $value = $this->clean($value);
        if ($value !== "" and $data !== "") {
            $query = "SELECT * FROM $table WHERE $data=$value";
        } else {
            $query = "SELECT * FROM $table";
        }
        if ($result = mysqli_query($this->conn, $query)) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return "error";
        }
        $this->close();
    }

    public static function update($table, $data, $where = [])
    {
        $sql = "UPDATE {$table} SET ";
        $x = 1;
        foreach ($data as $key => $value) {
            if ($x === count($data)) {
                $sql .= " {$key} = '{$value}' ";
            } else {
                $sql .= " {$key} = '{$value}', ";
            }
            $x++;
        }
        $sql .= "WHERE true ";
        foreach ($where as $key => $value) {
            $sql .= " AND {$key} = '{$value}'";
        }
        return self::execute($sql);
    }

    /**
     *  Insert data into
     * @param $table name of table
     * @param $data
     * @return bool|int|string
     */
    public static function insert($table, $data)
    {
        $fields = implode(',', array_keys($data));
        $data = implode("','", $data);

        $query = "INSERT INTO {$table} ({$fields}) VALUES ('{$data}')";
        try {
            self::connect();
            mysqli_query(self::$conn, $query);
            return mysqli_insert_id(self::$conn);
        } catch (Exception $e) {
            self::$error = mysqli_error(self::$conn);
            return false;
        }
    }

    public static function execute($query)
    {
        self::connect();
        if ($result = mysqli_query(self::$conn, $query)) {
            return $result;
        } else {
            self::$error = mysqli_error(self::$conn);
            return false;
        }
    }

    public static function fetch_all_assoc($object)
    {
        //handle database object
        if (!empty($object)) {
            $result = mysqli_fetch_all($object, MYSQLI_ASSOC);
            mysqli_free_result($object);
            static::close();
            return $result;
        }
    }

    public static function fetch_all_array($object)
    {
        //handle database object
        if (!empty($object)) {
            $result = mysqli_fetch_all($object, MYSQLI_NUM);
            mysqli_free_result($object);
            static::close();
            return $result;
        }
    }

    public function fetch_array($object)
    {
        //handle database object
        if (!empty($object)) {
            $result = mysqli_fetch_array($object, MYSQLI_NUM);
            mysqli_free_result($object);
            static::close();
            return $result;
        }
    }

    public static function fetch_assoc($object)
    {
        //handle database object
        if (!empty($object)) {
            $result = mysqli_fetch_assoc($object);
            mysqli_free_result($object);
            self::close();
            return $result;
        }
    }

    public function fetch_row($object)
    {
        if (!empty($object)) {
            $result = mysqli_fetch_row($object);
            mysqli_free_result($object);
            self::close();
            return $result;
        }
    }

    //delete the file from database
    public static function delete($table, $where)
    {
        $query = "DELETE FROM {$table} WHERE true ";
        foreach ($where as $key => $value) {
            $query .= "AND {$key} = '{$value}' ";
        }
        self::execute($query);
    }

    //just making debug easier
    function debug($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

    //clean the data before posting it to the data base
    public static function clean($x)
    {
        self::connect();
        if ($x <> null) {
            $x = stripcslashes($x);
            $x = mysqli_real_escape_string(self::$conn, $x);
            return $x;
        } else {
            return false;
        }
    }

    public static function close()
    {
        mysqli_close(self::$conn);
    }

    //destroy the connection everytime the page is closed
    function __destruct()
    {
        mysqli_close($this->conn);
    }

    function page_selectAll($offset = 1, $rowsperpage = 1)
    {
        $query = 'SELECT * FROM content LIMIT 3 OFFSET 0';
        $data = mysqli_fetch_assoc($this->execute($query));
        return $data;
    }
}
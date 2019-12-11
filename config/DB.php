<?php
class DB
{
    //DB stuff
    private $host = 'localhost';
    private $db_name = 'serves';
    private $username = 'root';
    private $password = '';

    //set the pro type
    private static $_instance;
    private $_pdo,
        $_query,
        $_error = false,
        $_count = 0,
        $_result,
        $_single;

    //make the construct method
    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        } catch (PDOException $e) {
            //set the error
            die($e->getMessage());
        }
    }
    //make the instice method
    public static function getInstace()
    {
        //check the instance isset
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    //make the query method
    public function query($sql, $param = array())
    {
        $this->_error = false;
        //check the query preapre
        if ($this->_query = $this->_pdo->prepare($sql)) {
            //check the param is found
            if (count($param)) {
                $x = 1;
                //loop throw it
                foreach ($param as $p) {
                    $this->_query->bindvalue($x, $p);
                    $x++;
                }
            }
            //exceute the query
            if ($this->_query->execute()) {
                //get the fetch data

                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }
    //make the method error
    public function error()
    {
        return  $this->_error;
    }
    //  make the action method
    public function action($action, $table, $where = array())
    {
        //check the count of where
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            //check the operatotr in aarry operators
            if (in_array($operator, $operators)) {
                //make the sql
                // $sql="selcet * from users where id=1";
                $sql = "{$action}  from {$table} where {$field} {$operator} ? ";
                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }
    //make the insert method
    public function insert($table, $fields = array())
    {
        //check the count of fields
        if (count($fields)) {
            //set the filed to key arry
            $keys = array_keys($fields);
            $values = '';
            $x = 1;
            //loop throw the fields
            foreach ($fields as $field) {
                $values .= '?';
                //check the $x count< fields
                if ($x < count($fields)) {
                    $values .= ', ';
                }
                $x++;
            }
            //make the sql
            $sql = "INSERT into {$table} (`" . implode('`,`', $keys) . "`)values({$values})";
            //prepare the query
            //execute the query
            if (!$this->query($sql, $fields)->error()) {
                return true;
            }
        }
        return false;
    }
    //make the update method
    public function update($table, $row, $id, $fields)
    {
        $set = '';
        $x = 1;

        //loop throw the field
        foreach ($fields as $name => $value) {
            $set .= "{$name}=?";
            if ($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }
        //make the sql
        $sql = "UPDATE {$table} set {$set} where {$row}={$id}";

        //execute thesql
        if (!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }
    //make the result method
    public function result()
    {
        return $this->_result;
    }
    public function single()
    {
        return $this->_single;
    }

    //make the first method
    public function first()
    {
        return $this->result()[0];
    }

    //make the getmethod
    public function get($table, $where)
    {
        return $this->action("select *", $table, $where);
    }
    //make the function to get all data
    public function All($table)
    {
        return $this->query("SELECT * from {$table}");
    }
    //make the delete method
    public function delete($table, $where)
    {
        return $this->action("delete", $table, $where);
    }

    //make the count method
    public function count()
    {
        return $this->_count;
    }
}

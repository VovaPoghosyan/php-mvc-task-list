<?php
class Model
{
    protected $table;
    protected $DB;
    protected $sqlString;
    public    $lastQuery;
    public    $links;

    public function __construct()
    {
        if(!$this->table) {
            $current_class = get_class($this);
            $this->table   = strtolower($current_class);
        }
        $this->DB = $this->connect();
    }

    private function connect()
    {
        $config     = parse_ini_file(CONFIG."app.ini");
        $connection = new Db($config['DBHost'], $config['DBPort'], $config['DBName'], $config['DBUser'], $config['DBPassword']);
        return $connection;
    }

    public function query($sql=null)
    {
        if(!empty($sql)) {
            $this->lastQuery = $sql;
        } else {
            $sql             = $this->sqlString;
            $this->lastQuery = $sql;
        }
        return $this->DB->query($sql);
    }

    public function get($table=0, $what = "*")
    {
        if(is_array($what)) {
            $what = implode(",", $what);
        } else {
            $what = "*";
        }
        if($table) {
            $this->table=$table;
        }
        $this->sqlString = "SELECT $what FROM $this->table ";
        return $this;
    }

    public function all()
    {
        $this->sqlString.=" WHERE 1";
        return $this;
    }

    public function simple($data=array())
    {
        foreach ($data as $key => $value)
        {
            $condArray[] = "`".$key."`='".$value."'";
        }
        $condition       = implode(" AND ", $condArray);
        $this->sqlString.=" WHERE $condition";
        return $this;
    }

    public function insert($data = array())
    {
        if(is_array($data) && !empty($data)) {
            $fieldsArray = [];
            $valuesArray = [];
            foreach ($data as $key => $value)
            {
                $fieldsArray[] = "`".$key."`";
                $valuesArray[] = "'".$value."'";
            }
        } else {
            return false;
        }
        $fields = implode(",", $fieldsArray);
        $values = implode(",", $valuesArray);
        $sql    = "INSERT INTO `$this->table` ($fields) VALUES ($values)";
        if($this->query($sql)) {
            return $this->DB->insert_id;
        } else {
            die(mysqli_errno($this->DB));
        }
        return false;
    }

    public function update($data = array(), $whereArray = array())
    {
        if(is_array($data) && is_array($whereArray) && !empty($data) && !empty($whereArray)) {
            $fieldsArray = [];
            $condArray   = [];
            foreach ($data as $key => $value)
            {
                $fieldsArray[] = "`".$key."`='".$value."'";
            }
            foreach ($whereArray as $key => $value)
            {
                $condArray[] = "`".$key."`='".$value."'";
            }
        } else {
            return false;
        }
        $fields    = implode(",", $fieldsArray);
        $condition = implode(" AND ", $condArray);
        return $this->query("UPDATE $this->table SET $fields WHERE $condition");
    }

    public function delete($data = array())
    {
        if (is_array($data) && !empty($data)) {
            foreach($data as $key => $value)
            {
                $condArray[] = $key."='".$value."'";
            }
        } else {
            return false;
        }
        $condition = implode(" AND ", $condArray);
        return $this->query("DELETE FROM $this->table WHERE $condition");
    }

    public function save($data = array(), $where= array())
    {
        if(is_array($data) && is_array($where) && !empty($data) && !empty($where)) {
            if($this->get()->simple($data)->query()) {
                return $this->update($data, $where);
            } else {
               return $this->insert($data);
            }
        } else {
            return false;
        }
    }

    public function fetch()
    {
        $response = $this->query();
        return $response->fetch_assoc();
    }

    public function fetchAll()
    {
        $data       = [];
        $response   = $this->query();
        while ($row = $response->fetch_assoc())
        {
            $data[] = $row;
        }
        return $data;
    }

    public function limit($pageSize, $offset = 0)
    {
        $this->sqlString .= " LIMIT $offset, $pageSize";
        return $this;
    }

}
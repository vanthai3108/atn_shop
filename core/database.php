<?php

class database {
    protected $connect;
    protected $table;
    protected $column;

    public function __construct(){
        global $db_host, $db_user, $db_pass, $db_name;
        $this->connect = new mysqli($db_host, $db_user, $db_pass, $db_name);
        if ($this->connect->connect_errno){
            die('Connection Failed!');
        }
        // $this->connect->set_charset("utf8");
        mysqli_set_charset($this->connect, 'UTF8');
    }

    public function resetQuery(){
        $this->table = '';
        $this->column = '';
    }

    public function table($table){
        $this->table = $table;
        return $this;
    }

    public function columnId($column){
        $this->column = $column;
        return $this;
    }

    public function param_type($value){
        $types = '';
        if(is_string($value)){
            $types = 's';
        }
        elseif (is_int($value)){
            $types = 'i';
        }
        elseif (is_double($value)){
            $types = 'd';
        }
        else {
            $types = 'b';
        }
        return $types;
    }

    public function param_types($data){
        $types = '';
        foreach($data as $key => $value){
            $type = $this->param_type($value);
            $types .= $type;
        }
        return $types;
    }

    public function check($data){
        $keyValues = [];
        foreach ($data as $key => $value){
            $keyValues[] = $key .' = ?';
        }
        $setFields = implode(' AND ', $keyValues);
        $sql = "SELECT * FROM $this->table WHERE $setFields";
        $query = $this->connect->prepare($sql);
        $types = $this->param_types($data);
        $query->bind_param($types, ...array_values($data));
        $query->execute();
        $result = $query->get_result();
        $this->resetQuery();
        $check_status = $result->fetch_array();
        return $check_status;
    }

    public function getAll(){
        $sql = "SELECT * FROM $this->table";
        $query = $this->connect->prepare($sql);
        $query->execute();
        $this->resetQuery();
        $result = $query->get_result();
        $data = [];
        while ($row = $result->fetch_object()){
            $data[] = $row;
        }
        return $data;
    }

    public function get($limit, $offset){
        $sql = "SELECT * FROM $this->table LIMIT ? OFFSET ?";
        $query = $this->connect->prepare($sql);
        $query->bind_param('ii', $limit, $offset);
        $query->execute();
        $this->resetQuery();
        $result = $query->get_result();
        $data = [];
        while ($row = $result->fetch_object()){
            $data[] = $row;
        }
        return $data;
    }

    public function getWhere($column, $value, $limit, $offset){
        $sql = "SELECT * FROM $this->table WHERE $column = ?  LIMIT ? OFFSET ?";
        $query = $this->connect->prepare($sql);
        $type = $this->param_type($value);
        $type .= 'ii';
        $query->bind_param($type, $value, $limit, $offset);
        $query->execute();
        $this->resetQuery();
        $result = $query->get_result();
        $data = [];
        while ($row = $result->fetch_object()){
            $data[] = $row;
        }
        return $data;
    }

    public function getWhereOne($column, $value){
        $sql = "SELECT * FROM $this->table WHERE $column = ?";
        $query = $this->connect->prepare($sql);
        $type = $this->param_type($value);
        $query->bind_param($type, $value);
        $query->execute();
        $this->resetQuery();
        $result = $query->get_result();
        $data = $result->fetch_object();
        return $data;
    }

    public function getWhereAll($column, $value){
        $sql = "SELECT * FROM $this->table WHERE $column = ?";
        $query = $this->connect->prepare($sql);
        $type = $this->param_type($value);
        $query->bind_param($type, $value);
        $query->execute();
        $this->resetQuery();
        $result = $query->get_result();
        $data = [];
        while ($row = $result->fetch_object()){
            $data[] = $row;
        }
        return $data;
    }

    public function getLike($column, $value, $limit, $offset){
        $sql = "SELECT * FROM $this->table WHERE $column LIKE ? LIMIT ? OFFSET ?";
        $query = $this->connect->prepare($sql);
        $value = "%".$value."%";
        $type = $this->param_type($value);
        $type .= 'ii';
        $query->bind_param($type, $value, $limit, $offset);
        $query->execute();
        $this->resetQuery();
        $result = $query->get_result();
        $data = [];
        while ($row = $result->fetch_object()){
            $data[] = $row;
        }
        return $data;
    }

    public function count(){
        $sql = "select count(*) as Total from $this->table";
        $query = $this->connect->prepare($sql);
        $query->execute();
        $this->resetQuery();
        $result = $query->get_result();
        $resultObject = $result->fetch_object();
        $total = $resultObject->Total; 
        return $total;
    }

    public function countWhere($column, $value){
        $sql = "SELECT COUNT(*) AS Total FROM $this->table WHERE $column = ?";
        $query = $this->connect->prepare($sql);
        $type = $this->param_type($value);
        $query->bind_param($type, $value);
        $query->execute();
        $this->resetQuery();
        $result = $query->get_result();
        $resultObject = $result->fetch_object();
        $total = $resultObject->Total; 
        return $total;
    }

    public function countLike($column, $value){
        $sql = "SELECT COUNT(*) AS Total FROM $this->table WHERE $column LIKE ? ";
        $query = $this->connect->prepare($sql);
        $value = "%".$value."%";
        $type = $this->param_type($value);
        $query->bind_param($type, $value);
        $query->execute();
        $result = $query->get_result();
        $this->resetQuery();
        $resultObject = $result->fetch_object();
        $total = $resultObject->Total; 
        return $total;
    }

    public function insert($data){
        $sql = "INSERT INTO $this->table";
        $sql .= "(".implode(', ', array_keys($data)) . ")". " VALUES";
        $values_sql = array_fill(0, count($data), '?');
        $sql .= "(".implode(', ', array_values($values_sql)) . ")";
        $query = $this->connect->prepare($sql);
        $types = $this->param_types($data);
        $query->bind_param($types, ...array_values($data));
        $result = $query->execute();
        $this->resetQuery();
        return $result;
    }

    public function update($id, $data){
        $keyValues = [];
        foreach ($data as $key => $value){
            $keyValues[] = $key .' = ?';
        }
        $setFields = implode(',', $keyValues);
        $sql = "UPDATE $this->table SET $setFields WHERE $this->column = ?";
        print_r($sql);
        $query = $this->connect->prepare($sql);
        $types = $this->param_types($data);
        print_r($types);
        $types .= 'i';
        $values = array_values($data);
        
        $values[] = $id;
        print_r($values);
        $query->bind_param($types,...$values);
        $result = $query->execute();
        $this->resetQuery();
        return $result;
    }

    public function delete($id){
        $sql = "DELETE FROM $this->table WHERE $this->column = ?";
        $query = $this->connect->prepare($sql);
        $query->bind_param('i', $id);
        $result = $query->execute();
        $this->resetQuery();
        return $result;
    }

    public function pagination($url, $page, $totalPages){
        echo "
        <div class='row d-flex justify-content-center' id='page'>
            <nav aria-label='...'>
                <ul class='pagination'>
                    <li class='page-item ";
                    if ($page == 1) {
                        echo" disabled";
                    }
        echo "'><a class='page-link' ";
        $page = $page - 1;
        echo" href='$url?page=$page'>Previous</a></li>";
        for ($i = 1; $i<= $totalPages; $i++){
            echo " <li class='page-item ";
            $page = $_GET['page'] ?? 1;
                if ($page == $i) {
                    echo" active";
                    print_r($page, $i);
                }
            echo"'><a class='page-link' href='$url?page=$i'> $i </a></li>";
        }
        echo "<li class='page-item ";
        if ($page == $totalPages) {
            echo" disabled";
        }
        echo "'><a class='page-link' ";
        $page = $page + 1;
        echo" href='$url?page=$page' ";
        echo "
                  >Next</a>
              </li>
            </ul>
        </nav>
        </div>
        ";
        $this->resetQuery();
    }
}
?>
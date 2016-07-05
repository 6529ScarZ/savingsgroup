<?php
require 'connPDO_db.php';
class DbPDO_mng extends ConnPDO_DB{

    private $sql;
    
    public function imp_sql($sql) {
        $this->sql=$sql;
    }
	//	  ฟังก์ชันสำหรับคิวรี่คำสั่ง sql
    function query($sql) {
        $this->sql=$sql;
        $db=$this->conn_PDO();
        $this->db=$db;
        try
		{
            $query=$this->db->prepare($this->sql); 
            $query->execute();
            return true;
        } catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
    }

//    ฟังก์ชัน select ข้อมูลในฐานข้อมูลมาแสดง
    function select() {
        //$this->sql=$sql;
        $this->db=$this->conn_PDO();
        $result = array();
        try
		{
        $data = $this->db->prepare($this->sql);
        $data->execute(); 
                } catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
                if($data->rowCount()>0)
		{
        while ($data_out = $data->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $data_out;
                }
                       }
        return $result;
    }

//    ฟังก์ชันสำหรับการ insert ข้อมูล
    function insert($table, $data) {
        $this->table = $table;
        $this->data = $data;
        $this->db=$this->conn_PDO();
        $fields = "";
        $values = "";
        $var = $this->listfield($this->table); //การใช้งาน function ใน class เดียวกัน
        print_r($var);
        $i = 0;
        array_shift($var); //เอาค่าของ array ตัวแรกออก
        foreach ($this->data as $key => $val) {
            if ($i != 0) {
                $fields.=", ";
                $values.=", ";
            }
            $fields.="$var[$key]";
            $values.="'$val'";
            $i++;
        }
        $this->sql = "INSERT INTO $this->table ($fields) VALUES ($values)";
        try
		{
        $data = $this->db->prepare($this->sql);
        $data->execute(); 
                } catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
    }

//    ฟังก์ชันสำหรับการ update ข้อมูล
    function update($table, $data, $where, $field) {
        $this->table = $table;
        $this->data = $data;
        $this->where = $where;
        if(!empty($field)){ $this->field = $field;}
        $db=$this->conn_mysqli();
        $modifs = "";
        $i = 0;
        if(empty($this->field)){
        $var = $this->listfield($this->table,''); //การใช้งาน function ใน class เดียวกัน
        array_shift($var); //เอาค่าของ array ตัวแรกออก
        }else{
            $var=  $this->field;
        }
        foreach ($this->data as $key => $val) {
            if ($i != 0) {
                $modifs.=", ";
            }
            if (is_numeric($val)) {
                $modifs.=$var[$key] . '=' . $val;
            } else {
                $modifs.=$var[$key] . ' = "' . $val . '"';
            }
            $i++;
        }
        $sql = ("UPDATE $this->table SET $modifs WHERE $this->where");
        if ($db->query($sql)) {
            return true;
        } else {
            die("SQL Error: <br>" . $sql . "<br>" . $db->error);
            return false;
        }
    }

//    ฟังก์ชันสำหรับการ delete ข้อมูล
    function delete($table, $where) {
        $this->table = $table;
        $this->where = $where;
        $db=$this->conn_mysqli();
        $sql = "DELETE FROM $this->table WHERE $this->where";
        if ($db->query($sql)) {
            return true;
        } else {
            die("SQL Error: <br>" . $sql . "<br>" . $db->error);
            return false;
        }
    }

//    ฟังก์ชันสำหรับแสดงรายการฟิลด์ในตาราง
    function listfield($table) {
        $this->db=$this->conn_PDO();
        if(!empty($table)){$this->sql = "SELECT * FROM $table LIMIT 1 ";}
 try{
        $data = $this->db->prepare($this->sql);
        $data->execute(); 
                } catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
                if($data->rowCount()>0){
        while ($data_out =  $data->fetch(PDO::FETCH_ASSOC)) {
            $var = array_keys($data_out);
                }}
        return $var;
    }
    
    function count_field(){
        $this->db=$this->conn_PDO();
        try{
        $data = $this->db->prepare($this->sql);
        $data->execute(); 
                } catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
        $num_fields = $data->columnCount();
        return $num_fields;
    }

}

?>
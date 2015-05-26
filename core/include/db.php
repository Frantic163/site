<?php
class db{
    private $_db;
    public static $mysqli = null;

    private function __construct(){
        $ob_mysqli = @new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if(!$ob_mysqli->connect_error){
                $this->_db = $ob_mysqli;
                $this->_db->query("SET NAMES 'utf8'");
                return $this->_db;
        }else{
                exit("No connect to server");
        }
    }

    public static function getObject(){
        if(self::$mysqli == null){
            $obj = new db();
            self::$mysqli = $obj;
        }
        return self::$mysqli;
    }

    public function getTableName($table){
        return DBPREF.$table;
    }

    public function query($sql){
        return $this->_db->query($sql);
    }

    /* SELECT */
    public function select($table, $params = false, $where = false, $and = false, $sign = false, $sort = false, $limit = false){
        $table_name = $this->getTableName($table);
        
        $sql = "SELECT ";
        
        if(!$params){
            $param = "*";
        } else {
            //$params = $this->real_escape_string($params);
            $param = "";
            foreach($params as $values_param){
               $param .= "`".$values_param."`, ";
            }
            $param = substr($param, 0, -2);
        }
        
       $sql .= $param." FROM ".$table_name;

        if($where){
            if(!$sign){
                $sign = "=";
            }

           if($and){
               $values_where = "";
                foreach($where as $key_where => $params_where){
                    if($and == "and"){
                        $values_where .= "`".$key_where."` ".$sign." '".$params_where."' AND ";
                    }elseif($and == "or"){
                        $values_where .= "`".$key_where."` ".$sign." '".$params_where."' OR ";
                    }
                }
                $values_where = substr($values_where, 0, -5);
            }else{
                foreach($where as $key_where => $params_where){
                    $values_where .= "`".$key_where." ".$sign." '".$params_where."'";
                }
            }    
            $sql .= " WHERE ".$values_where."";
        }

        if($sort){
             foreach($sort as $key_sort => $params_sotr){
                $values_sort = $key_sort." ".$params_sotr." ";
            }
            $sql .= " ORDER BY ".$values_sort;
        }

        if($limit){
            if(is_array($limit)){
                foreach($limit as $start => $end){
                    $values_limit = $start.", ".$end;
                } 
            } else {
                $values_limit = $limit; 
            }

            $sql .= "LIMIT ".$values_limit;
        }

        return $this->query($sql);
    } 
    /* END SELECT */

    /* UPDATE */
    public function update($field, $param, $table, $where = false, $param_where = false){
        $table_name = $this->getTableName($table);
        $param = $this->real_escape_string($param);
        $param_where = $this->real_escape_string($param_where);

        $sql = "UPDATE ".$table_name." SET ".$field." = '".$param."'";

        if($where){
            $sql .= " WHERE ".$where." = '".$param_where."'";
        }

        $this->query($sql);
    }
    /* END UPDATE */

    /* INSERT */
    public function insert($table, $row){
        if(count($row) == 0) return false;
        $table_name = $this->getTableName($table);

        $params = array();
        $fields = "(";
        $values = "VALUES (";


        foreach($row as $key => $params){
            $fields .= "'$key', ";
            $values .= "'$params', ";
        }

        $fields = substr($fields, 0, -2);
        $values = substr($values, 0, -2);
        $fields .= ") ";
        $values .= ")";

        $sql = "INSERT INTO ".$table." ".$fields.$values;

        $this->query($sql);
    }

    /* END INSERT */


    /* DELETE */
    public function delete($table, $where = false){
        $table_name = $this->getTableName($table);
        $sql = "DELETE FROM ".$table_name." ";
        if($where){
            $sql .= "WHERE ".$where;
        }

        $this->query($sql);
    }
    /* END DELETE */


    public function assoc($result){
        return $result->fetch_assoc();
    }

    public function row($result){
        return $result->fetch_row();
    }

    public function real_escape_string($string){
        return $this->_db->real_escape_string($string);
    }

    public function __destruct(){
        if(($this->_db) && (!$this->_db->connect_errno)) $this->_db->close();
    } 
    }


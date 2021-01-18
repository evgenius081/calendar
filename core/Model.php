<?php


class Model{
    private static $instance;
    private $db;
    private $table;
    private $placeholder;
    private $where;
    private $col = " * ";
    private $fields;


    public function __construct(){
        $this->db = new PDO('mysql: host=localhost;dbname=exp', 'root', '');
    }

    public static function setInstance()
    {
        if(!self::$instance instanceof self){
            self::$instance = new Model();
        }
        return self::$instance;
    }

    public function query(string $sql, array $params = [])
    {
        $stm = $this->db->prepare($sql);
        foreach ($params as $param => $value) {
            $stm->bindParam($param, $value);
        }
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function table($table = null) : Model{
        if($table === null){
            $table = substr(get_class($this), strpos(get_class($this), '\\') +1);
        }else
        $table = strtolower($table);
        $this->table = $table;
        return $this;
    }

    public function from($col){
        $this->col = $col;
        return $this;
    }

    public function where(string $col, string $char, string $param){
        $this->where=' WHERE '.$col.$char.":".$col;
        $this->placeholder[':'.$col] = $param;
        return $this;
    }

    public function getAll() : array{
        $sql = 'SELECT '.$this->col.' FROM '. $this->table;
        if($this->where){
            $sql .=  $this->where;
        }
        return $this->query($sql, $this->placeholder);
    }

    public function delete(){
        $sql = 'DELETE FROM '. $this->table;
        if($this->where){
            $sql .=  $this->where. ' ';
        }
        return $this->query($sql, $this->placeholder);
    }

    public function set($params){
        $sql = 'INSERT INTO '.$this->table." ".$this->col.' VALUES ("';
        foreach ($params as $param) {
            if($param === $params[count($param)]){
                $sql .= $param;
            }else{
                $sql .= $param.'" , "';
            }
        }
        $sql .= '")';
        return $this->query($sql);
    }

    public function getOne()
    {
        return $this->getAll()[0];
    }

}
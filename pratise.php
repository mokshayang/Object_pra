<?php
session_start();
date_default_timezone_set("Asia/Taipei");

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

class DB
{
    protected $table;
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=opinion";
    protected $pdo;
    function __construct($table)
    {
        $this->pdo = new PDO($this->dsn,'root','');
        $this->table = $table;
    }
    private function arrayToSqlArray($array){
        foreach ($array as $key => $value) {
            $tmp[] = "`$key`='$value'";
        }
        return $tmp;
    }
    function mathSql($math,$col,...$arg){
        $sql = "select $math($col) from $this->table where ";
        if(isset($arg[0])){
            if(is_array($arg[0])){
                $tmp = $this->arrayToSqlArray($arg[0]);
                $sql .= join(" && ",$tmp);
            }else{
                $sql .= $arg[0];
            }
        }
        if(isset($arg[1])){
            $sql .= $arg[1];
        }
        return $sql;
    }
    function all(...$arg){
        $sql = "select * from $this->table where ";
        if(isset($arg[0])){
            if(is_array($arg[0])){
                $tmp = $this->arrayToSqlArray($arg[0]);
                $sql .= join(" && ",$tmp);
            }else{
                $sql .= $arg[0];
            }
        }
        if(isset($arg[1])){
            $sql .= $arg[1];
        }
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    function find($id){
        $sql = "select * from $this->table where ";
        if(is_array($id)){
            $tmp = $this->arrayToSqlArray($id);
            $sql .= join(" && ",$tmp);
        }else{
            $sql .= " `id`=$id";
        }
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    function del($id){
        $sql = "delete from $this->table where ";
        if(is_array($id)){
            $tmp = $this->arrayToSqlArray($id);
            $sql .= join(" && ",$tmp);
        }else{
            $sql .= " `id`=$id";
        }
        return $this->pdo->exec($sql);
    }
    function save($array){
        if(isset($array['id'])){
            $id = $array['id'];
            unset($array['id']);
            $tmp = $this->arrayToSqlArray($array);
            $sql = "update $this->table set " ;
            $sql .=  join(",",$tmp);
            $sql .= " where `id`=$id" ;
        }else{
            $col = array_keys($array);
            $sql = "insert into $this->table (`" . join("`,`",$col)."`)
            values ('" . join("','",$array)."')";
        }
        dd($sql);
    }
    function count(...$arg){
        $sql = $this->mathSql("count","*",...$arg);
        dd($sql);
        return $this->pdo->query($sql)->fetchColumn();
    }
    function sum($col,...$arg){
         $sql = $this->mathSql("sum",$col,...$arg);
        dd($sql);
        return $this->pdo->query($sql)->fetchColumn();       
    }
    function min($col,...$arg){
        $sql = $this->mathSql("min",$col,...$arg);
        dd($sql);
        return $this->pdo->query($sql)->fetchColumn();
    }
    function max($col,...$arg){
        $sql = $this->mathSql("max",$col,...$arg);
        dd($sql);
        return $this->pdo->query($sql)->fetchColumn();
    }
    function avg($col,...$arg){
        $sql = $this->mathSql("avg",$col,...$arg);
        dd($sql);
        return $this->pdo->query($sql)->fetchColumn();
    }
   
}

$users=new DB("users_hw");
// // $all = $users->all(['id'=>6]);
//$find = $users->find(['id'=>6]);
// $save = $users->save(['pw'=>'123','name'=>'564']);
// // dd($all);
// // dd($del);
// $a=$users->count(['pw'=>123]);
// $del=$users->find(['pw'=>123]);
// dd($a);
// dd($save);
dd($find);
?>
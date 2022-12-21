<?php

$Student=new DB("students");
function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
class DB
{
    protected $table;
    protected $dsn="mysql:host=localhost;charset=utf8;dbname=school";
    protected $pdo;
    function __construct($table)
    {
        $this->pdo=new PDO($this->dsn,'root','');
        $this->table=$table;
    }
//數學函式:記數
//count 
function count(...$arg)//...$arg 100%is_array retuen ture;
{
    // if(isset($arg[0])){
    //     foreach ($arg[0] as $key => $value) {
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql ="select count(*) from $this->table where";
    //     $sql .= join(" && ",$tmp);
    // }else{
    //     $sql ="select count(*) from $this->table";
    // }
    $sql = $this->mathSql("count","*",...$arg);
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}
//數學函式:加總
//sum
function sum($col,...$arg){
    // if(isset($arg[0])){
    //     foreach ($arg[0] as $key => $value) {
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql="select sum($col) from $this->table where";
    //     $sql .= join(" && ",$tmp);
    // }else{
    //     $sql ="select sum($col) from $this->table";
    // }
    $sql = $this->mathSql("sum",$col,...$arg);
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}
//數學函式:最大
//max
//比較 gradeate_at(str)。會無法比較
function max($col,...$arg){
    // if(isset($arg[0])){
    //     foreach ($arg[0] as $key => $value) {
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql="select max($col) from $this->table where";
    //     $sql .= join(" && ",$tmp);
    // }else{
    //     $sql = "select max($col) from $this->table";
    // }
    $sql = $this->mathSql("max",$col,...$arg);
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}
//數學函式:最小
//min
function min($col,...$arg){
    // if(isset($arg[0])){
    //     foreach ($arg[0] as $key => $value) {
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql="select min($col) from $this->table where";
    //     $sql .=join(" && ",$tmp);
    // }else{
    //     $sql="select min($col) from $this->table";
    // }
    $sql = $this->mathSql("min",$col,...$arg);
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}
//數學函式:平均
//avg
function avg($col,...$arg){
    // if(isset($arg[0])){
    //     foreach ($arg[0] as $key => $value) {
    //         $tmp[]="`$key`='$value'";
    //     }
    //     $sql="select avg($col) from $this->table where";
    //     $sql .= join(" && ",$tmp);
    // }else{
    //     $sql="select avg($col) from $this->table";
    // }
    // echo $sql;
    // return $this->pdo->query($sql)->fetchColumn();
    $sql=$this->mathSql("avg",$col,...$arg);
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();

}
//數學模型:sum、max、min、avg、count
private function mathSql($math,$col,...$arg)
{
    if(isset($arg[0])){
        foreach ($arg[0] as $key => $value) {
            $tmp[]="`$key`='$value'";
        }
        $sql="select $math($col) from $this->table where";
        $sql .= join(" && ",$tmp);
    }else{
        $sql="select $math($col) from $this->table";
    }
    return $sql;
}
//foreach
private function arrayToSqlArray($array){
    foreach ($array as $key => $value) {
        $tmp[]="`$key`='$value'";
    }
    return $tmp;
}

}
$math=new DB("student_scores");
$count=$math->count(['score'=>68]);
dd($count);
$sum=$math->sum('score');
dd($sum);
$max=$math->max('score');
dd($max);
$min=$math->min('score');
dd($min);
$avg=$math->avg('score');
dd($avg);










?>
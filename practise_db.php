<?php
//原本的 : 
//$dsn="mysql:host=localhost;charset=utf8;dbname=school";
//$pdo=new PDO($dsn,'root','');
function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
$Student = new DB("students");
// $stu=$Student->all();
// $stu = $Student->all(" where `graduate_at`=4", " order by id desc");
// $stu =$Student->all(['dept'=>2,'graduate_at'=>2]," order by id desc");
// dd($stu);
// class DB
// {
//     protected $table;
//     protected $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
//     protected $pdo;
//     function __construct($table)
//     {
//         $this->pdo = new PDO($this->dsn,'root','');
//         $this->table = $table;
//     }
//     function all(...$args)
//     {
//         $sql = "SELECT * FROM $this->table";
//         if(isset($args[0]) {
//             if (is_array($args[0])) {
//                 foreach ($args[0] as $key => $value) {
//                     $tmp[] = "`$key`='$value'";
//                 }
//                 $sql .= " WHERE " . join(" && ", $tmp);
//             } else {
//                 $sql .= $args[0];
//             }
//         }
//         if (isset($args[1])) {
//             $sql .= $args[1];
//         }
//         echo $sql;
//         return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
//     }
// }
class DB
{
    protected $table;
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    protected $pdo;
    function __construct($table)
    {
        $this->pdo = new PDO($this->dsn, 'root', '');
        $this->table = $table;
    }
    function find($id){
        if(is_array($id)){
           $tmp = $this->arrayToSqlArray($id);
           $sql="select * from $this->table where";
           $sql .= join(" && ",$tmp);
        }else{
            $sql ="select * from $this->table where `id`=$id";
        }
        echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    





    function save($array){
        if(isset($array['id'])){
            $id=$array['id'];
            dd($id);
            unset($array['id']);
            dd($id);
            // foreach ($array as $key => $value) {
            //     if($key!='id'){
            //         $tmp[]="`$key`='$value'";
            //     }
            // }
            $tmp = $this->arrayToSqlArray($array);//引用private function
            $sql = "update $this->table set";
            $sql .=join(" , ",$tmp);
            $sql .=" where `id`='$id'";
        }else{
            $cols=array_keys($array);
            $sql = "insert into $this->table (`" . join("`,`",$cols)."`)
                                        values ('" . join("','",$array)."')";
        }
        echo $sql;
        return $this->pdo->exec($sql);
    }
//foreach 
private function arrayToSqlArray($array){
    foreach ($array as $key => $value) {
        $tmp[]="`$key`='$value'";
    }
    return $tmp;
}




}
$fine=$Student->find(20);
dd($fine);
$fine['name']="阿華哥";
$ui=$Student->save($fine);
// $ui=$Student->save(['dept'=>'2','graduate_at'=>'5']);
dd($ui);

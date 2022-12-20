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
    //UPDATE TABLE SET ` `=' ',` `=' '.... WHERE ``=''
    //INSERT INTO TABLE (``,``....) VALUES ('',''....)
    function save($array){
        if(isset($array['id'])){
            foreach ($array as $key => $value) {
                if($key!='id'){
                    $tmp[]="`$key`='$value'";
                }
            }
            $sql = "update $this->table set";
            $sql .=join(",",$tmp);
            $sql .= " where `id`='{$array['id']}'"; 
        }else{
            $cols=array_keys($array);
            $sql = "insert into $this->table (`" . join("`,`",$cols) . "`)
                                    values ('" . join("','",$array) . "')";
        }
        echo $sql;
        // return $this->pdo->exec($sql);
    }


}
$save=$Student->save(['name'=>'成功了喔','tel'=>'0975-398680','id'=>'488']);
// dd($save);

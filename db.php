<?php
// $dsn="mysql:host=localhost;charset=utf8;dbname=school";
// $pdo=new PDO($dsn,'root','');

function dd($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
$Student=new DB("students");
$stus=$Student->all();
var_dump($Student);
// var_dump($stus);
echo "<br>";
$names=$Student->all();
foreach($names as $name){
    echo $name['name'] . " 的父母親 =>".$name['parents'];
    echo "<br>";
}
// dd($Student->all(['dept'=>4]));
// foreach($stus as $stu){
//     echo $stu['parents'];
//     echo "<br>";
// }

class DB
{
    protected $table;
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    protected $pdo;
    public function __construct($table)
    {
        $this->pdo = new PDO($this->dsn, 'root', '');
        $this->table = $table;
    }

    public function all(...$args)
        { 
            // global $pdo;
            $sql = "SELECT * FROM $this->table";

            if (isset($args[0])) {
                if (is_array($args[0])) {
                    foreach ($args[0] as $key => $value) {
                        $tmp[] = "`$key`='$value'";
                    }
                    //須符合SQL語法
                    //用join將 $tmp 用 && 合併
                    $sql = $sql . " WHERE " . join(" && ", $tmp);
                    //注意這邊 " WHERE " 要空一格
                } else {
                    //字串的時候 :
                    $sql = $sql . $args[0];
                }
            }
            if (isset($args[1])) {
                //args[1] - order by limit 之類的sql 字串
                $sql = $sql . $args[1];
                // echo "$args[1]";
            }
            // echo $sql;
            //因為是fecthAll(屬二維陣列)，所以將不定參數條件設為$args[0];
            echo $sql;
            return $this->pdo
                        ->query($sql)
                        ->fetchAll(PDO::FETCH_ASSOC);
            //鍊式呼叫
        }
    
}
?>
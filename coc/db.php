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
$find=$Student->find(30);
dd($find);

echo "<br>";
echo is_object($find);
echo "<br>";
echo $find->name;
echo "<br>";
$find_val=$Student->find(30)->tel;
echo $find_val;
echo "<br>";

$names=$Student->all();
echo "<br>";
foreach($names as $name){
    echo $name['name'] . " 的父母親 =>".$name['parents'];
    echo "<br>";
}


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


        public function find($id){    
            $sql="SELECT * FROM $this->table ";
            if(is_array($id)){
                foreach($id as $key => $value){
                    $tmp[]="`$key`='$value'";
                    // dd($tmp);
                }
                $sql=$sql . "  WHERE " . join(" && " ,$tmp);
            }else{
                $sql.=" WHERE `id`='$id'";
                // `id`='$id' ,已經有+符號，直接給數字就行了  $row=find('students','7');
                // echo $sql;
                // echo "<br>";
            }
            // echo "<br>";
            // echo $sql;
            //fetch 屬單為陣列 若改為 fetchAll(二為陣列)，則等同於 all() definition function array.class
            //因fetch的關係，find()只會出現單筆資料。所以條件給一個就行了
            // return $this->pdo
            //             ->query($sql)
            //             ->fetch(PDO::FETCH_ASSOC);
             $row = $this->pdo
                         ->query($sql)
                         ->fetch(PDO::FETCH_ASSOC);
                        $data=new stdClass;//只是一個通用的"空"類型!!
                        foreach($row as $col => $value){
                            $data->{$col}=$value;
                        }
                        return $data;
        }


}
?>
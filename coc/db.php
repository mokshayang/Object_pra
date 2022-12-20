<?php
// $dsn="mysql:host=localhost;charset=utf8;dbname=school";
// $pdo=new PDO($dsn,'root','');

function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}
$Student = new DB("students");
// $stus = $Student->all();
// var_dump($Student);
// var_dump($stus);

// $names = $Student->all();
echo "<br>";
// foreach ($names as $name) {
//     echo $name['name'] . " 的父母親 =>" . $name['parents'];
//     echo "<br>";
// }
// dd($Student->all(['dept'=>6]));
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
        $sql = "SELECT * FROM $this->table";
        if (isset($args[0])) {
            if (is_array($args[0])) {
                $tmp=$this->arrayToSqlArray($args[0]);//取代下方
                // foreach ($args[0] as $key => $value) {
                //     $tmp[] = "`$key`='$value'";
                // }
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


    public function find($id)
    {
        $sql = "SELECT * FROM $this->table ";
        if (is_array($id)) {
            $tmp=$this->arrayToSqlArray(($id));//取代下方foreach
        //     foreach ($id as $key => $value) {
        //         $tmp[] = "`$key`='$value'";
        //         // dd($tmp);
        //     }
        dd($tmp);
            $sql = $sql . "  WHERE " . join(" && ", $tmp);
        } else {
            $sql .= " WHERE `id`='$id'";
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
        $data = new stdClass; //只是一個通用的"空"類型!!
        foreach ($row as $col => $value) {
            $data->{$col} = $value;
        }
        return $row;//array
        // return $data;//Object
    }

    public function del($id)
    {
        $sql = "DELETE FROM $this->table";
        if (is_array($id)) {
            $tmp=$this->arrayToSqlArray($id);
            // $tmp = [];
            // foreach ($id as $key => $value) {
            //     $tmp[] = "`$key`='$value'";
            // }
            $sql = $sql . " WHERE" . join(" && ", $tmp);
        } else {
            $sql = $sql . " WHERE `id`='$id'";
        }
        echo $sql;
        //  return $this->pdo->exec($sql);
    }
//合併陣列
//INSERT INTO table (`col`,) VALUE ('val');
//UPDATE table SET `col`='val' , ..... WHERE `id` = '$id';

    public function save($array){//此唯一微陣列
        if(isset($array['id'])){//確保資料表有id
            //根據語法 update 必須有where，insert into必不加where
            //此自訂義的function where 使用 id(每個資料表都會有的欄位主鍵)
            //所以判斷有無id來分辨 是 update or insert
            //更新 update 只針對條件id的
            // if(array('id')){//
                $id=$array['id'];//取出id欄位裝入變數
                dd($id);
                unset($array['id']);//註銷id欄位，註銷前先取用 上方 |
                
                $tmp=$this->arrayToSqlArray($array);
                // foreach($array as $key => $value){
                //     if($key!='id'){//少一個ID，id為自動增加且where條件指定id
                                      //所以把id拿掉不做update，
                                      //這邊的$key 指的就是欄位名
                //     $tmp[]="`$key`='$value'";
                //     // dd($tmp);
                //     }
                // }
                dd(($tmp));
                $sql = "UPDATE $this->table SET ";
                $sql .= join(" , ", $tmp);
                // $sql .= " WHERE `id`='{$array['id']}'";
                $sql .= " WHERE `id`=$id";
                // dd($sql);
        }else{//如果沒有id，即沒有使用where條件，為insert into
            //新增 insert
            $cols=array_keys($array);
            $sql="INSERT INTO $this->table (`" . join("`,`",$cols) ."`) 
                                    VALUES ('" . join("','",$array) ."')";
            echo $sql;
        }
        return $this->pdo->exec($sql);
        
    }


//數學函式:總計
function sum($col,...$arg){//&arg一定是陣列
    // return $this->mathSql("sum",$col,$arg);
    // if(isset($arg[0])){
    //     foreach ($arg[0] as $key => $value) {
    //         $tmp[] = "`$key`='$value'";
    //         // dd($tmp);
    //     }
    //     $sql="SELECT sum($col) FROM $this->table WHERE ";
    //     $sql .=join(" && ",$tmp) ;
    // }else{
    //     $sql="SELECT sum($col) FROM $this->table ";
    // }
    //  echo $sql;
    // return $this->pdo->query($sql)->fetchColumn();
    $sql=$this->mathSql("col",$col,$arg);
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}
//數學函式:max
function max($col,...$arg){//&arg一定是陣列
    // return $this->mathSql("max",$col,$arg);
    // if(isset($arg[0])){
    //     foreach ($arg[0] as $key => $value) {
    //         $tmp[] = "`$key`='$value'";
    //         // dd($tmp);
    //     }
    //     $sql="SELECT max($col) FROM $this->table WHERE ";
    //     $sql .=join(" && ",$tmp) ;
    // }else{
    //     $sql="SELECT max($col) FROM $this->table ";
    // }
    //  echo $sql;
    // return $this->pdo->query($sql)->fetchColumn();
    $sql=$this->mathSql("max",$col,$arg);
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}

//數學函式:min
function min($col,...$arg){//&arg一定是陣列
    // return $this->mathSql("min",$col,$arg);
    // if(isset($arg[0])){
    //     foreach ($arg[0] as $key => $value) {
    //         $tmp[] = "`$key`='$value'";
    //         // dd($tmp);
    //     }
    //     $sql="SELECT min($col) FROM $this->table WHERE ";
    //     $sql .=join(" && ",$tmp) ;
    // }else{
    //     $sql="SELECT min($col) FROM $this->table ";

    // }
    //  echo $sql;

    // return $this->pdo->query($sql)->fetchColumn();
    $sql=$this->mathSql("min",$col,$arg);
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}

//數學函式:avg(平均):
function avg($col,...$arg){//&arg一定是陣列
    // return $this->mathSql("avg",$col,$arg);
    
    // echo $sql;
    // if(isset($arg[0])){
    //     foreach ($arg[0] as $key => $value) {
    //         $tmp[] = "`$key`='$value'";
    //         // dd($tmp);
    //     }
    //     $sql="SELECT avg($col) FROM $this->table WHERE ";
    //     $sql .=join(" && ",$tmp) ;
    // }else{
    //     $sql="SELECT avg($col) FROM $this->table ";
    // }
    $sql=$this->mathSql("avg",$col,$arg);
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
}

//數學函式:記數
function count(...$arg){
    // return $this->mathSql("count",$arg);
    // if(isset($arg[0])){
    //     foreach ($arg as $key => $value) {
    //         $tmp[] = "`$key`='$value'";
    //         // dd($tmp);
    //     }
    //     $sql="SELECT count(*) FROM $this->table WHERE ";
    //     $sql .=join(" && ",$tmp);
    // }else{
    //     $sql="SELECT count($arg) FROM $this->table";
    // }
    // echo $sql;

    $sql=$this->mathSql("count",'*',$arg);//之後查詢 不能用字串了
    echo $sql;
    return $this->pdo->query($sql)->fetchColumn();
    }
    private function mathSql($math,$col,...$arg){
    // if($math=="count"){
    //     $sql="SELECT count(*) FROM $this->table ";
    //     // $sql .=join(" && ",$tmp);
    // }else{
        // $sql="SELECT count($arg) FROM $this->table";
        if(isset($arg[0][0])){
            foreach ($arg[0][0] as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql="SELECT $math($col) FROM $this->table WHERE ";
            $sql .=join(" && ",$tmp) ;
        }else{
            $sql="SELECT $math($col) FROM $this->table ";
        }
        return $sql;
    // echo $sql;
    // return $this->pdo->query($sql)->fetchColumn();
}

//foreach 
private function arrayToSqlArray($array){//節省foreach
        foreach ($array as $key => $value) {
            $tmp[] = "`$key`='$value'";
        }
        // dd($tmp);
    return $tmp;
}

}
// 常用的 definition function :
// 萬用查詢 :
function q($sql){
    global $pdo;
    $dsn="mysql:host=localhost;charset=utf8;dbname=school";
    $pdo=new PDO($dsn,'root','');
    // echo $sql;
    return $pdo->query($sql)->fetchAll();    
}
// $sql="select * from `students` where `dept`='2'";
// dd(q($sql));

//轉換網頁 :
function to($location){
    header("location:$location");
}
//to("../xxxx/xxxx");






// $stu=$Student->find(['uni_id'=>'C100000012']);
// dd($Student->find(1));
// $echo $Student->options('id');
//記數
// echo $Student->count('id');//不帶字串了，經過修改後，帶字串會出錯
// echo "<hr>";
// echo $Student->count(['dept'=>'4']);//可以帶陣列
// echo "<hr>";
//  echo $Student->count();
// echo "<hr>";

// //總計
// echo  "<hr>";
// echo $Student->sum('graduate_at');
// echo "<hr>";
// echo $Student->sum('graduate_at',['id'=>'4']);
// echo "<hr>";
// $Score=new DB("student_scores");
// echo $Score->max('score');
// echo "<hr>";
// echo $Score->min('score');
// echo "<hr>";
// echo $Score->avg('score');
// 
// 
$find = $Student->find(4);
// dd($find);
// echo "<br>";
// echo is_object($find);//true : 1
$find['name']="陳秋貴1";
dd($find);
echo "<hr>";
$Student->save($find);
// dd($Student->save($find));
echo "<hr>";
$Student->save(['name'=>'張大同','dept'=>'2']);
// $Student->save(['name'=>'張小同','dept'=>'4']);
// echo "<hr>";
// $del_test=$Student->save(['dept'=>'2','graduate_at'=>'3','id'=>'4']);
// dd($del_test);
//合併陣列
//INSERT INTO table (`col`,) VALUE ('val');
//UPDATE table SET `col`='val' , ..... WHERE `id` = '$id';
// $Student->count();
//數學函式
// $row=q("SELECT * FROM students WHERE `dept`=4 order by `id` desc ");
// dd($row);
?>
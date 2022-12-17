<?php
//義類別內成員或方法的權限，區隔出外部和內部的關係
//
//使用關鍵字public , protected private
//Public -> 外部可以自由存取
//Protect -> 內部和有繼承關係的可以存取
//Private -> 僅限類別內部取用

$cat = new Animal('小花','白色','小花貓');// Animal 相當於設計圖  $cat 裝入變數 實體化
// $dog = new Animal;
// echo $cat->type;//如果 是 public 可以被更改
// echo "<br>";
// $dog->type="123";
// // echo $dog;
// echo $dog->type;
// echo "<br>";
// echo $dog->name;
// echo "<br>";
// echo $dog->hair_color;
// echo "<pre>";
// var_dump($cat);
// echo "</pre>";
// echo "<pre>";
// var_dump($dog);
// echo "</pre>";
//封裝 : 
//Public -> 外部可以自由存取
//Protected -> 內部和有繼承關係的可以存取，
//Private -> 僅限類別內部取用，外部無法存取，
//要存取的話 須過外部可呼叫的方式 public () ， 
//contect : $this($cat=new Animal)-> (private) xxx();

//方法的使用 :
// $cat->run();
// $cat->speed();//因為 private 直接叫可不型
$dog = new Animal('獅子犬','黑白鄉間','狗狗');

// echo $dog->getName();
// echo $dog->getColor();
// echo $dog->getType();
echo "<br>";
// echo $cat->getName();
// echo $cat->getColor();
// echo $cat->getType();
echo "<br>";
$aa=new Cat('小花','白色');
echo $aa->getName();
echo $aa->getColor();
echo $aa->getType();
echo "<br>";
$dd=new Dog('小花','白色');
echo $dd->getName();
echo $dd->getColor();
echo $dd->getType();
echo $dd->act();
//類別宣告  教材範例

Class Animal{//new  Animal 相當於"設計圖概念"
    // public $type='animal';   //public $xxx = "預設值" ; 
    // public $name='John';
    // public $hair_color="brown";//$dog = new Animal;
    public $type='animal';   //public $xxx = "預設值" ; 
    protected $name='John';
    protected $hair_color="brown";//$dog = new Animal;
    //proteded $type 會讀不到 被保護的屬性
    //private //私有 外面讀不到

    public function __construct($name,$color,$type)//兩個底線 //一旦實體化$cat = new Animal; 就會去執行
    {//建構式內容
        // $this->run();
        $this->name=$name;//$this->name===$cat->name 
        //在內部增加 protected $name($this->name) 賦予 外部給的$name  __construct($name,$color)，$cat = new Animal('小花','白色');
        $this->hair_color=$color;
        $this->type=$type;

    }
    
    public function getName()
    {
        return $this->name;
    }
    public function getColor()
    {
        return $this->hair_color;
    }
    public function getType()
    {
        return $this->type;
    }

    public function run(){
        //公開行為內容
        echo "會跑";
        echo "<br>";
        echo $this->name;
        $this->speed();//$this 指的是實體化 $cat or $dog
        //透過 public 可實體化外部呼叫$car->run() 在run()內容 增加 $this->speed() 
    }

    private function speed(){
        //私有行為內容
        echo "會叫叫叫";
    }
}    
    //繼承
    
    class Cat extends Animal{ //繼承父類別 
        public function __construct($name,$color)
        {
            //parent::__construct($name,$color);
            $this->name=$name;//
            $this->hair_color=$color;
            $this->type="貓";
    
        }   
    }
    class Dog extends Animal{ //繼承父類別 
        public function __construct($name,$color)
        {
            //parent::__construct($name,$color);
            $this->name=$name;//
            $this->hair_color=$color;
            $this->type="狗";
    
        }   
        public function act(){
            echo "肚子餓了";
        }
    }






?>
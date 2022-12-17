<?php
 class A
{
    
    public $attribute1;
    protected $aaa="ClassA";
    const PP=464;
    function operation()
    {echo "A";}
   
}
class B extends A
{
    
    public $attribute2="kind";
    protected $bbb="ClassB";
    function operation()//需與父層相同名稱
    {
        parent::operation();//調用父層(final 無法覆寫)
        echo "(change !!)";//接續的文字，
    }
    function getPro(){
        return $this->aaa;
    }
}
$a=new A;
$b=new B;
var_dump($b);
echo $a->attribute1="parent";
echo "<br>";
echo $a->attribute2=123;
echo "<br>";
echo $a->operation;
echo "<br>";
echo $b->getPro();
echo "<br>";
echo $a->bbb=369;
echo "<br>";
var_dump($a);
echo "<br>";
// echo $a->operation2();//Fatal error
echo $a->operation();
echo "<br>";
// echo $b->operation();
echo "<br>";
// echo $b->operation;

?>
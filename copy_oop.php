<?php
$aa=new Amimal("moksha");//實體化 放入後 會馬上執行 __construct
$bb=new Amimal("");//實體化 放入後 會馬上執行 __construct
echo $aa->cat;
echo $aa->getAge();
echo $aa->getColor();
echo $aa::acv;
class Amimal
{
    public $cat=35;//成員變數
protected $age;//
private $color;
public const acv="const";

function __construct($name)
{
    echo $name."Start-Object";
}
function getAge(){
    return $this->age=46;
}

function getColor(){
    return $this->color;
}
function getCast(){
    return $this->cast();
}
private function cast(){
    echo "www.priavte";
}


}
echo "<br>";
$cc=new pp();
echo $cc->att;
// var_dump($cc->att);
class pp{
    private $att;
    function __get($name)
    {
        return $this->$name;
        // return $name;
    }
    function __set($name,$value){
        $this->$name=$value;
    }
}
// echo $aa->getCast();

?>
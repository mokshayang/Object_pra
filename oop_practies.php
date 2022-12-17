<?php

use Animal as GlobalAnimal;

$cat=new Animal();
echo "<br>";
$cat->run();
// echo $cat->a;
// echo $cat->name;//無法取出
echo $cat->getName();
echo $cat->getColor();
echo $cat->bbb=18;
var_dump($cat);
Class Animal{
    public $a=456465;
    protected $name='John';
    private $color='red';
public function __construct()
{
    echo "start Object";

}
public function run(){
    echo "會叫";
    $this->name;
    $this->speed();
    $this->act();

}
protected function speed(){
    echo "超級快";
}

private function act(){
    //私有行為內容
    echo "會叫叫叫";
}

 function getName()
{
    return $this->name;
    
}

function getColor()
{
    
    return $this->color;
}


}

?>
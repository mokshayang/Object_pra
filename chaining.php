<?php
$car=new Car();
echo "<br>";
echo $car->getColor("1231");
echo "<br>";
echo $car->addColor("red")
         ->addColor("blue")
         ->addColor("green")
         ->addColor("棕色")
         ->getColor();
         

$car->getColor();
echo gettype($car);//object === new Car("yellow")
class Car
{

        protected $color="彩虹";

        public function __construct()
        {
            // $this->color=$color;
        }
        function getColor(){
            return $this->color;
        }
        function addColor($color){
            // $this->color=$this->color." + ".$color;
            $this->color.=$color." + ";
            return $this;//要返回的是物件屬性($this)才可以繼續+所以return $this{$car=new Car()}
        }
}
?>
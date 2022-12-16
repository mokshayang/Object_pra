<?php
// public static 靜態屬性 當電腦掃苗到static 會先給予記憶體 裝入
// 是很方便，但是用多了，記憶體效能大大消耗
//--static--可以使用下方式呼叫---
echo Car::$type;//Car::$type;一次只能有一個值;且透過::呼叫需要+$
echo Car::speed();
Car::$type="冰釋";
$carA=Car::$type="瑪莎拉蒂";
echo $carA;
$carB;
// $car=new car;//
// echo $car->type;//property(屬性) static
//----method----static可以使用----
// $car=new Car();
echo $car->speed();
echo Car::YEAR;//呼叫成員public const
//static 可以不用$car=new Car;(少)
Car::$YEAR='2023';
echo Car::$YEAR;
class Car//Object 名稱一般使用大寫 : 
{
    //static 一班用在不太需要改變的
    public static $type="裕隆";//$type 成員
    //public const 名稱一班都用大寫!!
    public const TYPE_A="裕隆";//使用const 不需要+$，且內容無法被改變
    public const YEAR="2022";//const 宣告的不需要+$，且內容無法被改變
    public static $YEAR="2022";//const 宣告的不需要+$，且內容無法被改變


    public static function speed(){// function speed 方法
        return 60;
    }


}

?>
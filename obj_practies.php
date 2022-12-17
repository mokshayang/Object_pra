<?php
class Person {
    public $name;
    public $age;
  
    public function greet() {
      return "Hello, my name is " . $this->name . " and I am " . $this->age . " years old.";
    }
  }
  
  $person = new Person();
  $person->name = "John";
  $person->age = 30;
  
  echo $person->greet();
  
  // Output: "Hello, my name is John and I am 30 years old."

?>
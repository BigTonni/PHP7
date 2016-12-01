<?php

/*
 *  By book Mikael Olsson "PHP 7 Quick Scripting Reference, Second Edition"
 */

//1 - Operators
$x = 4 ** 2; // 16 // exponentiation
$x **= 5; // $x = $x**5;
 
//2 - spaceship operator
$x = 1 <=> 1; // 0 (1 == 1)
$x = 1 <=> 2; //-1 (1 < 2)
$x = 3 <=> 2; // 1 (3 > 2)
 
//3 - String
$s = 'Hello';
$s[0] = 'J';
echo $s; // "Jello"

$s[strlen($s) - 1] = 'y';
echo $s; // "Jelly"

//4 - ellipsis
function myArgs3(...$args) {
    foreach ($args as $v) {
        echo $v;
    }
}
myArgs3(1, 2, 3); // "123"

//5 - Anonymous Functions
$say = function($name) {
    echo "Hello " . $name;
};
$say("World"); // "Hello World"

function myCaller($myCallback) {
    echo $myCallback();
}

myCaller(function() {
    echo "Hello";
});// "Hello"

//6 - Closures
$x = 1;
$y = 2;
$myClosure = function($z) use ($x, $y) {
    return $x + $y + $z;
};
echo $myClosure(3); // "6"

//7 - Generators
function xrange($start, $limit, $step = 1) {
    if ($start < $limit) {
        if ($step <= 0) {
            throw new LogicException('Step must be +ve');
        }

        for ($i = $start; $i <= $limit; $i += $step) {
            yield $i;
        }
    } else {
        if ($step >= 0) {
            throw new LogicException('Step must be -ve');
        }

        for ($i = $start; $i >= $limit; $i += $step) {
            yield $i;
        }
    }
}

/* Attention: range() and xrange() displays the same result */
echo 'Odd numbers using range():  ';
foreach (range(1, 9, 2) as $number) {
    echo "$number ";
}
echo "\n";

echo 'Odd numbers using xrange(): ';
foreach (xrange(1, 9, 2) as $number) {
    echo "$number ";
}
//Example 2
function getNum() {
    for ($i = 0; $i < 5; $i++) {
        yield $i;
    }
}
foreach (getNum() as $v){
    echo $v; // "01234"
}

//8 - Late Static Bindings
class MyParent {

    protected static $val = 'parent';

    public static function getVal() {
        return self::$val;
    }

}

class MyChild extends MyParent {

    protected static $val = 'child';

}

echo MyChild::getVal(); // "parent"
/* * * */
class MyParentNew {

    protected static $val = 'parent';

    public static function getLateBindingVal() {
        return static::$val;
    }

}

class MyChildNew extends MyParentNew {

    protected static $val = 'child';

}

echo MyChildNew::getLateBindingVal(); // "child"

//9 - Consts and Define
const CA = [1, 2, 3]; // PHP 5.6 or later
define('DA', [1, 2, 3]); // PHP 7 or later

//10 - Traits
trait PrintFunctionality {

    public function myPrint() {
        echo 'Hello';
    }

}

class MyClass {
// Insert trait methods
    use PrintFunctionality;
}

$o = new MyClass();
$o->myPrint(); // "Hello"

//11 - Return Type Declarations
interface I {
    static function myArray(array $a): array;
}
class C implements I {
    static function myArray(array $a): array {
        return $a;
    }
}

//12 - Null Coalescing Operator
$x = null;
//before php 7
$name = isset($x) ? $x : 'unknown';
//after
$name = $x ?? 'unknown'; // "unknown"

//13 - Property Overloading
class MyProperties
{
    private $data = array();
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
    public function __get($name)
    {
        if (array_key_exists($name, $this->data))
            return $this->data[$name];
    }
}
$obj = new MyProperties();
$obj->a = 1; // __set called
echo $obj->a; // __get called

//14 - Method Overloading
class MyClass
{
    public function __call($name, $args)
    {
        echo "Calling $name $args[0]";
    }
}
// "Calling myTest in object context"
(new MyClass())->myTest('in object context');

//Vers for  __callStatic()
class MyClass
{
    public static function __callStatic($name, $args)
    {
        echo "Calling $name $args[0]";
    }
}
// "Calling myTest in static context"
MyClass::myTest('in static context');

//15 - Isset and unset Overloading
class MyClass
{
    private $data = array();
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }
    public function __get($name) {
        if (array_key_exists($name, $this->data))
        return $this->data[$name];
    }
    public function __isset($name) {
        return isset($this->data[$name]);
    }
    public function __unset($name) {
        unset( $this->data[$name] );
    }
}

$obj = new MyClass();
$obj->name = "Joe";
isset($obj->name); // true
isset($obj->age); // false

unset($obj->name); // delete property
isset($obj->name); // false

//16 - Magic methods
// _ToString - Called for object to string conversions.
class MyClass
{
    public function __toString()
    {
        return 'Instance of ' . __CLASS__;
    }
}
$obj = new MyClass();
echo $obj; // "Instance of MyClass"

//_Invoke - Called for object to function conversions.
class MyClass
{
    public function __invoke($arg)
    {
        echo $arg;
    }
}
$obj = new MyClass();
$obj('Test'); // "Test"

// ** Other **
//__sleep() - Called by serialize . Performs cleanup tasks and returns an array of variables to be serialized.
//__wakeup() - Called by unserialize to reconstruct the object.
//__set_state($array) - Called by var_export . The method must be static and its argument contains the exported properties.
//__clone() - Called after object has been cloned.
?>
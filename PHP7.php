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
?>
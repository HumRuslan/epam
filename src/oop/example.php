<?php
include '../../vendor/autoload.php';

use src\oop\Calculator;
use src\oop\Commands\SubCommand;
use src\oop\Commands\SumCommand;
use src\oop\Commands\MultiCommand;
use src\oop\Commands\DivCommand;
use src\oop\Commands\ExpoCommand;

$calc = new Calculator();
$calc->addCommand('+', new SumCommand());
$calc->addCommand('-', new SubCommand());
$calc->addCommand('*', new MultiCommand());
$calc->addCommand('/', new DivCommand());
$calc->addCommand('**', new ExpoCommand());

//// You can use any operation for computing
//// will output 2
//echo $calc->init(1)
//    ->compute('+', 1)
//    ->getResult();
//
//echo PHP_EOL;
//
//// Multiply operations
//// will output 10
//echo $calc->init(15)
//    ->compute('+', 5)
//    ->compute('-', 10)
//    ->getResult();
//
//echo PHP_EOL;
//
//// TODO implement replay method
//// should output 4
//echo $calc->init(1)
//    ->compute('+', 1)
//    ->replay()
//    ->replay()
//    ->getResult();
//
//echo PHP_EOL;
//
//// TODO implement undo method
//// should output 1
//echo $calc->init(1)
//    ->compute('+', 5)
//    ->compute('+', 5)
//    ->undo()
//    ->undo()
//    ->getResult();
//
//echo PHP_EOL;
//
//// Division Operation
//// Should output 2
//echo $calc->init(4)
//    ->compute('/', 2)
//    ->getResult();
//
//echo PHP_EOL;

// Multiplication operation
// Should output 8
echo $calc->init(4)
    ->compute('*', 2)
    ->getResult();

echo PHP_EOL;

// Exponentiation operation
// Should output 16
echo $calc->init(4)
    ->compute('**', 2)
    ->getResult();

echo PHP_EOL;

// Should output 16

echo $calc->init(-4)
    ->compute('**', 2)
    ->getResult();

echo PHP_EOL;

// Should output -125

echo $calc->init(-5)
    ->compute('**', 3)
    ->getResult();

echo PHP_EOL;

// Should output 2
echo $calc->init(4)
    ->compute('**', 1/2)
    ->getResult();

echo PHP_EOL;

// Should output 2
echo $calc->init(8)
    ->compute('**', 1/3)
    ->getResult();

echo PHP_EOL;

// Should output -2
echo $calc->init(-8)
    ->compute('**', 1/3)
    ->getResult();

echo PHP_EOL;
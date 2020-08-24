<?php
define('name', 'datnguyen');
echo name;
//string


$myArray = [02, 120, 394, 22];
echo '<pre>';
print_r($myArray);
echo '</pre>';
//        array

$arrayInput =['html','css','php','wordpress' ,'js'];
array_splice($arrayInput,2,2);


echo "<pre>";
print_r($arrayInput);
echo "</pre>";


//foreach
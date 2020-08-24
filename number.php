<?php

$num = 3.14;
echo round($num,1)."<br/>";
echo ceil($num)."<br/>";
echo floor($num)."<br/>";
echo rand()."<br/>";
echo rand(1,10)."<br/>";

// tinh so luong thue

$soluong = 20;
$gia = 30;
$thue = .05;

$tong = $soluong *  $gia;
$tong += ($tong * $thue);
echo "{$tong}";
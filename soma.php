<?php
$v1 = $_GET["a"];
$v2 = $_GET["b"];
$op = $_GET["op"];
$result = 0;

if ($op == "+")
    $result =$v1 + $v2;
elseif($op == "-")
    $result = $v1 - $v2;
elseif($op == '*')
    $result = $v1 * $v2;
elseif($op == '/')
    $result = $v1 / $v2;
?>


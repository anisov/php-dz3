<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 10.03.2018
 * Time: 1:09
 */
require('functions.php');
//Первое задание
readMyXML('data.xml');
//Второе задание
$jsonMas = [
    "key1" => "value1",
    "key2" => [
        "key3" => "value4",
        "key4" => "value5"
    ],
];
changeData($jsonMas);
//Третье задание
numberGenerator();
//Четвёртое задание
getData();
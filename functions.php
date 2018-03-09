<?php
/**
 * Created by PhpStorm.
 * User: Dmitriy
 * Date: 07.03.2018
 * Time: 22:21
 */
//Задача #1
//Написать скрипт, который выведет всю информацию из этого файла в удобно
//читаемом виде. Представьте, что результат вашего скрипта будет распечатан и
//выдан курьеру для доставки, разберется ли курьер в этой информации?

function readMyXML($data)
{
    $xml = simplexml_load_file($data);
    echo '<h1>Номер заказа покупки : ' . $xml['PurchaseOrderNumber'] . ' <br/>' . PHP_EOL . '</h1>';
    echo '<b>Дата заказа: ' . $xml['OrderDate'] . ' <br/>' . PHP_EOL . '</b>';
    $countAddress = $xml->Address->count();
    $countItem = $xml->Items->Item->count();
    echo '------------------' . ' <br/>' . PHP_EOL;

    function getAddress($xml, $countAddress)
    {
        echo 'Имя: ' . $xml->Address[$countAddress]->Name . ' <br/>' . PHP_EOL;
        echo 'Улица: ' . $xml->Address[$countAddress]->Street . ' <br/>' . PHP_EOL;
        echo 'Город: ' . $xml->Address[$countAddress]->City . ' <br/>' . PHP_EOL;
        echo 'Штат:' . $xml->Address[$countAddress]->State . ' <br/>' . PHP_EOL;
        echo 'Почтовый индекс: ' . $xml->Address[$countAddress]->Zip . ' <br/>' . PHP_EOL;
        echo 'Страна: ' . $xml->Address[$countAddress]->Country . ' <br/>' . PHP_EOL;
        echo '------------------' . ' <br/>' . PHP_EOL;
//        if ($countAdress <= 0){
//            return ;
//        }
//        getAddress($xml,--$countAdress);
    }

    for ($i = 0; $i < $countAddress; $i++) {
        if ($i == 0) {
            echo '<h3>Основной адресс</h3>' . ' <br/>' . PHP_EOL;
        } else {
            echo '<h3>Дополнительный адресс</h3>' . ' <br/>' . PHP_EOL;
        }
        getAddress($xml, $i);
    }
    echo "<h3>Накладная: $xml->DeliveryNotes<h3>" . '<br/>' . PHP_EOL;
    for ($i = 0; $i < $countItem; $i++) {
        $order = $i + 1;
        echo "<h3>Заказ номер: $order </h3>" . ' <br/>' . PHP_EOL;
        echo 'Продукт: ' . $xml->Items->Item[$i]->ProductName . ' <br/>' . PHP_EOL;
        echo 'Количество: ' . $xml->Items->Item[$i]->Quantity . ' <br/>' . PHP_EOL;
        echo 'Цена: ' . $xml->Items->Item[$i]->USPrice . ' <br/>' . PHP_EOL;
        if ($xml->Items->Item[$i]->Comment) {
            echo 'Комментарий: ' . $xml->Items->Item[$i]->Comment . ' <br/>' . PHP_EOL;
        }
        if ($xml->Items->Item[$i]->ShipDate) {
            echo 'Дата доставки: ' . $xml->Items->Item[$i]->ShipDate . ' <br/>' . PHP_EOL;
        }
        echo '------------------' . ' <br/>' . PHP_EOL;
    }
}


//Задача #2
//1. Создайте массив, в котором имеется как минимум 1 уровень вложенности.
//Преобразуйте его в JSON. Сохраните как output.json
//2. Откройте файл output.json. Случайным образом решите изменять данные или
//нет. Сохраните как output2.json
//3. Откройте оба файла. Найдите разницу и выведите информацию об
//отличающихся элементах

function changeData($jsonMas)
{
    function createFile($fileName, $value)
    {
        $fp = fopen($fileName, "wa");
        $test = fwrite($fp, $value);
        if ($test) echo "Файл $fileName успешно создан и данные занесены " . '<br/>' . PHP_EOL;
        else echo 'Ошибка при записи в файл ' . '<br/>' . PHP_EOL;
        fclose($fp);
    }

    function openFile($fileName)
    {
        $fp = fopen($fileName, "r");
        if ($fp) {
            while (!feof($fp)) {
                return $value = fgets($fp, 999);
            }
        }
        return null;
    }

    $jsonData = json_encode($jsonMas);
    createFile('output.json', $jsonData);
    $json = openFile('output.json');
    $random = mt_rand(0, 1);
    if ($random == 1) {
        $key2 = '12345';
        $newMas = json_decode($json, TRUE);
        $newMas['key2']['key3'] = '12345';
        $newJson = json_encode($newMas);
        createFile('output2.json', $newJson);
    } else {
        createFile('output2.json', $jsonData);
    }

    $OutputJson = openFile('output.json');
    $Output2Json = openFile('output2.json');

    $OutputMas = json_decode($OutputJson, TRUE);
    $Output2Mas = json_decode($Output2Json, TRUE);

    $resultOne = array_diff($OutputMas, $Output2Mas);
    $resulTwo = array_diff($OutputMas['key2'], $Output2Mas['key2']);

    if ($resultOne) {
        echo 'Изменения есть в первом массиве: ' . '<br/>' . PHP_EOL;
        print_r($resultOne);
        echo '<br/>' . PHP_EOL;
    } else {
        echo 'Изменений нет в первом массиве: ' . '<br/>' . PHP_EOL;
    }
    if ($resulTwo) {
        echo 'Изменения есть во вложенном массиве: ' . '<br/>' . PHP_EOL;
        print_r($resulTwo);
        echo '<br/>' . PHP_EOL;
    } else {
        echo 'Изменений нет во вложенном массиве: ' . '<br/>' . PHP_EOL;
    }

}

//Задача #3
//1. Программно создайте массив, в котором перечислено не менее 50 случайных
//числел от 1 до 100
//2. Сохраните данные в файл csv
//3. Откройте файл csv и посчитайте сумму четных чисел

function numberGenerator()
{
    $mas = [];
    for ($i = 0; $i < 51; $i++) {
        $mas[] = rand(0, 100);
    }
    $fp = fopen('data.csv', 'w');
    fputcsv($fp, $mas);
    fclose($fp);
    $fp = fopen('data.csv', 'r');
    $readFile = fgetcsv($fp, 1000, ",");
    $number = 0;
    foreach ($readFile as $item) {
        if ($item % 2 == 0) {
            $number = +$item;
        }
    }
    echo $number . '<br/>' . PHP_EOL;
}

//Задача #4
//С помощью PHP запросить данные по адресу:
//https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revision
//s&rvprop=content&format=json
//2. Вывести title и page_id

function getData()
{
    $link = 'https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json';
    $json = file_get_contents($link);
    preg_match_all('/"title":"\w*\s\w*"|"pageid":\d+/', $json, $matches);
    foreach ($matches[0] as $i) {
        echo $i . '<br/>' . PHP_EOL;
    }
}





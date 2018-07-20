<?php

// 取得網址是否失效?!

require "vendor/autoload.php";

$oCheck = new \webignition\UrlHealthChecker\UrlHealthChecker();
$reader = new \EasyCSV\Reader('checkurl.csv');

while($row = $reader->getRow()){
    $data = $oCheck->check($row['url']);
    echo $row['no'];
    if($data->getState()==200){
        echo ",OK";
    }elseif($data->getState()==404){
        echo ",ERROR";
    }elseif($data->getState()==6){
        echo ",BAD";
    }
    echo ",".$row['url']."\r\n";
}

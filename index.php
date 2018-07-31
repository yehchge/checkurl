<?php

// 取得網址是否失效?!

require "vendor/autoload.php";

$filename = "checkurl.csv";

if(isset($argv[1])){
    $filename = trim($argv[1]);
}

$oCheck = new \webignition\UrlHealthChecker\UrlHealthChecker();
$reader = new \EasyCSV\Reader($filename);
$writer = new \EasyCSV\Writer('checkurl_'.date("Ymd").'.csv');
$writer->writeRow('No, Status, Url');
while($row = $reader->getRow()){
    $data = $oCheck->check($row['url']);
    $msg = $row['no'];
    if($data->getState()==200){
        $msg .= ",OK";
    }elseif($data->getState()==404){
        $msg .= ",ERROR";
    }elseif($data->getState()==6){
        $msg .= ",BAD";
    }elseif($data->getState()==410){
        $msg .= ",no available";
    }
    $msg .= ",".$row['url'];
    echo $msg."\r\n";
    $writer->writeRow($msg);
}

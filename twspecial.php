<?php

/**
 * @desc 確認台灣好東西網址正確?
 * @created 2018/07/31
 */

require "vendor/autoload.php";

// Initialize


$dsn = 'mysql:host=10.1.1.117;dbname=twspecial_new';
$database = new Nette\Database\Connection($dsn, 'bill', 'Up6ck67@79');

$oCheck = new \webignition\UrlHealthChecker\UrlHealthChecker();
$writer = new \EasyCSV\Writer('twspecial_'.date("Ymd").'.csv');

$writer->writeRow('No, Status, Url');

$result = $database->query("SELECT * FROM search_result LIMIT 10");

$iTotal = 1;
foreach($result as $row){
    $data = $oCheck->check($row->url);
    $msg = $iTotal;
    if($data->getState()==200){
        $msg .= ",OK";
    }elseif($data->getState()==404){
        $msg .= ",ERROR";
    }elseif($data->getState()==6){
        $msg .= ",BAD";
    }elseif($data->getState()==410){
        $msg .= ",no available";
    }
    $msg .= ",".$row->url;
    echo $msg."\r\n";
    $writer->writeRow($msg);
    $iTotal++;
}



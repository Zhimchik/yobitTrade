<?php

set_time_limit(0);
ini_set('memory_limit', '-1');

require './vendor/autoload.php';
use OlegStyle\YobitApi\YobitPublicApi;

$publicApi = new YobitPublicApi();


//$getNamePairs = array_keys($publicApi->getPairsBTC($publicApi->getPairs($publicApi->getInfo())));

//foreach ($getNamePairs as $nameParir) {
//    list($from, $to) = explode('_', $nameParir);
//}

$responseJson_str = file_get_contents('coin.json');
$response = json_decode($responseJson_str, true);

$from= '';
$to = '';
//$newPair=[];


$getNamePairs = array_keys($publicApi->getPairsBTC($publicApi->getPairs($response)));
//$output = array_slice($getNamePairs, 0, 49);
$output = array_chunk($getNamePairs, 49);

foreach ($output as $item){

    $getNewNamePairs = implode('-', $item);
    //последние сделки
    $getRecentDeals = $publicApi->getTrades($getNewNamePairs);
    //активные ордера
    $publicApi->getDepths($getNewNamePairs);

    var_dump(1);
    $publicApi->flush_buffers();

}



die();


//var_dump($getNamePairs); die();
//foreach ($getNamePairs as $nameParir) {
    //list($from, $to) = explode('_', $nameParir);



    $countTrades = $publicApi->getTradesLastHourByPair($getOrdersByPair);

    $countBuyOrders = $publicApi->getBuyOrdersByPair($getBuyOrdersByPair);
    echo "По паре " . strtoupper($from) . "-" . strtoupper($to) . " Закупок подряд - " . count($countTrades) . "  Ордеров на покупку - " . count($countBuyOrders);
    echo '<br>', '<br>';
    $publicApi->flush_buffers();
//}



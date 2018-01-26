<?php

set_time_limit(0);
ini_set('memory_limit', '-1');

require './vendor/autoload.php';
use OlegStyle\YobitApi\YobitPublicApi;
use OlegStyle\YobitApi\YobitCoin;

$publicApi = new YobitPublicApi();
$yobitCoin = new YobitCoin();


$responseJson_str = file_get_contents('coin.json');
$response = json_decode($responseJson_str, true);

$getNamesPairs = array_keys($publicApi->getPairsBTC($publicApi->getPairs($response)));
$getArrayNames = array_chunk($getNamesPairs, 49);

foreach ($getArrayNames as $item){
    $getStringNamePairs = implode('-', $item);
    //последние сделки
    $getTradesDeals = $publicApi->getTrades($getStringNamePairs);
    //получить активные ордера
    $getActiveOrders = $publicApi->getDepths($getStringNamePairs);

    //получить активные коины
    $getActiveCoin = $yobitCoin->getActiveCoin($getTradesDeals);

    //получить коины которыми закупаются
    $getPumpCoin = $yobitCoin->getPumpCoin($getTradesDeals);

    $echoPumpCoin = $yobitCoin->echoPumpCoin($getPumpCoin);

    $publicApi->flush_buffers();
}




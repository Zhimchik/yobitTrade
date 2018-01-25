<?php

set_time_limit(0);
ini_set('memory_limit', '-1');

require './vendor/autoload.php';
use OlegStyle\YobitApi\YobitPublicApi;

$publicApi = new YobitPublicApi();


$getNamePairs = array_keys($publicApi->getPairsBTC($publicApi->getPairs($publicApi->getInfo())));

foreach ($getNamePairs as $nameParir){
    list($from, $to)= explode('_',$nameParir);

$getOrdersByPair = $publicApi->getTrade($from, $to);

   if(false!=($countTrades = $publicApi->getTradesLastHourByPair($getOrdersByPair))){

       $getBuyOrdersByPair= $publicApi->getDepth($from, $to);

       if(false!=($countBuyOrders = $publicApi->getBuyOrdersByPair($getBuyOrdersByPair))){
           echo "По паре " . strtoupper($from) . "-" . strtoupper($to) ." сделок за последний час - " . count($countTrades) . "  Ордеров на покупку - " . count($countBuyOrders);
           echo '<br>','<br>';
           $publicApi->flush_buffers();
       }
       else{
           continue;
       }
   }
   else continue;

}
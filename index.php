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

   if(count($countTrades = $publicApi->getTradesLastHourByPair($getOrdersByPair)) > 1){

       $getBuyOrdersByPair= $publicApi->getDepth($from, $to);

       if(count($countBuyOrders = $publicApi->getBuyOrdersByPair($getBuyOrdersByPair)) > 1){
           echo "По паре " . strtoupper($from) . "-" . strtoupper($to) ." Закупок подряд - " . count($countTrades) . "  Ордеров на покупку - " . count($countBuyOrders);
           echo '<br>','<br>';
           $publicApi->flush_buffers();
       }
       else{
           $publicApi->flush_buffers();
           continue;
       }
   }
   else {
       $publicApi->flush_buffers();
       continue;
   }

}
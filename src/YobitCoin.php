<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 26.01.18
 * Time: 16:30
 */

namespace OlegStyle\YobitApi;


class YobitCoin
{
    public function getActiveCoin($getTradesDeals)
    {

        $date = date_create();
        $countDeals = [];
        $activeCoin=[];
        foreach ($getTradesDeals as $key => $value) {
            foreach ($value as $v) {
                if ($v['timestamp'] > (date_timestamp_get($date) - 3600)) {
                    $countDeals[$key][] = $v;

                }
                else {
                    break;
                }
            }
            if(count($countDeals[$key]) > 20){

                $activeCoin[$key]= $countDeals[$key];
            }
            else {
                continue;
            }
        }
       return $activeCoin;
    }

    public function getPumpCoin($getActiveCoin)
    {
        $countDealsBuy = [];
        $pumpCoin=[];
        foreach ($getActiveCoin as $key => $deals){
            foreach ($deals as $deal){
                if($deal['type'] == 'bid'){
                    $countDealsBuy[$key][]=$deal;
                }
                else {
                    break;
                }
            }
            if(count($countDealsBuy[$key]) > 3) {
                $pumpCoin[$key]= $countDealsBuy[$key];
            }
        }

        return $pumpCoin;
    }


    public function getActiveOrdersByPump($getPumpCoin)
    {
        $publicApi = new YobitPublicApi();
        if(!empty($getPumpCoin)){
            $coins = array_keys($getPumpCoin);
            $getStringNamePairs = implode('-', $coins);
            $getActiveOrdersByPump = $publicApi->getDepths($getStringNamePairs);

            return $getActiveOrdersByPump;
        }
        else{
            return false;
        }

    }

    public function echoPumpCoin($getPumpCoin, $getActiveOrdersByPump){
        foreach ($getPumpCoin as $coin => $value){
            foreach($getActiveOrdersByPump as $key => $order){
                echo "Активные пары за последний час " . strtoupper($coin) .  " Закупок подряд - " . count($value);
                echo '<br>';
                echo "Ордеров на Продажу " . count($order['asks']);
                echo '<br>';
                echo "Ордеров на Покупку " . count($order['bids']);
                echo '<br>', '<br>';
            }

        }
        return true;
    }

}
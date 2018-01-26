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
                    $countDeals[] = $v;
                }
            }
            if(count($countDeals) > 20){
                $activeCoin[$key]= $countDeals;
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
                if($deal['type'] == 'ask'){
                    $countDealsBuy[$key][]=$deal;
                }
                else {
                    break;
                }
            }

            if(count($countDealsBuy[$key])> 2) {
                $pumpCoin[$key]= $countDealsBuy;
            }
        }
        return $pumpCoin;
    }

    public function echoPumpCoin($getPumpCoin){
        foreach ($getPumpCoin as $coin => $value){
            echo "Активные пары за последний час " . strtoupper($coin) .  " Закупок подряд - " . count($value);
            echo '<br>', '<br>';
        }
        return true;
    }

}
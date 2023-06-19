<?php

namespace App\Services;

use App\Models\Zone;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class ParkingPriceService{
    public static function calculatePrice(int $zone_id, string $startTime, 
    string $stopTime=null):int{
            $start = new Carbon($startTime);

            $stop = (!isNull($stopTime)) ? new Carbon($stopTime) : now();

            $totalTimeByMinutes = $stop->diffInMinutes($start);

            $priceByMinuts = Zone::find($zone_id)->price_per_hour / 60;

            return ceil($totalTimeByMinutes * $priceByMinuts);
    }
}
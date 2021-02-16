<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryTimeFee extends Model
{
    protected $fillable = [
        'delivery_start_time',
        'delivery_end_time',
        'delivery_fee',
        'delivery_fee_for_now',
    ];
}

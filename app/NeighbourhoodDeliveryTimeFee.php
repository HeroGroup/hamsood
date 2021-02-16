<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NeighbourhoodDeliveryTimeFee extends Model
{
    protected $fillable = [
        'neighbourhood_id',
        'delivery_start_time',
        'delivery_end_time',
        'delivery_fee',
        'delivery_fee_for_now',
    ];

    public function neighbourhood()
    {
        return $this->belongsTo(Neighbourhood::class);
    }
}

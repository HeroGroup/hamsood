<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NeighbourhoodDelivery extends Model
{
    protected $fillable = [
        'neighbourhood_id',
        'delivery_time_from',
        'delivery_time_to',
        'delivery_fee'
    ];

    public function neighbourhood()
    {
        return $this->belongsTo(Neighbourhood::class);
    }
}

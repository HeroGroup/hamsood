<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'customer_id',
        'neighbourhood_id',
        'details',
        'is_default'
    ];

    public function neighbourhood()
    {
        return $this->belongsTo(Neighbourhood::class);
    }
}

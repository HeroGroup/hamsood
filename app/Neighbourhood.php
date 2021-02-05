<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neighbourhood extends Model
{
    protected $fillable = [
        'city_id', 'name'
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

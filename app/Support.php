<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'customer_id',
        'message'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
